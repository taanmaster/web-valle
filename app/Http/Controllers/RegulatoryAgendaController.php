<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

//Modelos
use App\Models\RegulatoryAgendaDependency;
use App\Models\RegulatoryAgendaRegulation;
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

        $regulations = RegulatoryAgendaRegulation::where('dependency_id', $id)->paginate(10);

        return view('regulatory_agenda.show')->with('dependency', $dependency)->with('regulations', $regulations);
    }
}
