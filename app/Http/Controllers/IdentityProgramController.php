<?php

namespace App\Http\Controllers;

use App\Models\IdentityProgram;

class IdentityProgramController extends Controller
{
    public function index()
    {
        return view('identity-program.index');
    }

    public function create()
    {
        return view('identity-program.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = IdentityProgram::with('images')->findOrFail($id);

        return view('identity-program.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = IdentityProgram::with('images')->findOrFail($id);

        return view('identity-program.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function destroy($id)
    {
        IdentityProgram::findOrFail($id)->delete();

        return redirect()->route('identity_program.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    // Portal del Programa de Identidad (vista front dentro del admin)
    public function portal()
    {
        return view('identity-program.portal');
    }

    public function detail($slug)
    {
        $entry = IdentityProgram::with('images')
            ->where('slug', $slug)
            ->whereDate('published_at', '<=', now())
            ->firstOrFail();

        return view('identity-program.detail', ['entry' => $entry]);
    }
}
