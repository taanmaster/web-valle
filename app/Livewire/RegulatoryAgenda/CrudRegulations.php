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
    public $expeditions_date = '';
    public $update_date = '';
    
    // Nuevos campos
    public $legal_basis_law = '';
    public $legal_basis_article = '';
    public $proposal_alternatives = '';
    public $burocratic_cost_benefict = '';
    public $simplification_oportunities = '';


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
        $this->expeditions_date = $this->regulation->expeditions_date;
        $this->update_date = $this->regulation->update_date;
        
        // Nuevos campos
        $this->legal_basis_law = $this->regulation->legal_basis_law;
        $this->legal_basis_article = $this->regulation->legal_basis_article;
        $this->proposal_alternatives = $this->regulation->proposal_alternatives;
        $this->burocratic_cost_benefict = $this->regulation->burocratic_cost_benefict;
        $this->simplification_oportunities = $this->regulation->simplification_oportunities;
    }

    public function save()
    {

        $this->validate([
            'name' => 'required|max:255',
            'expeditions_date' => 'nullable|date',
            'update_date' => 'nullable|date',
        ]);

        $expeditions_date = $this->expeditions_date ?: null; // Si está vacío, asigna null
        $update_date = $this->update_date ?: null;

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
                'expeditions_date' => $expeditions_date,
                'update_date' => $update_date,
                'legal_basis_law' => $this->legal_basis_law,
                'legal_basis_article' => $this->legal_basis_article,
                'proposal_alternatives' => $this->proposal_alternatives,
                'burocratic_cost_benefict' => $this->burocratic_cost_benefict,
                'simplification_oportunities' => $this->simplification_oportunities,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Dependencia actualizada correctamente.');


            // Mensaje de sesión
            return redirect()->route('regulatory_agenda.show', $this->dependency->id);
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
                'expeditions_date' => $expeditions_date,
                'update_date' => $update_date,
                'legal_basis_law' => $this->legal_basis_law,
                'legal_basis_article' => $this->legal_basis_article,
                'proposal_alternatives' => $this->proposal_alternatives,
                'burocratic_cost_benefict' => $this->burocratic_cost_benefict,
                'simplification_oportunities' => $this->simplification_oportunities,

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
