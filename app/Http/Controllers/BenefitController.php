<?php

namespace App\Http\Controllers;

use App\Models\Benefit;

class BenefitController extends Controller
{
    public function index()
    {
        return view('benefits.index');
    }

    public function create()
    {
        return view('benefits.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = Benefit::with('images')->findOrFail($id);

        return view('benefits.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = Benefit::with('images')->findOrFail($id);

        return view('benefits.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function destroy($id)
    {
        Benefit::findOrFail($id)->delete();

        return redirect()->route('benefits.admin.index')
            ->with('success', 'Beneficio eliminado correctamente.');
    }

    // Portal de Mis Beneficios (vista front dentro del admin)
    public function portal()
    {
        return view('benefits.portal');
    }

    public function detail($slug)
    {
        $entry = Benefit::with('images')
            ->where('slug', $slug)
            ->whereDate('published_at', '<=', now())
            ->firstOrFail();

        return view('benefits.detail', ['entry' => $entry]);
    }
}
