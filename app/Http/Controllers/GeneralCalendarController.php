<?php

namespace App\Http\Controllers;

use App\Models\GeneralCalendarProcedure;

class GeneralCalendarController extends Controller
{
    public function index()
    {
        return view('general-calendar.index');
    }

    public function create()
    {
        return view('general-calendar.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $procedure = GeneralCalendarProcedure::with(['blocks', 'closures'])->findOrFail($id);

        return view('general-calendar.show', ['procedure' => $procedure, 'mode' => 1]);
    }

    public function edit($id)
    {
        $procedure = GeneralCalendarProcedure::with(['blocks', 'closures'])->findOrFail($id);

        return view('general-calendar.edit', ['procedure' => $procedure, 'mode' => 2]);
    }

    public function destroy($id)
    {
        GeneralCalendarProcedure::findOrFail($id)->delete();

        return redirect()->route('general_calendar.admin.index')
            ->with('success', 'Trámite eliminado correctamente.');
    }
}
