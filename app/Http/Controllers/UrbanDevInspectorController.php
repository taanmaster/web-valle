<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UrbanDevRequest;
use Spatie\Permission\Models\Role;
use Session;
use Auth;

class UrbanDevInspectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Usuarios con rol inspector
        $inspectors = User::whereHas('roles', function ($query) {
            $query->where('name', 'inspector');
        })->get();

        return view('urban_dev.inspectors.index')
            ->with('inspectors', $inspectors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4',
        ]);

        $inspector = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Guardar el inspector
        $inspector->save();

        // Asignar el rol inspector
        $inspector->assignRole('inspector');

        Session::flash('success', 'El inspector se creó exitosamente.');

        return redirect()->route('urban_dev.inspectors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inspector = User::find($id);

        return view('urban_dev.inspectors.show')->with('inspector', $inspector);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('urban_dev.inspectors.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'nullable|min:4',
        ]);

        $inspector = User::find($id);

        $inspector->name = $request->input('name');
        $inspector->email = $request->input('email');

        if ($request->filled('password')) {
            $inspector->password = bcrypt($request->input('password'));
        }

        $inspector->save();

        // Mantener rol inspector
        $inspector->syncRoles(['inspector']);

        Session::flash('success', 'El inspector se actualizó exitosamente.');

        return redirect()->route('urban_dev.inspectors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inspector = User::find($id);

        if($inspector->id == Auth::user()->id){
            Session::flash('error', 'No puedes borrar el usuario que está actualmente conectado.');
            return redirect()->back();
        }

        $inspector->delete();

        Session::flash('success', 'El inspector se eliminó exitosamente.');

        return redirect()->back();
    }

    /**
     * Mostrar solicitudes asignadas al inspector autenticado
     */
    public function requests()
    {
        // Verificar que el usuario autenticado tenga rol de inspector
        if (!Auth::user()->hasRole('inspector') && !Auth::user()->hasRole('all')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Obtener solicitudes asignadas al inspector autenticado
        $urban_dev_requests = UrbanDevRequest::with(['user', 'files', 'inspector'])
            ->where('inspector_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('urban_dev.inspectors.requests')
            ->with('urban_dev_requests', $urban_dev_requests);
    }
}
