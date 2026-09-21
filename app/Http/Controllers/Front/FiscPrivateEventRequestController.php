<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FiscPrivateEventRequest;
use App\Models\FiscPrivateEventRequestFile;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class FiscPrivateEventRequestController extends Controller
{
    /**
     * Lista de checklist de documentos requeridos (slug => etiqueta)
     */
    protected array $requiredDocs = [
        'comprobante-pago-entero' => 'Comprobante de Pago de Entero',
    ];

    /**
     * Mis Solicitudes - Autorización de Eventos Particulares
     */
    public function index(Request $request)
    {
        $query = FiscPrivateEventRequest::where('user_id', Auth::id());

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

        return view('front.user_profiles.citizen.fiscalizacion.private_event_index', compact('requests'));
    }

    /**
     * Formulario de nueva solicitud
     */
    public function create()
    {
        return view('front.user_profiles.citizen.fiscalizacion.private_event_create');
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
            'venue' => 'required|string|max:255',
            'attendees' => 'nullable|integer|min:0',
            'alcohol_sales' => 'required|in:1,0',
            'documents.comprobante-pago-entero' => 'nullable|file|max:10240',
        ]);

        $data = $request->only([
            'event_type', 'event_date', 'responsible_person', 'schedule', 'venue',
            'attendees', 'alcohol_sales',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'nueva_solicitud';

        $privateEventRequest = FiscPrivateEventRequest::create($data);

        // Folio de la solicitud
        $privateEventRequest->update(['folio' => 'FISC-AEP-'.$privateEventRequest->id]);

        // Documentos de la lista de verificación
        foreach ($this->requiredDocs as $slug => $label) {
            if ($request->hasFile('documents.'.$slug)) {
                $file = $request->file('documents')[$slug];
                $extension = $file->getClientOriginalExtension();
                $filename = 'fisc_'.$slug.'_'.time().'_'.Str::random(10).'.'.$extension;
                $filepath = 'fiscalizacion/'.$filename;
                Storage::disk('s3')->put($filepath, file_get_contents($file));

                FiscPrivateEventRequestFile::create([
                    'fisc_private_event_request_id' => $privateEventRequest->id,
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

        Session::flash('success', 'Tu solicitud de Autorización de Eventos Particulares se ha enviado correctamente.');

        return redirect()->route('citizen.fisc.private_event.index');
    }
}
