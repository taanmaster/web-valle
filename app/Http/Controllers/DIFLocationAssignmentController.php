<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Str;
use Auth;

// Modelos
use App\Models\DIFLocationAssignment as LocationAssignment;

use Illuminate\Http\Request;

class DIFLocationAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    // not used
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    // not used (handled via modal in location show)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'location_id' => 'required|integer',
            'type' => 'required|in:program,assistance',
            'model_id' => 'required|integer'
        ]);

        $modelType = $request->type === 'program' ? 'DIFProgram' : 'DIFSocialAssistance';
        $fullModel = "App\\Models\\{$modelType}";

        $assignment = LocationAssignment::create([
            'location_id' => $request->location_id,
            'model_type' => $fullModel,
            'model_id' => $request->model_id
        ]);

        Session::flash('success', 'Asignación creada correctamente.');

        return redirect()->route('dif.locations.show', $request->location_id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    // not used
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    // not used
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    // not used
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $assignment = LocationAssignment::findOrFail($id);
    $locationId = $assignment->location_id;
    $assignment->delete();

    Session::flash('success', 'Asignación eliminada correctamente.');
    return redirect()->route('dif.locations.show', $locationId);
    }
}
