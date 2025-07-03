<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFProgram as Program;
use Illuminate\Http\Request;

class DIFProgramController extends Controller
{
    public function index()
    {
        $query = Program::query();
        
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        $programs = $query->paginate(30);

        return view('dif.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('dif.programs.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'full_address' => 'nullable|max:500',
            'is_active' => 'boolean',
        ));

        // Guardar datos en la base de datos
        $program = Program::create([
            'name' => $request->name,
            'description' => $request->description,
            'full_address' => $request->full_address,
            'is_active' => $request->has('is_active'),
        ]);

        // Mensaje de session
        Session::flash('success', 'Programa guardado correctamente.');

        // Enviar a vista
        return redirect()->route('dif.programs.index');
    }

    public function show($id)
    {
        $program = Program::find($id);
        
        return view('dif.programs.show')->with('program', $program);
    }

    public function edit($id)
    {
        $program = Program::find($id);

        return view('dif.programs.edit')->with('program', $program);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'full_address' => 'nullable|max:500',
            'is_active' => 'boolean',
        ));

        $program = Program::find($id);

        $program->update([
            'name' => $request->name,
            'description' => $request->description,
            'full_address' => $request->full_address,
            'is_active' => $request->has('is_active'),
        ]);

        // Mensaje de session
        Session::flash('success', 'Programa editado exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.programs.show', $program->id);
    }

    public function destroy($id)
    {
        $program = Program::find($id);
        $program->delete();

        Session::flash('success', 'Programa eliminado de manera exitosa.');
        return redirect()->route('dif.programs.index');
    }

    /**
     * Buscar programas via Ajax
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'programs' => [],
                'message' => 'Por favor ingrese al menos 2 caracteres para buscar.'
            ]);
        }

        $programs = Program::where('is_active', 1)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('full_address', 'LIKE', "%{$query}%");
            })
            ->select('id', 'name', 'description', 'full_address')
            ->orderBy('name')
            ->limit(50)
            ->get();

        return response()->json([
            'programs' => $programs,
            'total' => $programs->count(),
            'success' => true
        ]);
    }
}
