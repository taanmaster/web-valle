<?php

namespace App\Http\Controllers;

use App\Models\Summon;
use Illuminate\Http\Request;

class SummonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mode = 0; // List mode

        return view('summons.index')->with('mode', $mode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mode = 0; // Create mode
        return view('summons.create')->with('mode', $mode);
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
        $summon = Summon::findOrFail($id);
        $mode = 1; // Show mode
        return view('summons.show')->with([
            'summon' => $summon,
            'mode' => $mode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $summon = Summon::findOrFail($id);
        $mode = 2; // Edit mode
        return view('summons.edit')->with([
            'summon' => $summon,
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
        $summon = Summon::findOrFail($id);
        $summon->delete();

        return redirect()->route('summons.index')->with('success', 'Citatorio eliminado correctamente.');
    }
}
