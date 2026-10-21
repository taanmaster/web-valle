<?php

namespace App\Http\Controllers;

use App\Models\CivilProtectionProcedure;

class CivilProtectionProcedureController extends Controller
{
    /**
     * Catálogo de trámites de Protección Civil
     */
    public function index()
    {
        $procedures = CivilProtectionProcedure::withCount('requirements')
            ->orderBy('name')
            ->get();

        return view('proteccion_civil.procedures.index', compact('procedures'));
    }

    public function create()
    {
        return view('proteccion_civil.procedures.form', ['procedure' => null]);
    }

    public function edit(CivilProtectionProcedure $procedure)
    {
        return view('proteccion_civil.procedures.form', compact('procedure'));
    }
}
