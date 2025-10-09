<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrbanDevRequest;
use App\Models\UrbanDevWorker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UrbanDevKPIsController extends Controller
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

        // Query base para expedientes
        $expedientesQuery = UrbanDevRequest::whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
        
        // Total de expedientes
        $totalExpedientes = $expedientesQuery->count();
        
        // Expedientes por estatus
        $expedientesAbiertos = (clone $expedientesQuery)->whereIn('status', ['new', 'entry', 'validation', 'requires_correction', 'inspection'])->count();
        $expedientesCancelados = (clone $expedientesQuery)->where('status', 'cancelled')->count();
        $expedientesCerrados = (clone $expedientesQuery)->where('status', 'resolved')->count();
        $expedientesEnCorreccion = (clone $expedientesQuery)->where('status', 'requires_correction')->count();
        
        // Expedientes por tipo de licencia
        $licenciaUsoSuelo = (clone $expedientesQuery)->where('request_type', 'uso-de-suelo')->count();
        $constanciaFactibilidad = (clone $expedientesQuery)->where('request_type', 'constancia-de-factibilidad')->count();
        $permisoAnuncios = (clone $expedientesQuery)->where('request_type', 'permiso-de-anuncios')->count();
        $constanciaAlineamiento = (clone $expedientesQuery)->where('request_type', 'certificacion-numero-oficial')->count();
        $permisoDivision = (clone $expedientesQuery)->where('request_type', 'permiso-de-division')->count();
        $usoViaPublica = (clone $expedientesQuery)->where('request_type', 'uso-de-via-publica')->count();
        $licenciaConstruccion = (clone $expedientesQuery)->where('request_type', 'licencia-de-construccion')->count();
        $permisoConstruccionPanteones = (clone $expedientesQuery)->where('request_type', 'permiso-construccion-panteones')->count();
        
        // Cálculo de tiempo promedio de cierre (solo expedientes cerrados)
        $tiempoPromedioCierre = (clone $expedientesQuery)
            ->where('status', 'resolved')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days');
        $tiempoPromedioCierre = $tiempoPromedioCierre ? round($tiempoPromedioCierre) : 0;
        
        // Asignación de expedientes por inspector
        $expedientesPorInspector = (clone $expedientesQuery)
            ->whereNotNull('inspector_id')
            ->select('inspector_id', DB::raw('count(*) as total'))
            ->groupBy('inspector_id')
            ->with('inspector:id,name')
            ->get()
            ->map(function($item) {
                $fullName = 'Sin asignar';
                
                if ($item->inspector) {
                    // Buscar el nombre completo desde urban_dev_workers
                    $worker = UrbanDevWorker::where('dependency_category', 'Desarrollo Urbano')
                        ->where('dependency_subcategory', 'Inspector')
                        ->whereRaw("CONCAT(name, ' ', last_name) = ?", [$item->inspector->name])
                        ->first();
                    
                    $fullName = $worker 
                        ? $worker->name . ' ' . $worker->last_name 
                        : $item->inspector->name;
                }
                
                return [
                    'inspector' => $fullName,
                    'total' => $item->total
                ];
            });
        
        /* ESTO SE TIENE QUE MODIFICAR PARA CONSULTAR LA BASE DE DATOS DE CITATORIOS WIP */
        // CITATORIOS - ESTO SE TIENE QUE MODIFICAR PARA CONSULTAR LA BASE DE DATOS DE CITATORIOS WIP
        $citatoriosQuery = UrbanDevRequest::whereBetween('inspection_start_date', [$startDateCarbon, $endDateCarbon])
            ->whereNotNull('inspection_start_date');
        
        // Total de citatorios
        $totalCitatorios = $citatoriosQuery->count();
        
        // Citatorios por estado
        $citatoriosAbiertos = (clone $citatoriosQuery)->whereIn('status', ['inspection'])->count();
        $citatoriosSuspension = (clone $citatoriosQuery)->where('status', 'cancelled')->count();
        $citatoriosCerrados = (clone $citatoriosQuery)->where('status', 'resolved')->count();
        
        // Tiempo promedio de citatorio
        $tiempoPromedioCitatorio = (clone $citatoriosQuery)
            ->where('status', 'resolved')
            ->whereNotNull('inspection_start_date')
            ->selectRaw('AVG(DATEDIFF(updated_at, inspection_start_date)) as avg_days')
            ->value('avg_days');
        $tiempoPromedioCitatorio = $tiempoPromedioCitatorio ? round($tiempoPromedioCitatorio) : 0;
        
        // Tasa de citatorios a suspensión
        $tasaSuspension = $totalCitatorios > 0 ? round(($citatoriosSuspension / $totalCitatorios) * 100, 1) : 0;
        
        // Citatorios por inspector
        $citatoriosPorInspector = (clone $citatoriosQuery)
            ->whereNotNull('inspector_id')
            ->select('inspector_id', DB::raw('count(*) as total'))
            ->groupBy('inspector_id')
            ->with('inspector:id,name')
            ->get()
            ->map(function($item) {
                $fullName = 'Sin asignar';
                
                if ($item->inspector) {
                    // Buscar el nombre completo desde urban_dev_workers
                    $worker = UrbanDevWorker::where('dependency_category', 'Desarrollo Urbano')
                        ->where('dependency_subcategory', 'Inspector')
                        ->whereRaw("CONCAT(name, ' ', last_name) = ?", [$item->inspector->name])
                        ->first();
                    
                    $fullName = $worker 
                        ? $worker->name . ' ' . $worker->last_name 
                        : $item->inspector->name;
                }
                
                return [
                    'inspector' => $fullName,
                    'total' => $item->total
                ];
            });

        // ESTO SE TIENE QUE MODIFICAR PARA CONSULTAR LA BASE DE DATOS DE CITATORIOS WIP
        /////

        return view('urban_dev.kpis.index', compact(
            'startDate',
            'endDate',
            'totalExpedientes',
            'expedientesAbiertos',
            'expedientesCancelados',
            'expedientesCerrados',
            'expedientesEnCorreccion',
            'licenciaUsoSuelo',
            'constanciaFactibilidad',
            'permisoAnuncios',
            'constanciaAlineamiento',
            'permisoDivision',
            'usoViaPublica',
            'licenciaConstruccion',
            'permisoConstruccionPanteones',
            'tiempoPromedioCierre',
            'expedientesPorInspector',
            'totalCitatorios',
            'citatoriosAbiertos',
            'citatoriosSuspension',
            'citatoriosCerrados',
            'tiempoPromedioCitatorio',
            'tasaSuspension',
            'citatoriosPorInspector'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
