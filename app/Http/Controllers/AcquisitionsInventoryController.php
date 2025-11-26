<?php

namespace App\Http\Controllers;

use App\Models\AcquisitionInventoryMovement;
use App\Models\AcquisitionMaterial;
use Illuminate\Http\Request;

class AcquisitionsInventoryController extends Controller
{
    public function index ()
    {
        return view('acquisitions.inventory.index');
    }

    public function entrance() {

        return view('acquisitions.inventory.entrance');
    }

    public function exit() {
        return view('acquisitions.inventory.exits');
    }

    public function create($id = null)
    {
        $material = null;

        if ($id) {
            $material = AcquisitionMaterial::findOrFail($id);
        }

        return view('acquisitions.inventory.create', [
            'material' => $material
        ]);
    }

    public function show($id)
    {
        $mode = 1;

        $movement = AcquisitionInventoryMovement::findOrFail($id);

        return view('acquisitions.inventory.show', [
            'movement' => $movement,
            'mode' => $mode
        ]);
    }
}
