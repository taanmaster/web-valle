<?php

namespace App\Livewire\TsrAccountsDue\Reports;

use App\Models\TsrAccountDueDailyReport;
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueIncomeReceipt;
use Livewire\WithPagination;
use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Barryvdh\DomPDF\Facade\Pdf;

class Daily extends Component
{

    use WithPagination;

    public $concepts;

    public $cashiers;
    public $userCashiers;

    public $cashier = '';
    public $cashier_user = '';

    public function mount()
    {
        $this->concepts = TsrAccountDueIncome::select('concept')->distinct()->pluck('concept');
        $this->cashiers = TsrAccountDueIncomeReceipt::select('cashier')->distinct()->pluck('cashier');
        $this->userCashiers = TsrAccountDueIncomeReceipt::select('cashier_user')->distinct()->pluck('cashier_user');
    }

    public function save()
    {
        $report = new TsrAccountDueDailyReport;
        $report->cashier_user = $this->cashier_user;
        $report->cashier = $this->cashier;

        $report->save();

        $id = $report->id;

        session()->flash('message', 'Reporte registrado con éxito.');

        return redirect()->route('account_due_daily.export', $id);
    }

    public function render()
    {
        $incomes = [];

        foreach ($this->concepts as $concept) {

            $query = TsrAccountDueIncomeReceipt::whereHas('income', function ($query) use ($concept) {
                $query->where('concept', $concept);
            });


            if ($this->cashier) {
                $query->where('cashier', $this->cashier);
            }
            if ($this->cashier_user) {
                $query->where('cashier_user', $this->cashier_user);
            }

            // Filtrar por la fecha de hoy
            $query->whereDate('created_at', today()); // Asegúrate de que 'created_at' sea el campo correcto

            $incomes[$concept] = $query->paginate(10, ['*'], "page_{$concept}");
        }

        return view('livewire.tsr-accounts-due.reports.daily', [
            'incomes' => $incomes,
        ]);
    }
}
