<?php

namespace App\Http\Controllers;

use App\Models\CouncilMinute;
use Illuminate\Http\Request;

class CouncilMinuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mode = 0; // List mode

        return view('council_minutes.index')->with('mode', $mode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mode = 0; // Create mode
        return view('council_minutes.create')->with('mode', $mode);
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
    public function show($id)
    {
        $minute = CouncilMinute::findOrFail($id);
        $mode = 1; // Show mode
        return view('council_minutes.show')->with([
            'minute' => $minute,
            'mode' => $mode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $minute = CouncilMinute::findOrFail($id);
        $mode = 2; // Edit mode
        return view('council_minutes.edit')->with([
            'minute' => $minute,
            'mode' => $mode
        ]);
    }


    public function update(Request $request, CouncilMinute $councilMinute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $minute = CouncilMinute::findOrFail($id);
        $minute->delete();

        return redirect()->route('council_minutes.index')->with('success', 'Acta eliminada correctamente.');
    }
}
