<?php

namespace App\Livewire\DIF\Expenses;

use App\Models\DIFExpense;
use Livewire\Component;
use App\Models\DIFSocialAssistance;

class Crud extends Component
{
    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $expense;

    //Campos
    public $type = '';
    public $ammount = '';
    public $recipient = '';
    public $concept = '';
    public $value = '';

    public $concepts = [];

    public function mount()
    {
        if ($this->expense != null) {
            $this->fetchExpenseData();
        }

        $this->concepts = DIFSocialAssistance::get();
    }

    public function fetchExpenseData()
    {
        $this->type = $this->expense->type;
        $this->ammount = $this->expense->ammount;
        $this->recipient = $this->expense->recipient;
        $this->concept = $this->expense->concept;
        $this->value = $this->expense->value;
    }

    public function save()
    {

        $concept = DIFSocialAssistance::where('name', $this->concept)->first();

        if ($this->expense != null) {

            $this->expense->update([
                'type' => $this->type,
                'ammount' => $concept->value,
                'recipient' => $this->recipient,
                'concept' => $concept->name,
                'value' => $concept->value,
            ]);

        } else {

            DIFExpense::create([
                'type' => $this->type,
                'ammount' => $concept->value,
                'recipient' => $this->recipient,
                'concept' => $concept->name,
                'value' => $concept->value,
            ]);

        }

        return redirect()->route('dif.expenses.index');
    }

    public function render()
    {
        return view('dif.expenses.utilities.crud');
    }
}
