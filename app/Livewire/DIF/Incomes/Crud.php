<?php

namespace App\Livewire\DIF\Incomes;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Illuminate\Http\File;

use App\Models\DIFIncome;

class Crud extends Component
{
    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $income;

    //Campos
    public $type = '';
    public $ammount = '';
    public $client = '';
    public $concept = '';
    public $payment_method = '';

    public function mount()
    {
        if ($this->income != null) {
            $this->fetchIncomeData();
        }
    }

    public function fetchIncomeData()
    {
        $this->type = $this->income->type;
        $this->ammount = $this->income->ammount;
        $this->client = $this->income->client;
        $this->concept = $this->income->concept;
        $this->payment_method = $this->income->payment_method;
    }

    public function save()
    {
        if ($this->income != null) {

            $this->income->update([
                'type' => $this->type,
                'ammount' => $this->ammount,
                'client' => $this->client,
                'concept' => $this->concept,
                'payment_method' => $this->payment_method,
            ]);

        } else {

            DIFIncome::create([
                'type' => $this->type,
                'ammount' => $this->ammount,
                'client' => $this->client,
                'concept' => $this->concept,
                'payment_method' => $this->payment_method,
            ]);

        }

        return redirect()->route('dif.incomes.index');
    }

    public function render()
    {
        return view('dif.incomes.utilities.crud');
    }
}
