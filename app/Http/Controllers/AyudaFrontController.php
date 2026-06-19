<?php

namespace App\Http\Controllers;

use App\Models\Guia;

class AyudaFrontController extends Controller
{
    public function index()
    {
        return view('front.ayuda.index');
    }

    public function show($slug)
    {
        $guia = Guia::where('slug', $slug)->where('mostrar_front', true)->firstOrFail();

        return view('front.ayuda.show', ['guia' => $guia]);
    }
}
