<?php

namespace App\Http\Controllers;

use App\Models\MunicipalRegulation;
use Illuminate\Http\Request;

class MunicipalRegulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mode = 0; // List mode

        return view('municipal-regulations.index')->with('mode', $mode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mode = 0; // Create mode
        return view('municipal-regulations.create')->with('mode', $mode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $regulation = MunicipalRegulation::findOrFail($id);
        $mode = 1; // Show mode
        return view('municipal-regulations.show')->with([
            'regulation' => $regulation,
            'mode' => $mode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $regulation = MunicipalRegulation::findOrFail($id);
        $mode = 2; // Edit mode
        return view('municipal-regulations.edit')->with([
            'regulation' => $regulation,
            'mode' => $mode
        ]);
    }


    public function update(Request $request, MunicipalRegulation $municipalRegulation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $municipalRegulation = MunicipalRegulation::findOrFail($id);
        $municipalRegulation->delete();
        return redirect()->route('institucional_development.regulations.index')->with('success', 'Regulación eliminada correctamente.');
    }
}
