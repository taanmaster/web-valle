<?php

namespace App\Livewire\TsrRevenueLaw;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Models
use App\Models\TsrRevenueLawConcept;

class ConceptModal extends Component
{
    public $selectedConcept;

    public $income_id;
    public $CRI = '';
    public $concept = '';
    public $estimated_income = '';

    #[On('selectConcept')]
    public function showModal($id)
    {
        $this->selectedConcept = TsrRevenueLawConcept::find($id);

        $this->CRI = $this->selectedConcept->CRI;
        $this->concept = $this->selectedConcept->concept;
        $this->estimated_income = $this->selectedConcept->estimated_income;
    }

    #[On('newConcept')]
    public function newModal($id)
    {
        $this->income_id = $id;

        $this->CRI = '';
        $this->concept = '';
        $this->estimated_income = '';
    }

    public function save()
    {
        if ($this->selectedConcept != null) {
            $this->selectedConcept->update([
                'CRI' => $this->CRI,
                'concept' => $this->concept,
                'estimated_income' => $this->estimated_income,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Concepto actualizado correctamente.');

            // Redirigir
            return redirect()->route('revenue_law.index');
        } else {
            TsrRevenueLawConcept::create([
                'income_id' => $this->income_id,
                'CRI' => $this->CRI,
                'concept' => $this->concept,
                'estimated_income' => $this->estimated_income,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Concepto creado correctamente.');

            // Redirigir
            return redirect()->route('revenue_law.index');
        }
    }

    public function render()
    {
        return view('tsr_revenue_law.utilities.concept-modal');
    }
}
