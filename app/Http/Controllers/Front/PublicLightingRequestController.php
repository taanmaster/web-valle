<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
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
     * Alumbrado Público - Mis Solicitudes (hub)
     */
    public function hub()
    {
        return view('front.user_profiles.citizen.public_lighting.hub');
    }

    /**
     * Mis Solicitudes - Peticiones Servicio Alumbrado Público
     */
    public function index(Request $request)
    {
        $query = PublicLightingRequest::where('user_id', Auth::id());

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

        return view('front.user_profiles.citizen.public_lighting.index', compact('requests'));
    }

    /**
     * Formulario de nueva petición
     */
    public function create()
    {
        return view('front.user_profiles.citizen.public_lighting.create');
    }

    /**
     * Guardar nueva petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'colony' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'nullable|string|max:50',
            'between_streets' => 'nullable|string|max:255',
            'references' => 'nullable|string|max:255',
            'map_url' => 'nullable|string|max:2000',
            'location_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'description' => 'required|string|max:5000',
            'pole_number' => 'nullable|string|max:255',
            'problem_since' => 'nullable|string|max:255',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120',
            'terms_accepted' => 'accepted',
        ]);

        $data = $request->only([
            'full_name', 'phone', 'email',
            'colony', 'street', 'number', 'between_streets', 'references', 'map_url',
            'description', 'pole_number', 'problem_since',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'recibida';
        $data['terms_accepted'] = true;

        if ($request->hasFile('location_photo')) {
            $photo = $request->file('location_photo');
            $filepath = $this->uploadToS3($photo, 'ubicacion');

            $data['location_photo_name'] = $photo->getClientOriginalName();
            $data['location_photo_s3_url'] = Storage::disk('s3')->url($filepath);
        }

        $lightingRequest = PublicLightingRequest::create($data);

        // Folio de la petición
        $lightingRequest->update(['folio' => 'ALUM-'.str_pad($lightingRequest->id, 5, '0', STR_PAD_LEFT)]);

        PublicLightingRequestLog::create([
            'public_lighting_request_id' => $lightingRequest->id,
            'status' => 'recibida',
            'message' => 'Petición ciudadana enviada en línea.',
        ]);

        // Evidencia del problema
        foreach ($request->file('photos', []) as $photo) {
            $filepath = $this->uploadToS3($photo, 'evidencia');

            PublicLightingRequestFile::create([
                'public_lighting_request_id' => $lightingRequest->id,
                'user_id' => Auth::id(),
                'type' => 'citizen',
                'name' => $photo->getClientOriginalName(),
                'filename' => basename($filepath),
                'file_extension' => $photo->getClientOriginalExtension(),
                'filesize' => $photo->getSize(),
                's3_asset_url' => Storage::disk('s3')->url($filepath),
            ]);
        }

        Session::flash('success', 'Tu petición de servicio de alumbrado público se ha enviado correctamente.');

        return redirect()->route('citizen.public_lighting.show', $lightingRequest);
    }

    /**
     * Detalle de la petición
     */
    public function show(PublicLightingRequest $lightingRequest)
    {
        abort_unless($lightingRequest->user_id === Auth::id(), 404);

        $lightingRequest->load('files');

        return view('front.user_profiles.citizen.public_lighting.show', compact('lightingRequest'));
    }

    private function uploadToS3($file, string $prefix): string
    {
        $filename = 'alumbrado_'.$prefix.'_'.time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
        $filepath = 'alumbrado_publico/'.$filename;
        Storage::disk('s3')->put($filepath, file_get_contents($file));

        return $filepath;
    }
}
