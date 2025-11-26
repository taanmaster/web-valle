<?php

namespace App\Http\Controllers;

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

    public function create()
    {



        return view('acquisitions.inventory.create');
    }
}
