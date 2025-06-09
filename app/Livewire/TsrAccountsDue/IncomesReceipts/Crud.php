<?php

namespace App\Livewire\TsrAccountsDue\IncomesReceipts;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueIncomeReceipt;

class Crud extends Component
{
    public $mode;
    public $step;

    public $income;
    public $today;

    // Campos
    #[Validate('required')]
    public $account_due_income_id = '';
    public $cashier_user = '';
    public $cashier = '';
    public $qty_text = '';
    public $qty_integer = '';
    public $depositor = '';
    public $total_cash = '';
    public $denominations = '';
    public $total_card = '';
    public $total_check = '';
    public $account = '';
    public $total = '';

    public function mount()
    {
        $this->today = Carbon::now()->format('Y-m-d');


        $this->created_date = $this->today;
    }

    public function save()
    {
        $this->validate();

        TsrAccountDueIncomeReceipt::create([
            'account_due_income_id' => $this->account_due_income_id,
        ]);
    }

    public function render()
    {
        return view('tsr_accounts_due.incomes_receipts.utilities.crud');
    }
}
