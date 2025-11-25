<?php

namespace App\Http\Controllers;

use App\Models\AcquisitionMaterial;
use Illuminate\Http\Request;

class AcquisitionMaterialController extends Controller
{

    public function index()
    {
        return view('acquisitions.materials.index');
    }

    public function create()
    {
        return view('acquisitions.materials.create');
    }

    public function show($id)
    {
        $mode = 1;

        $material = AcquisitionMaterial::findOrFail($id);

        return view('acquisitions.materials.show', [
            'mode' => $mode,
            'material' => $material
        ]);
    }

    public function edit($id)
    {
        $mode = 2;

        $material = AcquisitionMaterial::findOrFail($id);

        return view('acquisitions.materials.edit', [
            'mode' => $mode,
            'material' => $material
        ]);
    }

    public function destroy($id)
    {
        $material = AcquisitionMaterial::findOrFail($id);

        $material->delete();

        Session::flash('success', 'El material se elimino correctamente.');

        return redirect()->route('acquisitions.materials.index');
    }
}
