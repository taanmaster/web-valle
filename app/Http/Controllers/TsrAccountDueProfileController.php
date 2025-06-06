<?php

namespace App\Http\Controllers;

use App\Models\TsrAccountDueProfile;
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

        return view('tsr_accounts_due.profiles.show')->with('mode', $mode);
    }

    public function edit($id)
    {
        $mode = 2; // Edit mode

        return view('tsr_accounts_due.profiles.edit')->with('mode', $mode);
    }

    public function update(Request $request, TsrAccountDueProfile $tsrAccountDueProfile)
    {
        //
    }

    public function destroy(TsrAccountDueProfile $tsrAccountDueProfile)
    {
        //
    }
}
