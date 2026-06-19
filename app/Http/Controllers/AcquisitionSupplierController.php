<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierFile;
use App\Models\SupplierApproval;
use App\Models\SupplierMessage;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AcquisitionSupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin_access']);
    }

    /**
     * Muestra todas las solicitudes de alta de proveedor
     */
    public function index(Request $request)
    {
        $query = Supplier::with(['user', 'files'])
            ->orderBy('created_at', 'desc');

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por tipo de persona
        if ($request->filled('person_type')) {
            $query->where('person_type', $request->person_type);
        }

        // Búsqueda por folio, nombre o RFC
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhere('rfc', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('legal_name', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(20);

        return view('acquisitions.suppliers.index', compact('suppliers'));
    }

    /**
     * Muestra el detalle de una solicitud
     */
    public function show($id)
    {
        $supplier = Supplier::with(['user', 'files', 'approval', 'messages'])
            ->findOrFail($id);

        $requiredDocuments = $supplier->getRequiredDocuments();

        return view('acquisitions.suppliers.show', compact('supplier', 'requiredDocuments'));
    }

    /**
     * Actualiza el estado de un documento
     */
    public function updateFileStatus(Request $request, $supplierId, $fileId)
    {
        $request->validate([
            'status' => 'required|in:pendiente,aprobado,rechazado',
            'comments' => 'nullable|string',
        ]);

        $file = SupplierFile::where('supplier_id', $supplierId)
            ->findOrFail($fileId);

        $file->update([
            'status' => $request->status,
            'comments' => $request->comments,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        Session::flash('success', 'El estado del documento se actualizó correctamente.');

        return back();
    }

    /**
     * Guarda las firmas de autorización
     */
    public function saveApprovals(Request $request, $id)
    {
        $request->validate([
            'link_approval' => 'nullable|boolean',
            'link_name' => 'nullable|string|max:255',
            'link_approval_signature' => 'nullable|string',
            'director_approval' => 'nullable|boolean',
            'director_name' => 'nullable|string|max:255',
            'director_approval_signature' => 'nullable|string',
            'comments' => 'nullable|string',
            'approval_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $supplier = Supplier::findOrFail($id);

        // Buscar o crear aprobación
        $approval = SupplierApproval::firstOrNew(['supplier_id' => $supplier->id]);

        // Verificar si ya está bloqueada alguna aprobación
        $linkLocked = $approval->exists && $approval->link_approval && $approval->link_approval_signature;
        $directorLocked = $approval->exists && $approval->director_approval && $approval->director_approval_signature;

        // Subir archivo de aprobación si existe y no está bloqueado
        if ($request->hasFile('approval_file') && !$linkLocked && !$directorLocked) {
            $file = $request->file('approval_file');
            $filename = 'aprobacion_' . $supplier->registration_number . '.pdf';
            $filepath = 'suppliers/' . $supplier->id . '/approvals/' . $filename;
            
            Storage::disk('s3')->put($filepath, file_get_contents($file));
            
            $approval->filename = $filename;
            $approval->filepath = $filepath;
        }

        $approval->supplier_id = $supplier->id;
        $approval->approved_by = Auth::id();
        
        // Solo actualizar si no está bloqueado
        if (!$linkLocked) {
            $approval->link_approval = $request->link_approval ?? false;
            $approval->link_name = $request->link_name;
            $approval->link_approval_signature = $request->link_approval_signature;
        }
        
        if (!$directorLocked) {
            $approval->director_approval = $request->director_approval ?? false;
            $approval->director_name = $request->director_name;
            $approval->director_approval_signature = $request->director_approval_signature;
        }
        
        // Solo actualizar comentarios si ninguno está bloqueado
        if (!$linkLocked && !$directorLocked) {
            $approval->comments = $request->comments;
        }
        
        $approval->save();

        // Si ambas aprobaciones están marcadas, cambiar estado a 'aprobacion'
        if ($approval->link_approval && $approval->director_approval) {
            $supplier->update(['status' => 'pago_pendiente']);

            // Correo al proveedor: pago pendiente (6.6)
            if ($supplier->email) {
                Mail::send('_mail_notifications.citizen.supplier_payment_pending', [
                    'folio' => $supplier->registration_number,
                ], function ($m) use ($supplier) {
                    $m->to($supplier->email)
                      ->subject('Tu solicitud está lista — realiza tu pago de trámite — Folio ' . $supplier->registration_number);
                });
            }

            Session::flash('success', 'El alta de proveedor ha sido aprobada. Ahora debe realizarse el pago.');
        } else {
            Session::flash('success', 'Las autorizaciones se guardaron correctamente y han sido bloqueadas.');
        }

        return back();
    }

    /**
     * Actualiza el estado general del alta
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:solicitud,validacion,aprobacion,pago_pendiente,padron_activo',
            'notes' => 'nullable|string',
        ]);

        $supplier = Supplier::with('user')->findOrFail($id);
        $supplier->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $folio          = $supplier->registration_number;
        $emailProveedor = $supplier->email;

        // Correo al administrativo: solicitud en validación (6.3)
        if ($request->status === 'validacion') {
            Mail::send('_mail_notifications.admin.supplier_validation_pending', [
                'folio' => $folio,
            ], function ($m) use ($folio) {
                $m->to('adquisiciones@valledesantiago.gob.mx')
                  ->subject('Documentos de proveedor en validación — Folio ' . $folio);
            });
        }

        // Correo al proveedor: solicitud aprobada (6.4)
        if ($request->status === 'aprobacion' && $emailProveedor) {
            Mail::send('_mail_notifications.citizen.supplier_request_approved', [
                'folio' => $folio,
            ], function ($m) use ($emailProveedor, $folio) {
                $m->to($emailProveedor)
                  ->subject('Tu solicitud fue aprobada — Folio ' . $folio);
            });
        }

        // Correo al proveedor: pago pendiente (6.6)
        if ($request->status === 'pago_pendiente' && $emailProveedor) {
            Mail::send('_mail_notifications.citizen.supplier_payment_pending', [
                'folio' => $folio,
            ], function ($m) use ($emailProveedor, $folio) {
                $m->to($emailProveedor)
                  ->subject('Tu solicitud está lista — realiza tu pago de trámite — Folio ' . $folio);
            });
        }

        // Correo al proveedor: proceso completado / alta en padrón (6.7)
        if ($request->status === 'padron_activo' && $emailProveedor) {
            Mail::send('_mail_notifications.citizen.supplier_process_completed', [
                'folio' => $folio,
            ], function ($m) use ($emailProveedor, $folio) {
                $m->to($emailProveedor)
                  ->subject('Proceso completo — Folio ' . $folio);
            });
        }

        Session::flash('success', 'El estado del alta se actualizó correctamente.');

        return back();
    }

    /**
     * Lista de proveedores CON padrón
     */
    public function conPadron(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->whereHas('userInfo', function($q) {
            $q->where('additional_data->padron_status', 'con_padron');
        })->with(['userInfo', 'suppliers']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(20);

        return view('acquisitions.suppliers.con_padron', compact('suppliers'));
    }

    /**
     * Lista de proveedores SIN padrón
     */
    public function sinPadron(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->whereHas('userInfo', function($q) {
            $q->where('additional_data->padron_status', 'sin_padron');
        })->with(['userInfo', 'suppliers']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(20);

        return view('acquisitions.suppliers.sin_padron', compact('suppliers'));
    }

    /**
     * Contactar al proveedor (enviar mensaje)
     */
    public function contact(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $supplier = Supplier::with('user')->findOrFail($id);

        // Guardar el mensaje en la base de datos
        SupplierMessage::create([
            'user_id' => $supplier->user_id,
            'supplier_id' => $supplier->id,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        // Correo al proveedor: observación pendiente (6.5)
        if ($supplier->email) {
            Mail::send('_mail_notifications.citizen.supplier_request_observation', [
                'folio' => $supplier->registration_number,
            ], function ($m) use ($supplier) {
                $m->to($supplier->email)
                  ->subject('Tu solicitud requiere una actualización — Folio ' . $supplier->registration_number);
            });
        }

        Session::flash('success', 'El mensaje ha sido enviado y guardado correctamente.');

        return back();
    }
}
