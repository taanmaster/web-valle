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
use App\Models\TsrRevenueLawRateAndFee;

class RatesAndFeesModal extends Component
{

    public $selectedRate;

    #[Validate('required|max:255')]
    public $section = '';
    public $order_number = '';
    public $type = '';
    public $concept = '';
    public $cost = '';
    public $description = '';


    #[On('selectRate')]
    public function selectRate($id)
    {
        $this->selectedRate = TsrRevenueLawRateAndFee::find($id);

        $this->section = $this->selectedRate->section;
        $this->order_number = $this->selectedRate->order_number;
        $this->type = $this->selectedRate->type;
        $this->concept = $this->selectedRate->concept;
        $this->cost = $this->selectedRate->cost;
        $this->description = $this->selectedRate->description;
    }

    public function save()
    {

        if ($this->selectedRate != null) {
            $this->selectedRate->update([
                'section' => $this->section,
                'order_number' => $this->order_number,
                'type' => $this->type,
                'concept' => $this->concept,
                'cost' => $this->cost,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Tarifa creada correctamente.');

            // Redirigir
            return redirect()->route('rates_and_costs.index');
        } else {
            TsrRevenueLawRateAndFee::create([
                'section' => $this->section,
                'order_number' => $this->order_number,
                'type' => $this->type,
                'concept' => $this->concept,
                'cost' => $this->cost,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Tarifa creada correctamente.');

            // Redirigir
            return redirect()->route('rates_and_costs.index');
        }
    }

    public function render()
    {
        return view('tsr_revenue_law_rates_and_fees.utilities.rates-and-fees-modal');
    }
}
