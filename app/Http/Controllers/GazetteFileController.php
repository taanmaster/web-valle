<?php

namespace App\Http\Controllers;

use App\Models\GazetteFile;
use Illuminate\Http\Request;

class GazetteFileController extends Controller
{
    /* Vinculado a Gazette */
    /*
    * Generalmente las gacetas son de 1 solo documento
    * pero existen casos donde se adjuntas múltiples.
    */


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(GazetteFile $gazetteFile)
    {
        //
    }

    public function edit(GazetteFile $gazetteFile)
    {
        //
    }

    public function update(Request $request, GazetteFile $gazetteFile)
    {
        //
    }

    public function destroy(GazetteFile $gazetteFile)
    {
        //
    }
}
