<?php

namespace App\Http\Controllers;

use App\Models\MunicipalInspection;
use Illuminate\Http\Request;

class MunicipalInspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mode = 0; // List mode

        return view('municipal_inspections.index')->with('mode', $mode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mode = 0; // Create mode
        return view('municipal_inspections.create')->with('mode', $mode);
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
        $inspection = MunicipalInspection::findOrFail($id);
        $mode = 1; // Show mode
        return view('municipal_inspections.show')->with([
            'inspection' => $inspection,
            'mode' => $mode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inspection = MunicipalInspection::findOrFail($id);
        $mode = 2; // Edit mode
        return view('municipal_inspections.edit')->with([
            'inspection' => $inspection,
            'mode' => $mode
        ]);
    }


    public function update(Request $request, MunicipalInspection $municipalInspection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inspection = MunicipalInspection::findOrFail($id);
        $inspection->delete();

        return redirect()->route('institucional_development.regulations.index')->with('success', 'Regulación eliminada correctamente.');
    }
}
