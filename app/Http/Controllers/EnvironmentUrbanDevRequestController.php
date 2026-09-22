<?php

namespace App\Http\Controllers;

use App\Models\UrbanDevRequestReview;

class EnvironmentUrbanDevRequestController extends Controller
{
    /**
     * Bandeja de solicitudes de Desarrollo Urbano enviadas a la Dirección de
     * Medio Ambiente para su Visto Bueno Ambiental.
     */
    public function index()
    {
        return view('environment.urban_dev_requests.index');
    }

    /**
     * Detalle / captura del visto bueno ambiental.
     */
    public function show(UrbanDevRequestReview $review)
    {
        abort_unless($review->dependency === 'medio_ambiente', 404);

        return view('environment.urban_dev_requests.show', compact('review'));
    }
}
