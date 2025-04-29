<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

use App\Models\RegulatoryAgendaDependency;
use App\Models\RegulatoryAgendaRegulation;
use Illuminate\Http\Request;

class RegulatoryAgendaRegulationController extends Controller
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
        $regulation = null;

        $dependency = RegulatoryAgendaDependency::find($id);

        $mode = 0;

        return view('regulatory_agenda.create')->with('regulation', $regulation)->with('dependency', $dependency)->with('mode', $mode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $regulation = RegulatoryAgendaRegulation::find($id);

        $dependency = RegulatoryAgendaDependency::find($regulation->dependency_id);

        $mode = 1;

        return view('regulatory_agenda.create')->with('regulation', $regulation)->with('dependency', $dependency)->with('mode', $mode);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $regulation = RegulatoryAgendaRegulation::find($id);

        $dependency = RegulatoryAgendaDependency::find($regulation->dependency_id);

        $mode = 2;

        return view('regulatory_agenda.create')->with('regulation', $regulation)->with('dependency', $dependency)->with('mode', $mode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegulatoryAgendaRegulation $regulatoryAgendaRegulation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegulatoryAgendaRegulation $regulatoryAgendaRegulation)
    {
        //
    }
}
