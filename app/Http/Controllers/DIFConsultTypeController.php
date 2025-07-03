<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFConsultType as ConsultType;
use Illuminate\Http\Request;

class DIFConsultTypeController extends Controller
{
    public function index()
    {
        $query = ConsultType::query();
        
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        $consultTypes = $query->paginate(30);

        return view('dif.consult_types.index', compact('consultTypes'));
    }

    public function create()
    {
        return view('dif.consult_types.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ));

        // Guardar datos en la base de datos
        $consultType = ConsultType::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Mensaje de session
        Session::flash('success', 'Tipo de consulta guardado correctamente.');

        // Enviar a vista
        return redirect()->route('dif.consult_types.index');
    }

    public function show($id)
    {
        $consultType = ConsultType::find($id);
        
        return view('dif.consult_types.show')->with('consultType', $consultType);
    }

    public function edit($id)
    {
        $consultType = ConsultType::find($id);

        return view('dif.consult_types.edit')->with('consultType', $consultType);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ));

        $consultType = ConsultType::find($id);

        $consultType->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Mensaje de session
        Session::flash('success', 'Tipo de consulta editado exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.consult_types.show', $consultType->id);
    }

    public function destroy($id)
    {
        $consultType = ConsultType::find($id);
        $consultType->delete();

        Session::flash('success', 'Tipo de consulta eliminado de manera exitosa.');
        return redirect()->route('dif.consult_types.index');
    }
}
