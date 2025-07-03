<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFCoordination as Coordination;
use App\Models\DIFProgram as Program;
use App\Models\DIFCoordinationProgram as CoordinationProgram;
use Illuminate\Http\Request;

class DIFCoordinationController extends Controller
{
    public function index()
    {
        $query = Coordination::with(['programs']);
        
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        $coordinations = $query->paginate(30);

        return view('dif.coordinations.index', compact('coordinations'));
    }

    public function create()
    {
        // Obtener todos los programas activos
        $programs = Program::where('is_active', true)->get();
        
        return view('dif.coordinations.create', compact('programs'));
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'is_active' => 'required|boolean',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:d_i_f_programs,id',
        ));

        // Guardar coordinación
        $coordination = Coordination::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        // Asociar programas si se seleccionaron
        if ($request->program_ids) {
            $coordination->programs()->attach($request->program_ids);
        }

        // Mensaje de session
        Session::flash('success', 'Coordinación guardada correctamente.');

        // Enviar a vista
        return redirect()->route('dif.coordinations.index');
    }

    public function show($id)
    {
        $coordination = Coordination::with(['programs'])->find($id);
        
        return view('dif.coordinations.show')->with('coordination', $coordination);
    }

    public function edit($id)
    {
        $coordination = Coordination::with(['programs'])->find($id);
        $programs = Program::where('is_active', true)->get();
        
        // Obtener IDs de programas seleccionados
        $selectedPrograms = $coordination->programs->pluck('id')->toArray();

        return view('dif.coordinations.edit', compact('coordination', 'programs', 'selectedPrograms'));
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'is_active' => 'required|boolean',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:d_i_f_programs,id',
        ));

        $coordination = Coordination::find($id);

        $coordination->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        // Actualizar programas asociados
        if ($request->program_ids) {
            $coordination->programs()->sync($request->program_ids);
        } else {
            $coordination->programs()->detach();
        }

        // Mensaje de session
        Session::flash('success', 'Coordinación actualizada exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.coordinations.show', $coordination->id);
    }

    public function destroy($id)
    {
        $coordination = Coordination::find($id);
        
        // Eliminar relaciones con programas
        $coordination->programs()->detach();
        
        // Eliminar coordinación
        $coordination->delete();

        Session::flash('success', 'Coordinación eliminada de manera exitosa.');
        return redirect()->route('dif.coordinations.index');
    }
}
