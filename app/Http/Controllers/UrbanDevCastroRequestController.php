<?php

namespace App\Http\Controllers;

use App\Models\UrbanDevCastroRequest;

class UrbanDevCastroRequestController extends Controller
{
    /**
     * Bandeja de solicitudes de captura de predio (Catastro).
     */
    public function index()
    {
        return view('urban_dev.catastro.index');
    }

    /**
     * Capturar / Ver / Editar la información del predio de una solicitud.
     *
     * El registro siempre existe (se crea automáticamente al generarse la
     * solicitud de Uso de Suelo o Construcción), por lo que "Capturar predio"
     * y "Ver / editar" apuntan a la misma vista; el modo se deriva del estado.
     *
     * Modos del CRUD: 0 = capturar, 1 = ver y editar.
     */
    public function show($id)
    {
        $castro = UrbanDevCastroRequest::with('urbanDevRequest.user')->findOrFail($id);

        $mode = $castro->status === 'completado' ? 1 : 0;

        return view('urban_dev.catastro.show', compact('castro', 'mode'));
    }

    public function destroy($id)
    {
        $resource = UrbanDevCastroRequest::findOrFail($id);
        $resource->delete();

        return redirect()->route('urban_dev.catastro.index')
            ->with('success', 'Registro eliminado correctamente.');
    }
}
