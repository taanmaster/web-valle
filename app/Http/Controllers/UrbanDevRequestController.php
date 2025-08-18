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
        $urban_dev_requests = UrbanDevRequest::with(['user', 'files'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('urban_dev.requests.index')->with('urban_dev_requests', $urban_dev_requests);
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

        // Cargar archivos relacionados
        $urbanDevRequest->load(['files', 'user']);

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
            'status' => 'required|in:new,initial_review,requirement_validation,requires_correction,payment_pending,authorization_process,authorized,rejected',
        ]);

        // Actualizar estatus usando switch para futuras funcionalidades
        switch ($request->status) {
            case 'initial_review':
                $urbanDevRequest->status = 'initial_review';
                break;
            case 'requirement_validation':
                $urbanDevRequest->status = 'requirement_validation';
                break;
            case 'requires_correction':
                $urbanDevRequest->status = 'requires_correction';
                break;
            case 'payment_pending':
                $urbanDevRequest->status = 'payment_pending';
                break;
            case 'authorization_process':
                $urbanDevRequest->status = 'authorization_process';
                break;
            case 'authorized':
                $urbanDevRequest->status = 'authorized';
                break;
            case 'rejected':
                $urbanDevRequest->status = 'rejected';
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
