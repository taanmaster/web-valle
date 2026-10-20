<?php

namespace App\Http\Controllers;

use App\Models\CitizenMessage;
use App\Models\PublicLightingRequest;
use App\Models\PublicLightingRequestFile;
use App\Models\PublicLightingRequestLog;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class PublicLightingRequestController extends Controller
{
    /**
     * Estatus que el personal puede asignar (Recibida es solo el estado inicial)
     */
    protected array $assignableStatuses = [
        'en_atencion' => 'Se están realizando las acciones necesarias para resolverla.',
        'atendida' => 'La acción solicitada ya fue realizada.',
        'cerrada' => 'Se concluyó la petición y se registró el resultado de la atención.',
        'informacion_insuficiente' => 'Se requiere información adicional del ciudadano para continuar.',
    ];

    /**
     * Peticiones Servicio Alumbrado Público
     */
    public function index(Request $request)
    {
        $query = PublicLightingRequest::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('colony', 'like', "%{$search}%")
                    ->orWhere('street', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('public_lighting.requests.index', compact('requests'));
    }

    /**
     * Detalle de la petición
     */
    public function show(PublicLightingRequest $lightingRequest)
    {
        $lightingRequest->load(['files', 'attentionFiles', 'logs.user', 'user']);

        return view('public_lighting.requests.show', [
            'lightingRequest' => $lightingRequest,
            'assignableStatuses' => $this->assignableStatuses,
            'suggestedMessages' => $this->suggestedMessages($lightingRequest),
        ]);
    }

    /**
     * Actualizar estatus y notificar al ciudadano
     */
    public function updateStatus(Request $request, PublicLightingRequest $lightingRequest)
    {
        $this->validate($request, [
            'status' => 'required|in:'.implode(',', array_keys($this->assignableStatuses)),
            'message' => 'required|string|max:5000',
        ]);

        $lightingRequest->update(['status' => $request->status]);

        PublicLightingRequestLog::create([
            'public_lighting_request_id' => $lightingRequest->id,
            'user_id' => Auth::id(),
            'status' => $request->status,
            'message' => $request->message,
        ]);

        // Mensaje al panel de notificaciones del ciudadano
        if ($lightingRequest->user_id) {
            CitizenMessage::create([
                'user_id' => $lightingRequest->user_id,
                'sent_by' => Auth::id(),
                'subject' => 'Petición '.$lightingRequest->folio.' — '.$lightingRequest->status_label,
                'body' => $request->message,
                'related_model_type' => PublicLightingRequest::class,
                'related_model_id' => $lightingRequest->id,
            ]);
        }

        Session::flash('success', 'Estatus actualizado y ciudadano notificado.');

        return redirect()->route('public_lighting.requests.show', $lightingRequest);
    }

    /**
     * Subir evidencia de atención
     */
    public function uploadEvidence(Request $request, PublicLightingRequest $lightingRequest)
    {
        $this->validate($request, [
            'photos' => 'required|array|max:10',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        foreach ($request->file('photos') as $photo) {
            $filename = 'alumbrado_atencion_'.time().'_'.Str::random(10).'.'.$photo->getClientOriginalExtension();
            $filepath = 'alumbrado_publico/'.$filename;
            Storage::disk('s3')->put($filepath, file_get_contents($photo));

            PublicLightingRequestFile::create([
                'public_lighting_request_id' => $lightingRequest->id,
                'user_id' => Auth::id(),
                'type' => 'attention',
                'name' => $photo->getClientOriginalName(),
                'filename' => $filename,
                'file_extension' => $photo->getClientOriginalExtension(),
                'filesize' => $photo->getSize(),
                's3_asset_url' => Storage::disk('s3')->url($filepath),
            ]);
        }

        Session::flash('success', 'Evidencia de atención cargada correctamente.');

        return redirect()->route('public_lighting.requests.show', $lightingRequest);
    }

    /**
     * Mensajes pre-rellenados por estatus (editables antes de enviar)
     */
    private function suggestedMessages(PublicLightingRequest $lightingRequest): array
    {
        $name = Str::of($lightingRequest->full_name)->explode(' ')->first();
        $folio = $lightingRequest->folio;

        return [
            'en_atencion' => "Hola {$name}, tu petición {$folio} de alumbrado público está en atención.",
            'atendida' => "Tu petición {$folio} fue atendida.",
            'cerrada' => "Tu petición {$folio} ha sido cerrada. Gracias por ayudarnos a mejorar el alumbrado de Valle de Santiago.",
            'informacion_insuficiente' => "Hola {$name}, para continuar con tu petición {$folio} necesitamos información adicional: ",
        ];
    }
}
