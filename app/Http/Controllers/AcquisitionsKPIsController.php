<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Supplier;
use App\Models\SupplierEndorsement;
use App\Models\Bidding;
use App\Models\BiddingContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AcquisitionsKPIsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener fechas del request o establecer valores por defecto
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Validar que las fechas sean válidas
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();

        // ========== PROVEEDORES ==========
        
        // Total de proveedores (usuarios con rol supplier)
        $totalProveedores = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->count();
        
        // Padrones reactivados (refrendos aprobados en el rango de fechas)
        $padronesReactivados = SupplierEndorsement::whereBetween('approved_at', [$startDateCarbon, $endDateCarbon])
            ->where('is_approved', true)
            ->count();
        
        // Padrones próximos a vencer (refrendos del año anterior que no tienen refrendo este año)
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;
        
        // Obtener usuarios con refrendo del año pasado
        $usersWithLastYearEndorsement = SupplierEndorsement::whereYear('endorsement_date', $lastYear)
            ->where('is_approved', true)
            ->pluck('user_id')
            ->unique();
        
        // Filtrar los que NO tienen refrendo este año
        $padronesProximosVencer = User::whereIn('id', $usersWithLastYearEndorsement)
            ->whereDoesntHave('endorsements', function($q) use ($currentYear) {
                $q->whereYear('endorsement_date', $currentYear)
                  ->where('is_approved', true);
            })
            ->count();
        
        // Tiempo promedio de solicitud a padrón activo
        $tiempoPromedioActivacion = Supplier::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->where('status', 'padron_activo')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days');
        $tiempoPromedioActivacion = $tiempoPromedioActivacion ? round($tiempoPromedioActivacion) : 0;
        
        // Solicitudes de alta por estado
        $solicitudQuery = Supplier::whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
        
        $altaSolicitud = (clone $solicitudQuery)->where('status', 'solicitud')->count();
        $altaValidacion = (clone $solicitudQuery)->where('status', 'validacion')->count();
        $altaAprobacion = (clone $solicitudQuery)->where('status', 'aprobacion')->count();
        $altaPagoPendiente = (clone $solicitudQuery)->where('status', 'pago_pendiente')->count();
        $altaPadronActivo = (clone $solicitudQuery)->where('status', 'padron_activo')->count();
        $altaPadronInactivo = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->whereHas('userInfo', function($q) {
            $q->where('additional_data->padron_status', 'sin_padron');
        })->count();
        
        // ========== LICITACIONES ==========
        
        $biddingQuery = Bidding::whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
        
        // Total de licitaciones
        $totalLicitaciones = $biddingQuery->count();
        
        // Contratos cerrados
        $contratosCerrados = (clone $biddingQuery)->where('status', 'Cierre')->count();
        
        // Licitaciones adjudicadas
        $licitacionesAdjudicadas = (clone $biddingQuery)->where('status', 'Adjudicación')->count();
        
        // Licitaciones con contrato
        $licitacionesConContrato = (clone $biddingQuery)->whereHas('contracts')->count();
        
        // Contratos en entregables
        $contratosEntregables = (clone $biddingQuery)->where('status', 'Proceso entregables')->count();
        
        // Licitaciones nuevas
        $licitacionesNuevas = (clone $biddingQuery)->where('status', 'Nueva Licitación')->count();
        
        // Tiempo promedio de cierre
        $tiempoPromedioCierre = (clone $biddingQuery)
            ->where('status', 'Cierre')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days');
        $tiempoPromedioCierre = $tiempoPromedioCierre ? round($tiempoPromedioCierre) : 0;
        
        // Licitaciones por dependencia (top 4 para el gráfico)
        $licitacionesPorDependencia = (clone $biddingQuery)
            ->select('dependency_name', DB::raw('count(*) as total'))
            ->whereNotNull('dependency_name')
            ->groupBy('dependency_name')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();

        return view('acquisitions.kpis.index', compact(
            'startDate',
            'endDate',
            'totalProveedores',
            'padronesReactivados',
            'padronesProximosVencer',
            'tiempoPromedioActivacion',
            'altaSolicitud',
            'altaValidacion',
            'altaAprobacion',
            'altaPagoPendiente',
            'altaPadronActivo',
            'altaPadronInactivo',
            'totalLicitaciones',
            'contratosCerrados',
            'licitacionesAdjudicadas',
            'licitacionesConContrato',
            'contratosEntregables',
            'licitacionesNuevas',
            'tiempoPromedioCierre',
            'licitacionesPorDependencia'
        ));
    }
}
