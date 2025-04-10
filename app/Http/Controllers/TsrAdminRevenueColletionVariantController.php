<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TsrAdminRevenueColletionVariant;

use Illuminate\Http\Request;

class TsrAdminRevenueColletionVariantController extends Controller
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
    public function show(TsrAdminRevenueColletionVariant $tsrAdminRevenueColletionVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAdminRevenueColletionVariant $tsrAdminRevenueColletionVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAdminRevenueColletionVariant $tsrAdminRevenueColletionVariant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = TsrAdminRevenueColletionVariant::findOrFail($id);

        // Finalmente, eliminar la sección
        $variant->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Variante eliminada correctamente.');
    }
}
