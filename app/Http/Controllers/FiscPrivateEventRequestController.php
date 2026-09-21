<?php

namespace App\Http\Controllers;

use App\Models\FiscPrivateEventRequest;
use Illuminate\Http\Request;
use Session;

class FiscPrivateEventRequestController extends Controller
{
    /**
     * SOLICITUDES DIRECCIÓN DE FISCALIZACIÓN - Eventos Particulares
     */
    public function index(Request $request)
    {
        $query = FiscPrivateEventRequest::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                    ->orWhere('responsible_person', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('fiscalizacion.requests.index', [
            'requests' => $requests,
            'breadcrumbTitle' => 'Eventos Particulares',
            'heading' => 'SOLICITUDES DE EVENTOS PARTICULARES',
            'subtitle' => 'Gestión de solicitudes enviadas por los ciudadanos',
            'createRoute' => null,
            'filterRoute' => route('fiscalizacion.private_event_requests.index'),
            'searchPlaceholder' => 'Buscar por folio o responsable...',
            'emptyTitle' => '¡No hay solicitudes de Autorización de Eventos Particulares!',
            'emptyText' => 'Las solicitudes aparecerán aquí cuando los ciudadanos las envíen desde el portal.',
            'personLabel' => 'Responsable',
            'dateLabel' => 'Fecha del Evento',
            'tramiteLabel' => 'Autorización de Eventos Particulares',
            'showRoute' => 'fiscalizacion.private_event_requests.show',
            'personResolver' => fn ($req) => $req->responsible_person,
            'dateResolver' => fn ($req) => $req->event_date->format('d/m/Y'),
        ]);
    }

    /**
     * Detalle de la solicitud
     */
    public function show(FiscPrivateEventRequest $fiscRequest)
    {
        $fiscRequest->load(['files', 'user']);

        return view('fiscalizacion.private_event_requests.show', compact('fiscRequest'));
    }

    /**
     * Actualizar el estatus de la solicitud
     */
    public function updateStatus(Request $request, FiscPrivateEventRequest $fiscRequest)
    {
        $this->validate($request, [
            'status' => 'required|in:nueva_solicitud,inspeccion,aprobada,denegada',
        ]);

        $fiscRequest->update(['status' => $request->status]);

        Session::flash('success', 'Estatus de la solicitud actualizado exitosamente.');

        return redirect()->route('fiscalizacion.private_event_requests.show', $fiscRequest);
    }
}
