<?php

namespace App\Http\Controllers;

use App\Models\RegulatoryAgendaDependency;
use Illuminate\Http\Request;

class RegulatoryAgendaDependencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(RegulatoryAgendaDependency $regulatoryAgendaDependency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegulatoryAgendaDependency $regulatoryAgendaDependency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegulatoryAgendaDependency $regulatoryAgendaDependency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dependency = RegulatoryAgendaDependency::find($id);

        // Finalmente, eliminar la dependencia
        $dependency->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Dependencia eliminada correctamente.');
    }
}
