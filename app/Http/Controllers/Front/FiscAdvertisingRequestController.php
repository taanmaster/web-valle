<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FiscAdvertisingRequest;
use Auth;
use Illuminate\Http\Request;

class FiscAdvertisingRequestController extends Controller
{
    /**
     * Mis Solicitudes - Permiso de Publicidad en Vía Pública (solo lectura)
     *
     * Este trámite se captura únicamente por el personal de Fiscalización en
     * el back office; el ciudadano solo puede consultar el estatus de las
     * solicitudes que se hayan capturado a su nombre.
     */
    public function index(Request $request)
    {
        $query = FiscAdvertisingRequest::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('front.user_profiles.citizen.fiscalizacion.advertising_index', compact('requests'));
    }
}
