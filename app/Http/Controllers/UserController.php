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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$users = User::all();
        $webmaster = User::role('webmaster')->get();
        $admin  = User::role('admin')->get();

        $users = $webmaster->merge($admin);
        
        $roles = Role::where('name', '!=', 'citizen')->get();

        return view('users.index')->with('users', $users)->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('users.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'required|min:4',
        ]);

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
 
        $rol = Role::findByName($request->rol);

        // Guardar primero el admin
        $user->save();

        // Asignar el Rol
        $user->assignRole($rol->name);
        Session::flash('success', 'Se actualizó exitosamente tu usuario.');

        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     */
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
}
