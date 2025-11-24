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
        return view('acquisitions.materials.show');
    }

    public function edit($id)
    {
        return view('acquisitions.materials.edit');
    }

    public function destroy($id)
    {
        $material = AcquisitionMaterial::findOrFail($id);

        $material->delete();

        Session::flash('success', 'El material se elimino correctamente.');

        return redirect()->route('acquisitions.materials.index');
    }
}
