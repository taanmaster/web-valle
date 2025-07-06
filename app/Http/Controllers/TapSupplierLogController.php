<?php

namespace App\Http\Controllers;

use App\Models\TapSupplierLog;
use Illuminate\Http\Request;

// Ayudantes
use Str;
use Auth;
use Session;

class TapSupplierLogController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TapSupplierLog $tapSupplierLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TapSupplierLog $tapSupplierLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $log = TapSupplierLog::findOrFail($id);
        $log->description = $request->description;
        $log->save();

        // Mensaje de sesión
        Session::flash('success', 'Registro actualizado correctamente.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $log = TapSupplierLog::findOrFail($id);
        $log->delete();

        // Mensaje de sesión
        Session::flash('success', 'Registro eliminado correctamente.');

        return redirect()->back();
    }
}
