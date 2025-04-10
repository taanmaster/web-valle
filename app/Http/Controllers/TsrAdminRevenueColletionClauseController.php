<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

//Modelos
use App\Models\TsrAdminRevenueColletionClause;
use Illuminate\Http\Request;

class TsrAdminRevenueColletionClauseController extends Controller
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
    public function show(TsrAdminRevenueColletionClause $tsrAdminRevenueColletionClause)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAdminRevenueColletionClause $tsrAdminRevenueColletionClause)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAdminRevenueColletionClause $tsrAdminRevenueColletionClause)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $clause = TsrAdminRevenueColletionClause::findOrFail($id);

        // Finalmente, eliminar la sección
        $clause->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Clausula eliminada correctamente.');
    }
}
