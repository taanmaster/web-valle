<?php

namespace App\Http\Controllers;

//Modelos
use App\Models\RegulatoryAgendaDependency;
use Illuminate\Http\Request;

class RegulatoryAgendaController extends Controller
{
    public function index()
    {
        $dependencies = RegulatoryAgendaDependency::paginate(10);

        return view('regulatory_agenda.index')->with('dependecies', $dependencies);
    }

    public function show($id)
    {
        $dependency = RegulatoryAgendaDependency::find($id);

        return view('regulatory_agenda.show')->with('dependency', $dependency);
    }
}
