<?php

namespace App\Livewire\RegulatoryAgenda;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelo
use App\Models\SimplificationAgenda;
use App\Models\SimplificationAgendaSuggestion;

use Livewire\Component;

class CrudSimplifications extends Component
{
    public $simplification;

    public $dependency;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    //Campos
    public $unique_code = '';
    public $name = '';
    
    // Criterios (Checkboxes)
    public $high_frequency = false;
    public $priority_grupos = false;
    public $high_burocratic_cost = false;
    public $in_person = false;
    public $air_commitment = false;
    public $others = false;
    
    // Descripciones
    public $description = '';
    public $brief = '';
    
    // Plan de Acción
    public $diagnostic = '';
    public $simplification_action = '';
    public $digitalizacion_action = '';
    public $final_goal = '';
    
    // Cronograma y Responsables
    public $date_start = '';
    public $end_date = '';
    public $progress_percentage = '';
    public $responsible = '';
    public $semester = '';

    public function mount()
    {
        if ($this->simplification != null) {
            $this->fetchSimplificationData();
        }
    }

    public function fetchSimplificationData()
    {
        $this->unique_code = $this->simplification->unique_code;
        $this->name = $this->simplification->name;
        
        // Criterios
        $this->high_frequency = $this->simplification->high_frequency;
        $this->priority_grupos = $this->simplification->priority_grupos;
        $this->high_burocratic_cost = $this->simplification->high_burocratic_cost;
        $this->in_person = $this->simplification->in_person;
        $this->air_commitment = $this->simplification->air_commitment;
        $this->others = $this->simplification->others;
        
        // Descripciones
        $this->description = $this->simplification->description;
        $this->brief = $this->simplification->brief;
        
        // Plan de Acción
        $this->diagnostic = $this->simplification->diagnostic;
        $this->simplification_action = $this->simplification->simplification_action;
        $this->digitalizacion_action = $this->simplification->digitalizacion_action;
        $this->final_goal = $this->simplification->final_goal;
        
        // Cronograma
        $this->date_start = $this->simplification->date_start;
        $this->end_date = $this->simplification->end_date;
        $this->progress_percentage = $this->simplification->progress_percentage;
        $this->responsible = $this->simplification->responsible;
        $this->semester = $this->simplification->semester;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'date_start' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $date_start = $this->date_start ?: null;
        $end_date = $this->end_date ?: null;

        if ($this->simplification != null) {
            $this->simplification->update([
                'unique_code' => $this->unique_code,
                'name' => $this->name,
                'high_frequency' => $this->high_frequency,
                'priority_grupos' => $this->priority_grupos,
                'high_burocratic_cost' => $this->high_burocratic_cost,
                'in_person' => $this->in_person,
                'air_commitment' => $this->air_commitment,
                'others' => $this->others,
                'description' => $this->description,
                'brief' => $this->brief,
                'diagnostic' => $this->diagnostic,
                'simplification_action' => $this->simplification_action,
                'digitalizacion_action' => $this->digitalizacion_action,
                'final_goal' => $this->final_goal,
                'date_start' => $date_start,
                'end_date' => $end_date,
                'progress_percentage' => $this->progress_percentage,
                'responsible' => $this->responsible,
                'semester' => $this->semester,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Simplificación actualizada correctamente.');

            return redirect()->route('agenda_dependencies.show', $this->dependency->id);
        } else {
            SimplificationAgenda::create([
                'dependency_id' => $this->dependency->id,
                'unique_code' => $this->unique_code,
                'name' => $this->name,
                'high_frequency' => $this->high_frequency,
                'priority_grupos' => $this->priority_grupos,
                'high_burocratic_cost' => $this->high_burocratic_cost,
                'in_person' => $this->in_person,
                'air_commitment' => $this->air_commitment,
                'others' => $this->others,
                'description' => $this->description,
                'brief' => $this->brief,
                'diagnostic' => $this->diagnostic,
                'simplification_action' => $this->simplification_action,
                'digitalizacion_action' => $this->digitalizacion_action,
                'final_goal' => $this->final_goal,
                'date_start' => $date_start,
                'end_date' => $end_date,
                'progress_percentage' => $this->progress_percentage,
                'responsible' => $this->responsible,
                'semester' => $this->semester,
                'is_active' => true,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Simplificación creada correctamente.');

            return redirect()->route('agenda_dependencies.show', $this->dependency->id);
        }
    }

    public function render()
    {
        if ($this->simplification == null) {
            $suggestions = null;

            return view('livewire.regulatory-agenda.crud-simplifications', [
                'suggestions' => $suggestions,
            ]);
        } else {
            $suggestions = SimplificationAgendaSuggestion::where('simplification_id', $this->simplification->id)->paginate(10);

            return view('livewire.regulatory-agenda.crud-simplifications', [
                'suggestions' => $suggestions,
            ]);
        }
    }
}