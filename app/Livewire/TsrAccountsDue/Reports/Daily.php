<?php

namespace App\Livewire\TsrAccountsDue\Reports;

use App\Models\TsrAccountDueDailyReport;
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueIncomeReceipt;
use App\Models\BackofficeDependency;
use Livewire\WithPagination;
use Livewire\Component;

// Ayudantes

class Daily extends Component
{

    use WithPagination;

    public $concepts;
    public $dependencies;

    public $cashiers;
    public $userCashiers;

    public $cashier = '';
    public $cashier_user = '';
    public $dependency_name = '';
    public $concept = '';

    public function mount()
    {
        $this->concepts = TsrAccountDueIncome::select('concept')->distinct()->pluck('concept');
        $this->dependencies = BackofficeDependency::select('name')->orderBy('name')->pluck('name');
        $this->cashiers = TsrAccountDueIncomeReceipt::select('cashier')->distinct()->pluck('cashier');
        $this->userCashiers = TsrAccountDueIncomeReceipt::select('cashier_user')->distinct()->pluck('cashier_user');
    }

    public function save()
    {
        return $this->createReportAndRedirect('account_due_daily.export');
    }

    public function exportExcel()
    {
        return $this->createReportAndRedirect('account_due_daily.export_excel');
    }

    private function createReportAndRedirect(string $routeName)
    {
        $report = new TsrAccountDueDailyReport;
        $report->cashier_user = $this->cashier_user;
        $report->cashier = $this->cashier;
        $report->dependency_name = $this->dependency_name;
        $report->concept = $this->concept;

        $report->save();

        $id = $report->id;

        session()->flash('message', 'Reporte registrado con éxito.');

        return redirect()->route($routeName, $id);
    }

    public function render()
    {
        $incomes = [];

        $conceptsToRender = $this->concept ? collect([$this->concept]) : $this->concepts;

        foreach ($conceptsToRender as $concept) {

            $query = TsrAccountDueIncomeReceipt::whereHas('income', function ($query) use ($concept) {
                $query->where('concept', $concept);

                if ($this->dependency_name) {
                    $query->where('department', $this->dependency_name);
                }
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
