<?php

namespace App\Livewire\RegulatoryAgenda;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelo
use App\Models\RegulatoryAgendaRegulation;
use App\Models\RegulatoryAgendaSuggestion;

use Livewire\Component;

class CrudRegulations extends Component
{
    public $regulation;

    public $dependency;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    //Campos
    public $name;
    public $subject = '';
    public $problematic = '';
    public $justification = '';
    public $presentation_date = '';
    public $type = '';
    public $impact = '';
    public $beneficiaries = '';
    public $semester = '';
    public $is_active;


    public function mount()
    {
        if ($this->regulation != null) {
            $this->fetchRegulationData();
        }
    }

    public function fetchRegulationData()
    {
        $this->name = $this->regulation->name;
        $this->subject = $this->regulation->subject;
        $this->problematic = $this->regulation->problematic;
        $this->justification = $this->regulation->justification;
        $this->presentation_date = $this->regulation->presentation_date;
        $this->type = $this->regulation->type;
        $this->impact = $this->regulation->impact;
        $this->beneficiaries = $this->regulation->beneficiaries;
        $this->semester = $this->regulation->semester;
    }

    public function save()
    {

        if ($this->regulation != null) {
            $this->regulation->update([
                'name' => $this->name,
                'subject' => $this->subject,
                'problematic' => $this->problematic,
                'justification' => $this->justification,
                'presentation_date' => $this->presentation_date,
                'type' => $this->type,
                'impact' => $this->impact,
                'beneficiaries' => $this->beneficiaries,
                'semester' => $this->semester,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Dependencia actualizada correctamente.');

            // Redirigir
            return redirect()->route('regulatory_agenda_regulation.show', $this->regulation->id);
        } else {
            RegulatoryAgendaRegulation::create([
                'dependency_id' => $this->dependency->id,
                'name' => $this->name,
                'subject' => $this->subject,
                'problematic' => $this->problematic,
                'justification' => $this->justification,
                'presentation_date' => $this->presentation_date,
                'type' => $this->type,
                'impact' => $this->impact,
                'beneficiaries' => $this->beneficiaries,
                'semester' => $this->semester,
                'is_active' => true,

            ]);

            // Mensaje de sesión
            Session::flash('success', 'Dependencia creada correctamente.');

            // Mensaje de sesión
            return redirect()->route('regulatory_agenda.show', $this->dependency->id);
        }
    }

    public function render()
    {

        if ($this->regulation == null) {

            $suggestions = null;

            return view('regulatory_agenda.utilities.crud-regulations', [
                'suggestions' => $suggestions,
            ]);
        } else {
            $suggestions = RegulatoryAgendaSuggestion::where('regulation_id', $this->regulation->id)->paginate(10);

            return view('regulatory_agenda.utilities.crud-regulations', [
                'suggestions' => $suggestions,
            ]);
        }
    }
}
