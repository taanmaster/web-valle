<?php

namespace App\Livewire\TsrAccountsDue\IncomesReceipts;

use App\Models\TsrAccountDueIncomeReceipt;
use Livewire\Component;

class Table extends Component
{

    public $income;

    public function render()
    {
        $receipts = TsrAccountDueIncomeReceipt::where('account_due_income_id', $this->income->id)->get();

        return view('tsr_accounts_due.incomes_receipts.utilities.table', [
            'receipts' => $receipts
        ]);
    }
}
