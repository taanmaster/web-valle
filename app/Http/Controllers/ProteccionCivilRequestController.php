<?php

namespace App\Http\Controllers;

use App\Models\UrbanDevRequestReview;

class ProteccionCivilRequestController extends Controller
{
    /**
     * Bandeja de solicitudes de Desarrollo Urbano enviadas a Protección Civil
     * para su Opinión Técnica de Factibilidad.
     */
    public function index()
    {
        return view('proteccion_civil.requests.index');
    }

    /**
     * Detalle / captura de la opinión técnica.
     */
    public function show(UrbanDevRequestReview $review)
    {
        abort_unless($review->dependency === 'proteccion_civil', 404);

        return view('proteccion_civil.requests.show', compact('review'));
    }
}
