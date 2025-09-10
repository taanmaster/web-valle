<?php

namespace App\Http\Controllers;

use App\Models\ImplanProject;
use Illuminate\Http\Request;

class ImplanProjectController extends Controller
{
    public function index()
    {
        $projects = ImplanProject::all();

        return view('implan.projects.index')->with('projects', $projects);
    }

    public function create()
    {
        $mode = 0;

        return view('implan.projects.create')->with('mode', $mode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $project = ImplanProject::findOrFail($id);

        $mode = 1;

        return view('implan.projects.show')->with([
            'project' => $project,
            'mode' => $mode
        ]);
    }

    public function edit($id)
    {
        $project = ImplanProject::findOrFail($id);

        $mode = 2;

        return view('implan.projects.edit')->with([
            'project' => $project,
            'mode' => $mode
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImplanProject $implanProject)
    {
        //
    }

    public function destroy($id)
    {
        $project = ImplanProject::findOrFail($id);
        $project->delete();

        return redirect()->route('implan.projects.index')->with('success', 'Proyecto eliminado correctamente');
    }
}
