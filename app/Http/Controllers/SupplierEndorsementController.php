<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierEndorsement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SupplierEndorsementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:supplier']);
    }

    /**
     * Muestra el listado de refrendos del usuario
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obtener todos los suppliers del usuario (para poder asociar refrendos después)
        $suppliers = Supplier::where('user_id', $user->id)->get();

        // Obtener todos los refrendos del usuario agrupados por año
        $endorsements = SupplierEndorsement::where('user_id', $user->id)
            ->with('supplier')
            ->orderBy('endorsement_date', 'desc')
            ->get()
            ->groupBy('year');

        // Generar lista de años disponibles (año anterior, año actual y próximos 5 años)
        $currentYear = date('Y');
        $availableYears = range($currentYear - 1, $currentYear + 5);

        return view('front.user_profiles.supplier.endorsement_list', compact('endorsements', 'suppliers', 'availableYears'));
    }

    /**
     * Almacena un nuevo refrendo vinculado al usuario autenticado
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'year' => 'required|integer|min:' . (date('Y') - 1) . '|max:' . (date('Y') + 5),
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
        ], [
            'year.required' => 'Debes seleccionar un año.',
            'year.min' => 'El año debe ser al menos ' . (date('Y') - 1) . '.',
            'year.max' => 'El año no puede ser mayor a ' . (date('Y') + 5) . '.',
            'file.required' => 'Debes adjuntar el comprobante de pago.',
            'file.mimes' => 'El archivo debe ser PDF, JPG o PNG.',
            'file.max' => 'El archivo no debe superar 10MB.',
        ]);

        // Verificar si ya existe un refrendo para ese año del usuario
        $existingEndorsement = SupplierEndorsement::where('user_id', $user->id)
            ->whereYear('endorsement_date', $request->year)
            ->first();

        if ($existingEndorsement) {
            return back()->withErrors([
                'year' => 'Ya existe un refrendo para el año ' . $request->year . '.'
            ])->withInput();
        }

        // Subir archivo a S3
        if ($request->hasFile('file')) {
            $document = $request->file('file');
            $filename = 'refrendo_user_' . $user->id . '_' . $request->year . '.' . $document->getClientOriginalExtension();
            $filepath = 'endorsements/' . $user->id . '/' . $filename;

            // Guardar en S3
            Storage::disk('s3')->put($filepath, file_get_contents($document));

            // Crear registro de refrendo vinculado al usuario
            SupplierEndorsement::create([
                'user_id' => $user->id,
                'supplier_id' => null, // Se puede asociar después
                'endorsement_type' => 'anual',
                'endorsement_date' => $request->year . '-01-01', // Primer día del año
                'filename' => $filename,
                'filepath' => $filepath,
                'is_approved' => false,
            ]);

            Session::flash('success', 'El refrendo para el año ' . $request->year . ' se registró correctamente y está pendiente de aprobación.');
        }

        return redirect()->route('supplier.endorsement.index');
    }

    /**
     * Elimina un refrendo del usuario
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        $endorsement = SupplierEndorsement::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Solo se puede eliminar si no está aprobado
        if ($endorsement->is_approved) {
            Session::flash('error', 'No se puede eliminar un refrendo aprobado.');
            return redirect()->route('supplier.endorsement.index');
        }

        // Eliminar archivo de S3
        if ($endorsement->filepath) {
            Storage::disk('s3')->delete($endorsement->filepath);
        }

        $endorsement->delete();

        Session::flash('success', 'El refrendo se eliminó correctamente.');

        return redirect()->route('supplier.endorsement.index');
    }
}

