<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFService as Service;
use Illuminate\Http\Request;

class DIFServiceController extends Controller
{
    public function index()
    {
        $query = Service::query();
        
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        $services = $query->paginate(30);

        return view('dif.services.index', compact('services'));
    }

    public function create()
    {
        return view('dif.services.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'is_active' => 'boolean',
        ));

        // Guardar datos en la base de datos
        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        // Mensaje de session
        Session::flash('success', 'Servicio guardado correctamente.');

        // Enviar a vista
        return redirect()->route('dif.services.index');
    }

    public function show($id)
    {
        $service = Service::find($id);
        
        return view('dif.services.show')->with('service', $service);
    }

    public function edit($id)
    {
        $service = Service::find($id);

        return view('dif.services.edit')->with('service', $service);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'is_active' => 'boolean',
        ));

        $service = Service::find($id);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        // Mensaje de session
        Session::flash('success', 'Servicio editado exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.services.show', $service->id);
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();

        Session::flash('success', 'Servicio eliminado de manera exitosa.');
        return redirect()->route('dif.services.index');
    }
}
