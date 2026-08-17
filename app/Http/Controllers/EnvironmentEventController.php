<?php

namespace App\Http\Controllers;

use App\Models\EnvironmentEvent;

class EnvironmentEventController extends Controller
{
    /**
     * Talleres y pláticas de la Dirección de Medio Ambiente. Alimentan el
     * widget de calendario del home público (front.utilities._events_calendar).
     */
    public function index()
    {
        return view('environment-events.index');
    }

    public function create()
    {
        return view('environment-events.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = EnvironmentEvent::findOrFail($id);

        return view('environment-events.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = EnvironmentEvent::findOrFail($id);

        return view('environment-events.edit', ['entry' => $entry, 'mode' => 2]);
    }
}
