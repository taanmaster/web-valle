<?php

namespace App\Livewire\EnvironmentEvents;

use App\Models\EnvironmentEvent;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public function deleteEntry($id)
    {
        EnvironmentEvent::findOrFail($id)->delete();

        session()->flash('success', 'Evento eliminado correctamente.');
    }

    public function render()
    {
        return view('environment-events.utilities.table', [
            'events' => EnvironmentEvent::orderBy('date_start')->paginate(10),
            'calendarEvents' => EnvironmentEvent::where('is_active', true)->orderBy('date_start')->get(),
        ]);
    }
}
