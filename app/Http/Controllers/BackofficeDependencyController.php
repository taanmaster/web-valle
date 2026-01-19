<?php

namespace App\Http\Controllers;

use App\Models\BackofficeDependency;
use App\Models\User;
use Illuminate\Http\Request;
use Session;

class BackofficeDependencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = BackofficeDependency::withCount(['documents', 'users']);

        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%")
                  ->orWhere('responsible_name', 'LIKE', "%{$search}%");
        }

        $dependencies = $query->orderBy('name')->paginate(20);

        return view('backoffice.dependencies.index', compact('dependencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backoffice.dependencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string|max:20|unique:backoffice_dependencies,code',
            'name' => 'required|string|max:255',
            'responsible_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Este código ya existe.',
            'name.required' => 'El nombre es obligatorio.',
            'responsible_name.required' => 'El nombre del responsable es obligatorio.',
        ]);

        BackofficeDependency::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'responsible_name' => $request->responsible_name,
            'type' => $request->type,
        ]);

        Session::flash('success', 'Dependencia creada exitosamente.');

        return redirect()->route('backoffice.dependencies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dependency = BackofficeDependency::withCount(['documents', 'users'])->with('users')->findOrFail($id);

        return view('backoffice.dependencies.show', compact('dependency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dependency = BackofficeDependency::with('users')->findOrFail($id);

        return view('backoffice.dependencies.edit', compact('dependency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|string|max:20|unique:backoffice_dependencies,code,' . $id,
            'name' => 'required|string|max:255',
            'responsible_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Este código ya existe.',
            'name.required' => 'El nombre es obligatorio.',
            'responsible_name.required' => 'El nombre del responsable es obligatorio.',
        ]);

        $dependency = BackofficeDependency::findOrFail($id);
        $dependency->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'responsible_name' => $request->responsible_name,
            'type' => $request->type,
        ]);

        Session::flash('success', 'Dependencia actualizada exitosamente.');

        return redirect()->route('backoffice.dependencies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dependency = BackofficeDependency::findOrFail($id);
        
        // Verificar si tiene documentos asociados
        if ($dependency->documents()->count() > 0) {
            Session::flash('error', 'No se puede eliminar la dependencia porque tiene oficios asociados.');
            return redirect()->route('backoffice.dependencies.index');
        }

        // Verificar si tiene usuarios asociados
        if ($dependency->users()->count() > 0) {
            Session::flash('error', 'No se puede eliminar la dependencia porque tiene usuarios asignados. Desasigne los usuarios primero.');
            return redirect()->route('backoffice.dependencies.index');
        }

        $dependency->delete();

        Session::flash('success', 'Dependencia eliminada exitosamente.');

        return redirect()->route('backoffice.dependencies.index');
    }

    /**
     * Buscar usuarios sin dependencia asignada para Select2 AJAX.
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');

        $users = User::permission('admin_access')
            ->whereNull('backoffice_dependency_id')
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'email']);

        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name . ' (' . $user->email . ')',
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Asignar usuario a la dependencia.
     */
    public function attachUser(Request $request, $id)
    {
        $dependency = BackofficeDependency::findOrFail($id);

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Verificar que el usuario no tenga ya una dependencia
        if ($user->backoffice_dependency_id) {
            Session::flash('error', 'Este usuario ya está asignado a otra dependencia.');
            return redirect()->route('backoffice.dependencies.edit', $id);
        }

        $user->update(['backoffice_dependency_id' => $id]);

        Session::flash('success', "Usuario {$user->name} asignado exitosamente.");

        return redirect()->route('backoffice.dependencies.edit', $id);
    }

    /**
     * Desasignar usuario de la dependencia.
     */
    public function detachUser($dependencyId, $userId)
    {
        $dependency = BackofficeDependency::findOrFail($dependencyId);
        $user = User::findOrFail($userId);

        // Verificar que el usuario pertenece a esta dependencia
        if ($user->backoffice_dependency_id != $dependencyId) {
            Session::flash('error', 'Este usuario no pertenece a esta dependencia.');
            return redirect()->route('backoffice.dependencies.edit', $dependencyId);
        }

        $user->update(['backoffice_dependency_id' => null]);

        Session::flash('success', "Usuario {$user->name} desasignado exitosamente. Ya no podrá crear oficios hasta que se le asigne otra dependencia.");

        return redirect()->route('backoffice.dependencies.edit', $dependencyId);
    }
}
