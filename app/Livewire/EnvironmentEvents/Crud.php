<?php

namespace App\Livewire\EnvironmentEvents;

use App\Models\EnvironmentEvent;
use Livewire\Component;

class Crud extends Component
{
    public $entry;

    // 0: crear  1: ver  2: editar
    public $mode = 0;

    public $title = '';

    public $date_start = '';

    public $time_start = '';

    public $date_end = '';

    public $time_end = '';

    public $location = '';

    public $blog_url = '';

    public function mount()
    {
        if ($this->entry !== null) {
            $this->title = $this->entry->title;
            $this->date_start = optional($this->entry->date_start)->format('Y-m-d') ?? '';
            $this->time_start = optional($this->entry->date_start)->format('H:i') ?? '';
            $this->date_end = optional($this->entry->date_end)->format('Y-m-d') ?? '';
            $this->time_end = optional($this->entry->date_end)->format('H:i') ?? '';
            $this->location = $this->entry->location;
            $this->blog_url = $this->entry->blog_url;
        }
    }

    public function timeOptions(): array
    {
        return EnvironmentEvent::timeOptions();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'date_start' => 'required|date',
            'time_start' => 'required',
            'date_end' => 'nullable|date|after_or_equal:date_start',
            'time_end' => 'nullable',
            'location' => 'nullable|string|max:255',
            'blog_url' => 'nullable|url|max:255',
        ]);

        $dateStart = $this->date_start.' '.$this->time_start;
        $dateEnd = ($this->date_end && $this->time_end) ? $this->date_end.' '.$this->time_end : null;

        if ($dateEnd && $dateEnd < $dateStart) {
            $this->addError('date_end', 'La fecha y hora de fin debe ser posterior al inicio.');

            return;
        }

        $data = [
            'title' => $this->title,
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'location' => $this->location ?: null,
            'blog_url' => $this->blog_url ?: null,
        ];

        if ($this->entry !== null) {
            $this->entry->update($data);
        } else {
            EnvironmentEvent::create($data + ['is_active' => true]);
        }

        session()->flash('success', 'Evento guardado correctamente.');

        return redirect()->route('environment_events.admin.index');
    }

    public function delete()
    {
        $this->entry->delete();

        session()->flash('success', 'Evento eliminado correctamente.');

        return redirect()->route('environment_events.admin.index');
    }

    public function render()
    {
        return view('environment-events.utilities.crud');
    }
}
