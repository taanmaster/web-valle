<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SupplierEndorsement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AcquisitionEndorsementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin_access']);
    }

    /**
     * Lista de usuarios con refrendos registrados
     */
    public function index(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->whereHas('endorsements')
        ->with(['endorsements' => function($q) {
            $q->orderBy('endorsement_date', 'desc');
        }, 'userInfo'])
        ->withCount('endorsements');

        // Filtro por año
        if ($request->filled('year')) {
            $query->whereHas('endorsements', function($q) use ($request) {
                $q->whereYear('endorsement_date', $request->year);
            });
        }

        // Filtro por estado de aprobación
        if ($request->filled('status')) {
            $isApproved = $request->status === 'approved';
            $query->whereHas('endorsements', function($q) use ($isApproved) {
                $q->where('is_approved', $isApproved);
            });
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20);

        // Años disponibles para el filtro
        $availableYears = SupplierEndorsement::selectRaw('YEAR(endorsement_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('acquisitions.endorsements.index', compact('users', 'availableYears'));
    }

    /**
     * Detalle de refrendos de un usuario específico
     */
    public function show($userId)
    {
        $user = User::with(['endorsements' => function($q) {
            $q->orderBy('endorsement_date', 'desc');
        }, 'userInfo', 'suppliers'])->findOrFail($userId);

        // Agrupar refrendos por año
        $endorsementsByYear = $user->endorsements->groupBy(function($endorsement) {
            return $endorsement->endorsement_date->format('Y');
        });

        return view('acquisitions.endorsements.show', compact('user', 'endorsementsByYear'));
    }

    /**
     * Aprobar o rechazar un refrendo
     */
    public function updateStatus(Request $request, $endorsementId)
    {
        $request->validate([
            'is_approved' => 'required|boolean',
            'comments' => 'nullable|string',
        ]);

        $endorsement = SupplierEndorsement::findOrFail($endorsementId);

        $endorsement->update([
            'is_approved' => $request->is_approved,
            'comments' => $request->comments,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Si se aprueba el refrendo del año actual, actualizar el estado del proveedor
        $currentYear = date('Y');
        if ($request->is_approved && $endorsement->endorsement_date->format('Y') == $currentYear) {
            $user = User::find($endorsement->user_id);
            $userInfo = $user->userInfo;
            
            if ($userInfo) {
                $additionalData = $userInfo->additional_data ?? [];
                $additionalData['padron_status'] = 'con_padron';
                $userInfo->update(['additional_data' => $additionalData]);
                
                Session::flash('success', 'El refrendo ha sido aprobado y el proveedor ahora tiene estatus CON PADRÓN.');
            } else {
                Session::flash('success', 'El refrendo ha sido aprobado.');
            }
        } else {
            $message = $request->is_approved ? 'aprobado' : 'rechazado';
            Session::flash('success', "El refrendo ha sido {$message}.");
        }

        return back();
    }

    /**
     * Asociar un refrendo a un proveedor específico
     */
    public function associateSupplier(Request $request, $endorsementId)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $endorsement = SupplierEndorsement::findOrFail($endorsementId);
        
        $endorsement->update([
            'supplier_id' => $request->supplier_id,
        ]);

        Session::flash('success', 'El refrendo ha sido asociado al proveedor correctamente.');

        return back();
    }
}
