<?php

namespace App\Http\Controllers;

use App\Models\EnvironmentRequest;

class EnvironmentRequestController extends Controller
{
    /**
     * Bandeja de solicitudes de la Dirección de Medio Ambiente.
     */
    public function index()
    {
        return view('environment.requests.index');
    }

    /**
     * Toda la interacción del detalle (estatus, supervisión, evidencia,
     * vale de entrega) vive en el componente Livewire Crud.
     */
    public function show(EnvironmentRequest $environmentRequest)
    {
        return view('environment.requests.show', compact('environmentRequest'));
    }
}
