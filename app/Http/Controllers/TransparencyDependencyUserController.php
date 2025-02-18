<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TransparencyDependencyUser;
use App\Models\User;
use App\Models\TransparencyDependency;

use Illuminate\Http\Request;

class TransparencyDependencyUserController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'dependency_id' => 'required|exists:transparency_dependencies,id',
        ]);

        TransparencyDependencyUser::create([
            'user_id' => $request->user_id,
            'dependency_id' => $request->dependency_id,
        ]);

        Session::flash('success', 'Usuario asociado correctamente a la dependencia.');

        return redirect()->back();
    }
}