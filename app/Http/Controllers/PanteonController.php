<?php

namespace App\Http\Controllers;

use App\Models\Panteon;
use Illuminate\Http\Request;

class PanteonController extends Controller
{
    public function index()
    {
        return view('panteones.index');
    }

    public function create()
    {
        return view('panteones.create', [
            'mode' => 0,
        ]);
    }

    public function show($id)
    {
        $panteon = Panteon::findOrFail($id);

        return view('panteones.show', [
            'panteon' => $panteon,
            'mode' => 1,
        ]);
    }

    public function edit($id)
    {
        $panteon = Panteon::findOrFail($id);

        return view('panteones.edit', [
            'panteon' => $panteon,
            'mode' => 2,
        ]);
    }

    public function destroy($id)
    {
        $panteon = Panteon::findOrFail($id);
        $panteon->delete();

        return redirect()->route('panteones.admin.index')->with('success', 'Registro eliminado correctamente.');
    }
}
