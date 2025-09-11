<?php

namespace App\Http\Controllers;

// Ayudantes
use Auth;
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\User;

// Permisos y Roles
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('roles.index')->with('roles', $roles)->with('permissions', $permissions);
    }

    public function create()
    {
        $permissions = Permission::all();
        
        return view('roles.create')->with('permissions', $permissions);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name') ?? 'web',
        ]);

        // Asignar permisos si fueron seleccionados
        if ($request->has('permissions')) {
            // Convertir IDs a nombres de permisos
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        }

        Session::flash('success', 'El rol se creó exitosamente.');

        return redirect()->route('roles.index');
    }

    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        $users = User::role($role->name)->get();
        $permissions = $role->permissions;

        return view('roles.show')->with('role', $role)->with('users', $users)->with('permissions', $permissions);
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit')->with('role', $role)->with('permissions', $permissions)->with('rolePermissions', $rolePermissions);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'guard_name' => 'required',
        ]);

        $role = Role::findOrFail($id);

        $role->name = $request->input('name');
        $role->guard_name = $request->input('guard_name') ?? 'web';
        $role->save();

        // Sincronizar permisos
        if ($request->has('permissions')) {
            // Convertir IDs a nombres de permisos
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        Session::flash('success', 'El rol se actualizó exitosamente.');

        return redirect()->route('roles.index');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // Verificar si hay usuarios con este rol
        $usersWithRole = User::role($role->name)->count();

        if ($usersWithRole > 0) {
            Session::flash('error', 'No puedes eliminar este rol porque tiene usuarios asignados.');
            return redirect()->back();
        }

        $role->delete();

        Session::flash('success', 'El rol se eliminó exitosamente.');

        return redirect()->back();
    }

    // Métodos para permisos
    public function storePermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions',
            'guard_name' => 'required',
        ]);

        Permission::create([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name') ?? 'web',
        ]);

        Session::flash('success', 'El permiso se creó exitosamente.');

        return redirect()->route('roles.index') . '#permissions';
    }

    public function updatePermission(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,' . $id,
            'guard_name' => 'required',
        ]);

        $permission = Permission::findOrFail($id);

        $permission->name = $request->input('name');
        $permission->guard_name = $request->input('guard_name') ?? 'web';
        $permission->save();

        Session::flash('success', 'El permiso se actualizó exitosamente.');

        return redirect()->route('roles.index') . '#permissions';
    }

    public function destroyPermission(string $id)
    {
        $permission = Permission::findOrFail($id);

        // Verificar si hay roles con este permiso
        $rolesWithPermission = Role::whereHas('permissions', function ($query) use ($permission) {
            $query->where('id', $permission->id);
        })->count();

        if ($rolesWithPermission > 0) {
            Session::flash('error', 'No puedes eliminar este permiso porque está asignado a roles.');
            return redirect()->back();
        }

        $permission->delete();

        Session::flash('success', 'El permiso se eliminó exitosamente.');

        return redirect()->back();
    }
}