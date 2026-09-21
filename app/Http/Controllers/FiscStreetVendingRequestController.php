<?php

namespace App\Http\Controllers;

use App\Models\FiscStreetVendingRequest;
use Illuminate\Http\Request;
use Session;

class FiscStreetVendingRequestController extends Controller
{
    /**
     * SOLICITUDES DIRECCIÓN DE FISCALIZACIÓN
     */
    public function index(Request $request)
    {
        $query = FiscStreetVendingRequest::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('fiscalizacion.requests.index', [
            'requests' => $requests,
            'breadcrumbTitle' => 'Solicitudes',
            'heading' => 'SOLICITUDES DIRECCIÓN DE FISCALIZACIÓN',
            'subtitle' => 'Gestión de solicitudes enviadas por los ciudadanos',
            'createRoute' => null,
            'filterRoute' => route('fiscalizacion.street_vending_requests.index'),
            'searchPlaceholder' => 'Buscar por folio o nombre...',
            'emptyTitle' => '¡No hay solicitudes de Permiso de Venta en Vía Pública!',
            'emptyText' => 'Las solicitudes aparecerán aquí cuando los ciudadanos las envíen desde el portal.',
            'personLabel' => 'Nombre',
            'dateLabel' => 'Fecha de Solicitud',
            'tramiteLabel' => 'Permiso de Venta en Vía Pública',
            'showRoute' => 'fiscalizacion.street_vending_requests.show',
            'personResolver' => fn ($req) => $req->user->name ?? $req->full_name,
            'dateResolver' => fn ($req) => $req->created_at->format('d/m/Y'),
        ]);
    }

    /**
     * Detalle de la solicitud
     */
    public function show(FiscStreetVendingRequest $fiscRequest)
    {
        $fiscRequest->load(['files', 'user']);

        return view('fiscalizacion.street_vending_requests.show', compact('fiscRequest'));
    }

    /**
     * Actualizar el estatus de la solicitud
     */
    public function updateStatus(Request $request, FiscStreetVendingRequest $fiscRequest)
    {
        $this->validate($request, [
            'status' => 'required|in:nueva_solicitud,inspeccion,aprobada,denegada',
        ]);

        $fiscRequest->update(['status' => $request->status]);

        Session::flash('success', 'Estatus de la solicitud actualizado exitosamente.');

        return redirect()->route('fiscalizacion.street_vending_requests.show', $fiscRequest);
    }
}
