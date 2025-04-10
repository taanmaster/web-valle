<?php

namespace App\Livewire\TsrRevenueLaw;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\TsrRevenueLawIncome;

class IncomeModal extends Component
{
    public $income;

    public $type = '';
    public $entity = '';
    public $law = '';
    public $total = '';

    #[On('selectIncome')]
    public function showModal($id)
    {
        $this->income = TsrRevenueLawIncome::find($id);

        $this->type = $this->income->type;
        $this->entity = $this->income->entity;
        $this->law = $this->income->law;
        $this->total = $this->income->total;
    }

    public function save()
    {
        if ($this->income != null) {
            $this->income->update([
                'type' => $this->type,
                'entity' => $this->entity,
                'law' => $this->law,
                'total' => $this->total,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Ingreso actualizado correctamente.');

            // Redirigir
            return redirect()->route('revenue_law.index');
        } else {
            TsrRevenueLawIncome::create([
                'type' => $this->type,
                'entity' => $this->entity,
                'law' => $this->law,
                'total' => $this->total,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Ingreso creado correctamente.');

            // Redirigir
            return redirect()->route('revenue_law.index');
        }
    }

    public function render()
    {
        return view('tsr_revenue_law.utilities.income-modal');
    }
}
