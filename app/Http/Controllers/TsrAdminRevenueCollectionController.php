<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

use Illuminate\Http\Request;

//Modelos
use App\Models\TsrAdminRevenueColletionSection;
use App\Models\TsrAdminRevenueColletionArticle;

class TsrAdminRevenueCollectionController extends Controller
{
    public function index()
    {

        $sections = TsrAdminRevenueColletionSection::paginate(10);

        return view('tsr_admin_revenue_collection.index')->with('sections', $sections);
    }


    public function create() {}

    public function store(Request $request) {}

    public function show($id)
    {
        $article = TsrAdminRevenueColletionArticle::find($id);

        if (!$article) {
            return redirect()->route('trs_admin_revenue_collection.index')->with('error', 'Artículo no encontrado.');
        }

        $fractions = $article->fractions()->paginate(10);


        return view('tsr_admin_revenue_collection.show')
            ->with('article', $article)
            ->with('fractions', $fractions);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
