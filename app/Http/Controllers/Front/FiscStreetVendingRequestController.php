<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FiscStreetVendingRequest;
use App\Models\FiscStreetVendingRequestFile;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class FiscStreetVendingRequestController extends Controller
{
    /**
     * Lista de checklist de documentos requeridos (slug => etiqueta)
     */
    protected array $requiredDocs = [
        'ine-frente' => 'INE - Frente',
        'ine-reverso' => 'INE - Reverso',
        'comprobante-domicilio' => 'Comprobante de Domicilio',
    ];

    /**
     * Fiscalización - Mis Solicitudes (hub con las 4 tarjetas de trámites)
     */
    public function hub()
    {
        return view('front.user_profiles.citizen.fiscalizacion.hub');
    }

    /**
     * Mis Solicitudes - Permiso de Venta en Vía Pública
     */
    public function index(Request $request)
    {
        $query = FiscStreetVendingRequest::where('user_id', Auth::id());

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

        return view('front.user_profiles.citizen.fiscalizacion.street_vending_index', compact('requests'));
    }

    /**
     * Formulario de nueva solicitud
     */
    public function create()
    {
        return view('front.user_profiles.citizen.fiscalizacion.street_vending_create');
    }

    /**
     * Guardar nueva solicitud
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'installation_type' => 'required|string|max:255',
            'front_meters' => 'nullable|string|max:50',
            'depth_meters' => 'nullable|string|max:50',
            'awning_qty' => 'nullable|integer|min:0',
            'cart_qty' => 'nullable|integer|min:0',
            'table_qty' => 'nullable|integer|min:0',
            'chairs_qty' => 'nullable|integer|min:0',
            'option1_street' => 'required|string|max:255',
            'option1_between_streets' => 'nullable|string|max:255',
            'option1_photo' => 'nullable|image|max:5120',
            'option2_street' => 'nullable|string|max:255',
            'option2_photo' => 'nullable|image|max:5120',
            'option3_street' => 'nullable|string|max:255',
            'option3_photo' => 'nullable|image|max:5120',
            'work_days' => 'nullable|array',
            'schedule_from' => 'nullable|string|max:10',
            'schedule_to' => 'nullable|string|max:10',
            'documents.ine-frente' => 'nullable|file|max:10240',
            'documents.ine-reverso' => 'nullable|file|max:10240',
            'documents.comprobante-domicilio' => 'nullable|file|max:10240',
        ]);

        $data = $request->only([
            'full_name', 'phone', 'address',
            'business_type', 'installation_type',
            'front_meters', 'depth_meters',
            'awning_qty', 'cart_qty', 'table_qty', 'chairs_qty',
            'option1_street', 'option1_between_streets',
            'option2_street',
            'option3_street',
            'schedule_from', 'schedule_to',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'nueva_solicitud';
        $data['work_days'] = $request->has('work_days') ? implode(',', $request->work_days) : null;

        // Fotografías de los espacios solicitados
        foreach (['option1', 'option2', 'option3'] as $option) {
            if ($request->hasFile($option.'_photo')) {
                $photo = $request->file($option.'_photo');
                $filename = 'fisc_'.$option.'_'.time().'_'.Str::random(10).'.'.$photo->getClientOriginalExtension();
                $filepath = 'fiscalizacion/'.$filename;
                Storage::disk('s3')->put($filepath, file_get_contents($photo));

                $data[$option.'_photo_name'] = $photo->getClientOriginalName();
                $data[$option.'_photo_s3_url'] = Storage::disk('s3')->url($filepath);
            }
        }

        $streetVendingRequest = FiscStreetVendingRequest::create($data);

        // Folio de la solicitud
        $streetVendingRequest->update(['folio' => 'FISC-VVP-'.$streetVendingRequest->id]);

        // Documentos de la lista de verificación
        foreach ($this->requiredDocs as $slug => $label) {
            if ($request->hasFile('documents.'.$slug)) {
                $file = $request->file('documents')[$slug];
                $extension = $file->getClientOriginalExtension();
                $filename = 'fisc_'.$slug.'_'.time().'_'.Str::random(10).'.'.$extension;
                $filepath = 'fiscalizacion/'.$filename;
                Storage::disk('s3')->put($filepath, file_get_contents($file));

                FiscStreetVendingRequestFile::create([
                    'fisc_street_vending_request_id' => $streetVendingRequest->id,
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

        Session::flash('success', 'Tu solicitud de Permiso de Venta en Vía Pública se ha enviado correctamente.');

        return redirect()->route('citizen.fisc.street_vending.index');
    }
}
