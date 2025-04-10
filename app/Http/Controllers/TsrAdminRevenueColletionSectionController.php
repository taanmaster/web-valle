<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TsrAdminRevenueColletionSection;
use App\Models\TsrAdminRevenueColletionArticle;
use App\Models\TsrAdminRevenueColletionClause;
use App\Models\TsrAdminRevenueColletionVariant;

use Illuminate\Http\Request;

class TsrAdminRevenueColletionSectionController extends Controller
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
    public function show(TsrAdminRevenueColletionSection $tsrAdminRevenueColletionSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAdminRevenueColletionSection $tsrAdminRevenueColletionSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAdminRevenueColletionSection $tsrAdminRevenueColletionSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $section = TsrAdminRevenueColletionSection::findOrFail($id);

        // Finalmente, eliminar la sección
        $section->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Sección eliminada correctamente.');
    }
}
