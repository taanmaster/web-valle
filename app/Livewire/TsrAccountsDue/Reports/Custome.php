<?php

namespace App\Livewire\TsrAccountsDue\Reports;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

//Modelos
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueIncomeReceipt;
use App\Models\TransparencyDependency;

class Custome extends Component
{

    public $start_date = '';
    public $end_date = '';

    public $cashiers = [];

    public $userCashiers = [];
    public $bankAccount = [];
    public $paymentsMethods = [];
    public $users = [];
    public $filterBy = [];

    public function mount() {}

    public function render()
    {

        $query = TsrAccountDueIncomeReceipt::query();

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        $incomes = $query->latest()->paginate(8);

        return view('livewire.tsr-accounts-due.reports.custome', [
            'incomes' => $incomes,
        ]);
    }
}
