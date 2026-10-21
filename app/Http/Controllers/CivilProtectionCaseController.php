<?php

namespace App\Http\Controllers;

use App\Exports\CivilProtectionValidityExport;
use App\Models\CivilProtectionCase;
use Maatwebsite\Excel\Facades\Excel;

class CivilProtectionCaseController extends Controller
{
    /**
     * Bandeja de seguimiento de trámites
     */
    public function index()
    {
        return view('proteccion_civil.cases.index');
    }

    /**
     * Crear carpeta presencial
     */
    public function create()
    {
        return view('proteccion_civil.cases.create');
    }

    /**
     * Detalle del expediente (consultor o inspector asignado; el componente valida el acceso)
     */
    public function show(CivilProtectionCase $case)
    {
        return view('proteccion_civil.cases.show', compact('case'));
    }

    /**
     * Mis inspecciones asignadas (vista inspector)
     */
    public function inspections()
    {
        return view('proteccion_civil.inspections.index');
    }

    /**
     * Seguimiento de vigencias de opiniones técnicas y permisos emitidos
     */
    public function validity()
    {
        return view('proteccion_civil.validity.index');
    }

    public function exportValidity()
    {
        return Excel::download(new CivilProtectionValidityExport(request('status'), request('search')),
            'vigencias_proteccion_civil_'.now()->format('Y-m-d').'.xlsx');
    }
}
