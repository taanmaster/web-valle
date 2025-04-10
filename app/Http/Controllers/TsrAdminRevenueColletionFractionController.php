<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

//Modelos
use App\Models\TsrAdminRevenueColletionFraction;

use Illuminate\Http\Request;

class TsrAdminRevenueColletionFractionController extends Controller
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
    public function show(TsrAdminRevenueColletionFraction $tsrAdminRevenueColletionFraction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAdminRevenueColletionFraction $tsrAdminRevenueColletionFraction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAdminRevenueColletionFraction $tsrAdminRevenueColletionFraction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fraction = TsrAdminRevenueColletionFraction::findOrFail($id);

        // Finalmente, eliminar la sección
        $fraction->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Fracción eliminada correctamente.');
    }
}
