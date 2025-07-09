<?php

namespace App\Http\Controllers;

use App\Models\TapChecklistAuthorizationNote;
use Illuminate\Http\Request;

// Ayudantes
use Str;
use Auth;
use Session;


class TapChecklistAuthorizationNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $note = new TapChecklistAuthorizationNote();
        $note->authorization_id = $request->authorization_id;
        $note->description = $request->description;
        $note->save();

        // Mensaje de sesión
        Session::flash('success', 'Autorización actualizada correctamente.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(TapChecklistAuthorizationNote $tapChecklistAuthorizationNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TapChecklistAuthorizationNote $tapChecklistAuthorizationNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TapChecklistAuthorizationNote $tapChecklistAuthorizationNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TapChecklistAuthorizationNote $tapChecklistAuthorizationNote)
    {
        //
    }
}
