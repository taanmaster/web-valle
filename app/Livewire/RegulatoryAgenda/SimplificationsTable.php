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
use App\Models\SimplificationAgenda;
use App\Models\SimplificationAgendaSuggestion;

class SimplificationsTable extends Component
{
    use WithPagination;

    public $dependency;

    public $is_admin;

    public $date_start;
    public $semester = '';
    public $is_active = '';
    public $high_frequency = '';
    public $priority_grupos = '';
    public $high_burocratic_cost = '';

    public function resetFilters()
    {
        $this->date_start = '';
        $this->semester = '';
        $this->is_active = '';
        $this->high_frequency = '';
        $this->priority_grupos = '';
        $this->high_burocratic_cost = '';
    }

    public function toggleActive($id)
    {
        $simplification = SimplificationAgenda::find($id);

        if ($simplification) {
            $simplification->is_active = !$simplification->is_active;
            $simplification->save();
        }
    }

    public function render()
    {
        $query = SimplificationAgenda::query()
            ->where('dependency_id', $this->dependency->id);

        if ($this->date_start) {
            $query->whereDate('date_start', $this->date_start);
        }

        if ($this->semester !== '') {
            $query->where('semester', $this->semester);
        }

        if ($this->is_admin == 'true') {
            if ($this->is_active !== '') {
                $query->where('is_active', $this->is_active);
            }
        } else {
            $query->where('is_active', 1);
        }

        if ($this->high_frequency !== '') {
            $query->where('high_frequency', $this->high_frequency);
        }

        if ($this->priority_grupos !== '') {
            $query->where('priority_grupos', $this->priority_grupos);
        }

        if ($this->high_burocratic_cost !== '') {
            $query->where('high_burocratic_cost', $this->high_burocratic_cost);
        }

        $simplifications = $query->paginate(10);

        return view('livewire.regulatory-agenda.simplifications-table', [
            'simplifications' => $simplifications,
        ]);
    }
}
