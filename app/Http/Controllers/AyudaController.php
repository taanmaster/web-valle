<?php

namespace App\Http\Controllers;

use App\Models\Guia;
use Illuminate\Http\Request;

class AyudaController extends Controller
{
    public function index()
    {
        return view('ayuda.index');
    }

    public function create()
    {
        return view('ayuda.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $guia = Guia::with(['pasos', 'categoria', 'cambios.user'])->findOrFail($id);

        return view('ayuda.show', ['guia' => $guia, 'mode' => 1]);
    }

    public function edit($id)
    {
        $guia = Guia::with(['pasos', 'categoria', 'cambios.user'])->findOrFail($id);

        return view('ayuda.edit', ['guia' => $guia, 'mode' => 2]);
    }

    public function destroy($id)
    {
        Guia::findOrFail($id)->delete();

        return redirect()->route('ayuda.admin.index')->with('success', 'Guía eliminada correctamente.');
    }

    // Portal de guías visible desde admin
    public function guiasIndex()
    {
        return view('ayuda.portal');
    }

    public function guiaDetalle($slug)
    {
        $guia = Guia::where('slug', $slug)->where('mostrar_admin', true)->firstOrFail();

        return view('ayuda.detalle', ['guia' => $guia]);
    }
}
