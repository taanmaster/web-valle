<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\UrbanDevRequest;
use App\Models\UrbanDevRequestFile;
use App\Models\User;

use Illuminate\Http\Request;

class UrbanDevRequestController extends Controller
{
    public function index()
    {
        $urban_dev_requests = UrbanDevRequest::with(['user', 'files', 'inspector'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('urban_dev.requests.index')->with('urban_dev_requests', $urban_dev_requests);
    }

    public function query(Request $request)
    {
        $query = UrbanDevRequest::with(['user', 'files', 'inspector']);

        // Filtro por rango de fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Filtro por folio (puede ser cualquiera de las dos referencias de pago)
        if ($request->filled('folio')) {
            $query->where(function($q) use ($request) {
                $q->where('payment_ref_number_1', 'LIKE', '%' . $request->folio . '%')
                  ->orWhere('payment_ref_number_2', 'LIKE', '%' . $request->folio . '%')
                  ->orWhere('inspector_license_number', 'LIKE', '%' . $request->folio . '%');
            });
        }

        // Filtro por nombre del solicitante
        if ($request->filled('solicitante')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->solicitante . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->solicitante . '%');
            });
        }

        // Filtro por estatus
        if ($request->filled('estatus')) {
            $query->where('status', $request->estatus);
        }

        // Filtro por tipo de trámite
        if ($request->filled('tipo_tramite')) {
            $query->where('request_type', $request->tipo_tramite);
        }

        // Filtro por inspector
        if ($request->filled('inspector')) {
            $query->where('inspector_id', $request->inspector);
        }

        $urban_dev_requests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('urban_dev.requests.query')->with('urban_dev_requests', $urban_dev_requests);
    }

    public function create()
    {
        return view('urban_dev_requests.create');
    }

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'request_type' => 'required|in:uso_suelo,constancia_factibilidad,permiso_anuncios,certificacion_numero_oficial,permiso_division,uso_via_publica,licencia_construccion,permiso_construccion_panteones,general',
            'description' => 'nullable|string',
        ]);

        // Guardar datos en la base de datos
        $urban_dev_request = UrbanDevRequest::create([
            'user_id' => Auth::id(),
            'status' => $request->status ?? 'new',
            'request_type' => $request->request_type,
            'description' => $request->description,
        ]);

        // Mensaje de session
        Session::flash('success', 'Solicitud de Desarrollo Urbano guardada correctamente.');

        // Enviar a vista
        return redirect()->route('citizen.profile.requests');
    }

    public function show($id)
    {
        $urbanDevRequest = UrbanDevRequest::findOrFail($id);

        // Cargar archivos relacionados y el inspector
        $urbanDevRequest->load(['files', 'user', 'inspector']);

        return view('urban_dev.requests.show', compact('urbanDevRequest'));
    }

    public function edit($id)
    {
        $urbanDevRequest = UrbanDevRequest::findOrFail($id);

        return view('urban_dev_requests.edit')->with('urban_dev_request', $urbanDevRequest);
    }

    public function update(Request $request, $id)
    {
        $urbanDevRequest = UrbanDevRequest::findOrFail($id);

        // Validar
        $this->validate($request, [
            'status' => 'required|in:new,entry,validation,requires_correction,inspection,resolved',
        ]);

        // Actualizar estatus usando switch para futuras funcionalidades
        switch ($request->status) {
            case 'entry':
                $urbanDevRequest->status = 'entry';
                break;
            case 'validation':
                $urbanDevRequest->status = 'validation';
                break;
            case 'requires_correction':
                $urbanDevRequest->status = 'requires_correction';
                break;
            case 'inspection':
                $urbanDevRequest->status = 'inspection';
                break;
            case 'resolved':
                $urbanDevRequest->status = 'resolved';
                break;
            default:
                $urbanDevRequest->status = 'new';
                break;
        }

        $urbanDevRequest->save();

        // Mensaje de session
        Session::flash('success', 'Estatus de solicitud de Desarrollo Urbano actualizado exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function updateDetails(Request $request, $id)
    {
        $urbanDevRequest = UrbanDevRequest::findOrFail($id);

        // Validar los campos adicionales
        $this->validate($request, [
            'inspector_id' => 'nullable|exists:users,id',
            'inspection_start_date' => 'nullable|date',
            'inspector_license_number' => 'nullable|string|max:255',
            'building_type' => 'nullable|in:casa_habitacion,bodega,local_comercial,otro',
            'payment_date' => 'nullable|date',
            'payment_ref_number_1' => 'nullable|string|max:255',
            'payment_ref_number_2' => 'nullable|string|max:255',
            'payment_amount' => 'nullable|numeric|min:0',
            'inspection_validity_start' => 'nullable|date',
            'inspection_validity_end' => 'nullable|date|after_or_equal:inspection_validity_start',
        ]);

        // Actualizar los campos
        $urbanDevRequest->update([
            'inspector_id' => $request->inspector_id,
            'inspection_start_date' => $request->inspection_start_date,
            'inspector_license_number' => $request->inspector_license_number,
            'building_type' => $request->building_type,
            'payment_date' => $request->payment_date,
            'payment_ref_number_1' => $request->payment_ref_number_1,
            'payment_ref_number_2' => $request->payment_ref_number_2,
            'payment_amount' => $request->payment_amount,
            'inspection_validity_start' => $request->inspection_validity_start,
            'inspection_validity_end' => $request->inspection_validity_end,
        ]);

        Session::flash('success', 'Información adicional actualizada exitosamente.');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $urbanDevRequest = UrbanDevRequest::findOrFail($id);

        // Eliminar archivos asociados
        $urbanDevRequest->files->each(function ($file) {
            $file->delete();
        });

        // Eliminar la solicitud
        $urbanDevRequest->delete();

        Session::flash('success', 'Se eliminó la solicitud de manera exitosa.');
        return redirect()->back();
    }
}
