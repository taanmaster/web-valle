<?php

namespace App\Http\Controllers;

use App\Models\TsrAccountDueProfile;
use App\Models\TsrAccountDueProvisionalInteger;
use Session;
use Illuminate\Http\Request;

class TsrAccountDueProfileController extends Controller
{
    public function index()
    {
        return view('tsr_accounts_due.profiles.index');
    }

    public function create()
    {
        $mode = 0; // Create mode

        return view('tsr_accounts_due.profiles.create')->with('mode', $mode);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $mode = 1; // Show mode

        $profile = TsrAccountDueProfile::findOrFail($id);

        return view('tsr_accounts_due.profiles.show')->with('mode', $mode)->with('profile', $profile);
    }

    public function edit($id)
    {
        $mode = 2; // Edit mode

        $profile = TsrAccountDueProfile::findOrFail($id);

        return view('tsr_accounts_due.profiles.edit')->with('mode', $mode)->with('profile', $profile);
    }

    public function update(Request $request, TsrAccountDueProfile $tsrAccountDueProfile)
    {
        //
    }

    public function destroy($id)
    {
        $integers = TsrAccountDueProvisionalInteger::where('account_due_profile_id', $id)->get();

        foreach ($integers as $integer) {
            // Eliminar los enteros asociados al perfil
            $integer->delete();
        }


        $profile = TsrAccountDueProfile::findOrFail($id);
        $profile->delete();

        // Mensaje de sesión
        Session::flash('success', 'Perfil creado correctamente.');

        return redirect()->route('account_due_profiles.index');
    }
}
