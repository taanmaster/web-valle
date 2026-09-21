<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FiscPublicEventRequest;
use App\Models\FiscPublicEventRequestFile;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class FiscPublicEventRequestController extends Controller
{
    /**
     * Lista de checklist de documentos requeridos (slug => etiqueta)
     */
    protected array $requiredDocs = [
        'sello-transito' => 'Documento con Sello de Aprobación de Tránsito',
        'sello-delegado' => 'Documento de Aprobación del Delegado de la Comunidad',
    ];

    /**
     * Mis Solicitudes - Autorización de Eventos en Vía Pública
     */
    public function index(Request $request)
    {
        $query = FiscPublicEventRequest::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('front.user_profiles.citizen.fiscalizacion.public_event_index', compact('requests'));
    }

    /**
     * Formulario de nueva solicitud
     */
    public function create()
    {
        return view('front.user_profiles.citizen.fiscalizacion.public_event_create');
    }

    /**
     * Guardar nueva solicitud
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'event_type' => 'required|string|max:255',
            'event_date' => 'required|date',
            'responsible_person' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'exact_location' => 'required|string|max:255',
            'requires_street_closure' => 'required|in:1,0',
            'is_in_community' => 'required|in:1,0',
            'documents.sello-transito' => 'nullable|file|max:10240',
            'documents.sello-delegado' => 'nullable|file|max:10240',
        ]);

        $data = $request->only([
            'event_type', 'event_date', 'responsible_person', 'schedule', 'exact_location',
            'requires_street_closure', 'is_in_community',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'nueva_solicitud';

        $publicEventRequest = FiscPublicEventRequest::create($data);

        // Folio de la solicitud
        $publicEventRequest->update(['folio' => 'FISC-AEVP-'.$publicEventRequest->id]);

        // Documentos de la lista de verificación
        foreach ($this->requiredDocs as $slug => $label) {
            if ($request->hasFile('documents.'.$slug)) {
                $file = $request->file('documents')[$slug];
                $extension = $file->getClientOriginalExtension();
                $filename = 'fisc_'.$slug.'_'.time().'_'.Str::random(10).'.'.$extension;
                $filepath = 'fiscalizacion/'.$filename;
                Storage::disk('s3')->put($filepath, file_get_contents($file));

                FiscPublicEventRequestFile::create([
                    'fisc_public_event_request_id' => $publicEventRequest->id,
                    'user_id' => Auth::id(),
                    'name' => $label,
                    'slug' => $slug,
                    'filename' => $filename,
                    'file_extension' => $extension,
                    'filesize' => $file->getSize(),
                    's3_asset_url' => Storage::disk('s3')->url($filepath),
                ]);
            }
        }

        Session::flash('success', 'Tu solicitud de Autorización de Eventos en Vía Pública se ha enviado correctamente.');

        return redirect()->route('citizen.fisc.public_event.index');
    }
}
