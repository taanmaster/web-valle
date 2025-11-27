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

class UserController extends Controller
{
    public function index()
    {
        // Usuarios administrativos (sin rol citizen)
        $adminUsers = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'citizen');
        })->get();

        // Usuarios ciudadanos (con rol citizen)
        $citizenUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'citizen');
        })->get();

        $roles = Role::where('name', '!=', 'citizen')->get();

        return view('users.index')
            ->with('adminUsers', $adminUsers)
            ->with('citizenUsers', $citizenUsers)
            ->with('roles', $roles);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4',
        ]);

        $admin = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
    
        $rol = Role::findByName($request->rol);

        // Guardar primero el admin
        $admin->save();

        // Asignar el Rol
        $admin->assignRole($rol->name);

        return redirect()->back();
    }

    public function show(string $id)
    {
        $user = User::find($id);

        return view('users.show')->with('user', $user);
    }

    public function edit(string $id)
    {
        return view('users.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'nullable|min:4',
            'roles' => 'required|array|min:1',
        ]);

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        // Sincronizar múltiples roles
        $user->syncRoles($request->input('roles'));

        Session::flash('success', 'El usuario se actualizó exitosamente.');

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if($user->id == Auth::user()->id){
            Session::flash('error', 'No puedes borrar el usuario que está actualmente conectado.');
            
            return redirect()->back();
        }else{
            $user->delete();

            Session::flash('exito', 'El Usuario ha sido borrado exitosamente.');

            return redirect()->back();
        }        
    }

    public function config()
    {
        return view('users.config');
    }

    // Métodos específicos para ciudadanos
    public function storeCitizen(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4',
        ]);

        $citizen = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Guardar el ciudadano
        $citizen->save();

        // Asignar el rol citizen
        $citizen->assignRole('citizen');

        Session::flash('success', 'El usuario ciudadano se creó exitosamente.');

        return redirect()->route('users.index') . '#citizens';
    }

    public function updateCitizen(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'nullable|min:4',
        ]);

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        // Mantener rol citizen
        $user->syncRoles(['citizen']);

        Session::flash('success', 'El usuario ciudadano se actualizó exitosamente.');

        return redirect()->route('users.index') . '#citizens';
    }

    public function destroyCitizen(string $id)
    {
        $user = User::find($id);

        if($user->id == Auth::user()->id){
            Session::flash('error', 'No puedes borrar el usuario que está actualmente conectado.');
            return redirect()->back();
        }

        $user->delete();

        Session::flash('success', 'El usuario ciudadano se eliminó exitosamente.');

        return redirect()->back();
    }
}
