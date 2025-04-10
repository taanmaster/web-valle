<?php

namespace App\Http\Controllers;

use App\Models\TsrRevenueLawConcept;
use Illuminate\Http\Request;

class TsrRevenueLawConceptController extends Controller
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
    public function show(TsrRevenueLawConcept $tsrRevenueLawConcept)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrRevenueLawConcept $tsrRevenueLawConcept)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrRevenueLawConcept $tsrRevenueLawConcept)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $concept = TsrRevenueLawConcept::findOrFail($id);

        // Finalmente, eliminar la sección
        $concept->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Concepto eliminado correctamente.');
    }
}
