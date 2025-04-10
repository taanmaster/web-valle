<?php

namespace App\Http\Controllers;

use App\Models\TsrRevenueLawIncome;
use Illuminate\Http\Request;

class TsrRevenueLawIncomeController extends Controller
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
    public function show(TsrRevenueLawIncome $tsrRevenueLawIncome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrRevenueLawIncome $tsrRevenueLawIncome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrRevenueLawIncome $tsrRevenueLawIncome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $income = TsrRevenueLawIncome::findOrFail($id);

        // Finalmente, eliminar la sección
        $income->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Ingreso eliminado correctamente.');
    }
}
