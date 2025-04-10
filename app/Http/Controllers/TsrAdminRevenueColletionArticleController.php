<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TsrAdminRevenueColletionArticle;
use App\Models\TsrAdminRevenueColletionClause;
use App\Models\TsrAdminRevenueColletionVariant;

use Illuminate\Http\Request;

class TsrAdminRevenueColletionArticleController extends Controller
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
    public function show(TsrAdminRevenueColletionArticle $tsrAdminRevenueColletionArticle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAdminRevenueColletionArticle $tsrAdminRevenueColletionArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAdminRevenueColletionArticle $tsrAdminRevenueColletionArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = TsrAdminRevenueColletionArticle::findOrFail($id);

        // Finalmente, eliminar la sección
        $article->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Articulo eliminado correctamente.');
    }
}
