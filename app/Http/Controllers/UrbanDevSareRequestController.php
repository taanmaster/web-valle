<?php

namespace App\Http\Controllers;

use App\Models\SareRequestReview;

class UrbanDevSareRequestController extends Controller
{
    /**
     * Bandeja de solicitudes SARE enviadas a Desarrollo Urbano para revisión.
     */
    public function index()
    {
        return view('urban_dev.sare_requests.index');
    }

    /**
     * Detalle / captura de la revisión: inspección, emisión de permiso y entero de pago.
     */
    public function show(SareRequestReview $review)
    {
        return view('urban_dev.sare_requests.show', compact('review'));
    }
}
