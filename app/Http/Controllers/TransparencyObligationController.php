<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TransparencyObligation;
use App\Models\TransparencyDependency;

use Illuminate\Http\Request;

class TransparencyObligationController extends Controller
{
    public function index()
    {
        $transparency_obligations = TransparencyObligation::paginate(10);
        $transparency_dependencies = TransparencyDependency::all();

        return view('transparency_obligations.index')
        ->with('transparency_obligations', $transparency_obligations)
        ->with('transparency_dependencies', $transparency_dependencies);
    }

    public function create()
    {
        return view('transparency_obligations.create');
    }

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'dependency_id' => 'required|integer',
            'type' => 'required|string',
            'update_period' => 'required|string',
        ]);

        // Guardar datos en la base de datos
        $transparency_obligation = TransparencyObligation::create([
            'name' => $request->name,
            'description' => $request->description,
            'dependency_id' => $request->dependency_id,
            'type' => $request->type,
            'update_period' => $request->update_period,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $transparency_obligation = TransparencyObligation::find($id);

        return view('transparency_obligations.show')->with('transparency_obligation', $transparency_obligation);
    }

    public function edit($id)
    {
        $transparency_obligation = TransparencyObligation::find($id);

        return view('transparency_obligations.edit')->with('transparency_obligation', $transparency_obligation);
    }
    
    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'dependency_id' => 'required|integer',
            'type' => 'required|string',
            'update_period' => 'required|string',
        ]);

        $transparency_obligation = TransparencyObligation::find($id);

        // Actualizar datos en la base de datos
        $transparency_obligation->update([
            'name' => $request->name,
            'description' => $request->description,
            'dependency_id' => $request->dependency_id,
            'type' => $request->type,
            'update_period' => $request->update_period,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $transparency_obligation = TransparencyObligation::find($id);
        $transparency_obligation->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
