<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFSpecialty as Specialty;
use Illuminate\Http\Request;

class DIFSpecialtyController extends Controller
{
    public function index()
    {
        $query = Specialty::query();
        
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        $specialties = $query->paginate(30);

        return view('dif.specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('dif.specialties.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'is_active' => 'required|boolean',
        ));

        // Guardar datos en la base de datos
        $specialty = Specialty::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        // Mensaje de session
        Session::flash('success', 'Especialidad guardada correctamente.');

        // Enviar a vista
        return redirect()->route('dif.specialties.index');
    }

    public function show($id)
    {
        $specialty = Specialty::find($id);
        
        return view('dif.specialties.show')->with('specialty', $specialty);
    }

    public function edit($id)
    {
        $specialty = Specialty::find($id);

        return view('dif.specialties.edit')->with('specialty', $specialty);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'is_active' => 'required|boolean',
        ));

        $specialty = Specialty::find($id);

        $specialty->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        // Mensaje de session
        Session::flash('success', 'Especialidad editada exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.specialties.show', $specialty->id);
    }

    public function destroy($id)
    {
        $specialty = Specialty::find($id);
        $specialty->delete();

        Session::flash('success', 'Especialidad eliminada de manera exitosa.');
        return redirect()->route('dif.specialties.index');
    }
}
