<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

//Modelos
use App\Models\RegulatoryAgendaDependency;
use App\Models\SimplificationAgenda;
use Illuminate\Http\Request;

class SimplificationAgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $simplification = null;

        $dependency = RegulatoryAgendaDependency::find($id);

        $mode = 0;

        return view('simplification_agenda.create')->with('simplification', $simplification)->with('dependency', $dependency)->with('mode', $mode);
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
        $simplification = SimplificationAgenda::find($id);

        $dependency = RegulatoryAgendaDependency::find($simplification->dependency_id);

        $mode = 1;

        return view('simplification_agenda.create')->with('simplification', $simplification)->with('dependency', $dependency)->with('mode', $mode);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $simplification = SimplificationAgenda::find($id);

        $dependency = RegulatoryAgendaDependency::find($simplification->dependency_id);

        $mode = 2;

        return view('simplification_agenda.create')->with('simplification', $simplification)->with('dependency', $dependency)->with('mode', $mode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SimplificationAgenda $simplificationAgenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $simplification = SimplificationAgenda::find($id);

        // Eliminar la simplificación
        $simplification->delete();

        // Mensaje de sesión
        return redirect()->back()->with('success', 'Simplificación eliminada correctamente.');
    }
}
