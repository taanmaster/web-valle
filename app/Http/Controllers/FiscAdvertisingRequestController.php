<?php

namespace App\Http\Controllers;

use App\Models\FiscAdvertisingRequest;
use App\Models\FiscAdvertisingRequestFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class FiscAdvertisingRequestController extends Controller
{
    /**
     * Lista de checklist de documentos requeridos (slug => etiqueta)
     */
    protected array $requiredDocs = [
        'comprobante-pago' => 'Comprobante de pago',
    ];

    /**
     * SOLICITUDES DIRECCIÓN DE FISCALIZACIÓN - Publicidad en Vía Pública
     *
     * Este trámite se captura únicamente por el personal de Fiscalización,
     * ya que el ciudadano acude en persona con su material publicitario.
     */
    public function index(Request $request)
    {
        $query = FiscAdvertisingRequest::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                    ->orWhere('advertising_type', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('fiscalizacion.requests.index', [
            'requests' => $requests,
            'breadcrumbTitle' => 'Publicidad en Vía Pública',
            'heading' => 'SOLICITUDES DE PUBLICIDAD EN VÍA PÚBLICA',
            'subtitle' => 'Trámite de captura exclusiva de Fiscalización',
            'createRoute' => route('fiscalizacion.advertising_requests.create'),
            'createLabel' => 'Nueva Solicitud',
            'filterRoute' => route('fiscalizacion.advertising_requests.index'),
            'searchPlaceholder' => 'Buscar por folio o tipo de publicidad...',
            'emptyTitle' => '¡No hay solicitudes de Permiso de Publicidad en Vía Pública!',
            'emptyText' => 'Captura una nueva solicitud cuando un ciudadano acuda con su material publicitario.',
            'personLabel' => 'Ciudadano',
            'dateLabel' => 'Fecha de Captura',
            'tramiteLabel' => 'Permiso de Publicidad en Vía Pública',
            'showRoute' => 'fiscalizacion.advertising_requests.show',
            'personResolver' => fn ($req) => $req->user->name ?? '—',
            'dateResolver' => fn ($req) => $req->created_at->format('d/m/Y'),
        ]);
    }

    /**
     * Formulario de captura (exclusivo de Fiscalización)
     */
    public function create()
    {
        return view('fiscalizacion.advertising_requests.create');
    }

    /**
     * Guardar la solicitud capturada a nombre del ciudadano
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'citizen_email' => 'required|email',
            'advertising_type' => 'required|string|max:255',
            'authorized_pieces' => 'nullable|string|max:255',
            'authorized_locations' => 'nullable|string|max:255',
            'authorized_period' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'documents.comprobante-pago' => 'nullable|file|max:10240',
        ]);

        $citizen = User::where('email', $request->citizen_email)->first();

        if (! $citizen || ! $citizen->hasRole('citizen')) {
            return redirect()->back()->withInput()
                ->withErrors(['citizen_email' => 'No se encontró un ciudadano registrado con ese correo.']);
        }

        $data = $request->only([
            'advertising_type', 'authorized_pieces', 'authorized_locations', 'authorized_period', 'description',
        ]);

        $data['user_id'] = $citizen->id;
        $data['status'] = 'nueva_solicitud';

        $advertisingRequest = FiscAdvertisingRequest::create($data);

        // Folio de la solicitud
        $advertisingRequest->update(['folio' => 'FISC-PPVP-'.$advertisingRequest->id]);

        // Documentos de la lista de verificación
        foreach ($this->requiredDocs as $slug => $label) {
            if ($request->hasFile('documents.'.$slug)) {
                $file = $request->file('documents')[$slug];
                $extension = $file->getClientOriginalExtension();
                $filename = 'fisc_'.$slug.'_'.time().'_'.Str::random(10).'.'.$extension;
                $filepath = 'fiscalizacion/'.$filename;
                Storage::disk('s3')->put($filepath, file_get_contents($file));

                FiscAdvertisingRequestFile::create([
                    'fisc_advertising_request_id' => $advertisingRequest->id,
                    'user_id' => $citizen->id,
                    'name' => $label,
                    'slug' => $slug,
                    'filename' => $filename,
                    'file_extension' => $extension,
                    'filesize' => $file->getSize(),
                    's3_asset_url' => Storage::disk('s3')->url($filepath),
                ]);
            }
        }

        Session::flash('success', 'Solicitud de Permiso de Publicidad en Vía Pública capturada exitosamente.');

        return redirect()->route('fiscalizacion.advertising_requests.show', $advertisingRequest);
    }

    /**
     * Detalle de la solicitud
     */
    public function show(FiscAdvertisingRequest $fiscRequest)
    {
        $fiscRequest->load(['files', 'user']);

        return view('fiscalizacion.advertising_requests.show', compact('fiscRequest'));
    }

    /**
     * Actualizar el estatus de la solicitud
     */
    public function updateStatus(Request $request, FiscAdvertisingRequest $fiscRequest)
    {
        $this->validate($request, [
            'status' => 'required|in:nueva_solicitud,inspeccion,aprobada,denegada',
        ]);

        $fiscRequest->update(['status' => $request->status]);

        Session::flash('success', 'Estatus de la solicitud actualizado exitosamente.');

        return redirect()->route('fiscalizacion.advertising_requests.show', $fiscRequest);
    }
}
