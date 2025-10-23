<?php

namespace App\Livewire\RegulatoryAgenda;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;



//Modelos
use Livewire\Component;
use App\Models\RegulatoryAgendaRegulation;
use App\Models\RegulatoryAgendaSuggestion;

class RegulationsTable extends Component
{
    use WithPagination;

    public $dependency;

    public $is_admin;

    public $presentation_date;
    public $semester = '';
    public $is_active = '';
    public $type = '';

    public function resetFilters()
    {
        $this->presentation_date = '';
        $this->semester = '';
        $this->is_active = '';
        $this->type = '';
    }

    public function toggleActive($id)
    {
        $regulation = RegulatoryAgendaRegulation::find($id);

        if ($regulation) {
            $regulation->is_active = !$regulation->is_active;
            $regulation->save();
        }
    }

    public function render()
    {


        if ($this->is_admin == false) {
            $query = RegulatoryAgendaRegulation::query()
                ->where('dependency_id', $this->dependency->id)->where('is_active', true);
        } else {
            $query = RegulatoryAgendaRegulation::query()
                ->where('dependency_id', $this->dependency->id);
        }


        if ($this->presentation_date) {
            $query->whereDate('presentation_date', $this->presentation_date);
        }

        if ($this->semester !== '') {
            $query->where('semester', $this->semester);
        }

        if ($this->type !== '') {
            $query->where('type', $this->type);
        }

        $regulations = $query->paginate(10);

        return view('regulatory_agenda_regulations.utilities.regulations-table', [
            'regulations' => $regulations,
        ]);
    }
}
