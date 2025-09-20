<?php

namespace App\Livewire\DIF\Expenses;

use App\Models\DIFExpense;
use Livewire\Component;

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

    public function mount()
    {
        if ($this->expense != null) {
            $this->fetchExpenseData();
        }
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
        if ($this->expense != null) {

            $this->expense->update([
                'type' => $this->type,
                'ammount' => $this->ammount,
                'recipient' => $this->recipient,
                'concept' => $this->concept,
                'value' => $this->value,
            ]);

        } else {

            DIFExpense::create([
                'type' => $this->type,
                'ammount' => $this->ammount,
                'recipient' => $this->recipient,
                'concept' => $this->concept,
                'value' => $this->value,
            ]);

        }

        return redirect()->route('dif.incomes.index');
    }

    public function render()
    {
        return view('dif.expenses.utilities.crud');
    }
}
