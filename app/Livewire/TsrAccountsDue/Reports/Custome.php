<?php

namespace App\Livewire\TsrAccountsDue\Reports;

use Livewire\Component;

// Ayudantes
use Carbon\Carbon;

//Modelos
use App\Models\TsrAccountDueIncomeReceipt;
use App\Models\TsrAccountDueCustomeReport;
use App\Models\BackofficeDependency;
use App\Models\TsrAccountDueIncome;

class Custome extends Component
{
    public $showDrop = false;

    //Campos
    public $start_date = '';
    public $end_date = '';
    public $cashier = '';
    public $cashier_user = '';
    public $dependency_name = '';
    public $concept = '';
    public $orderBy = 'concept';
    public $account = '';
    public $selectedMethods = [];

    //Opciones
    public $cashiers;
    public $userCashiers;
    public $bankAccounts;
    public $dependencies;
    public $concepts;
    public $paymentsMethods;
    public $orderDirection = 'asc';

    public function mount()
    {
        $this->cashiers = TsrAccountDueIncomeReceipt::select('cashier')->distinct()->pluck('cashier');
        $this->userCashiers = TsrAccountDueIncomeReceipt::select('cashier_user')->distinct()->pluck('cashier_user');
        $this->bankAccounts = TsrAccountDueIncomeReceipt::select('account')->distinct()->pluck('account');
        $this->dependencies = BackofficeDependency::select('name')->orderBy('name')->pluck('name');
        $this->concepts = TsrAccountDueIncome::select('concept')->distinct()->pluck('concept');

        $inicio = Carbon::now()->startOfWeek();

        $this->start_date = $inicio->format('Y-m-d');

        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    public function selectMethod($name)
    {
        // Verificar si el método ya está seleccionado
        if (in_array($name, $this->selectedMethods)) {
            // Si está seleccionado, eliminarlo del array
            $this->selectedMethods = array_diff($this->selectedMethods, [$name]);
        } else {
            // Si no está seleccionado, agregarlo al array
            $this->selectedMethods[] = $name;
        }

        $this->showDrop = false;
    }

    public function save()
    {

        $report = new TsrAccountDueCustomeReport;

        $report->cashier_user = $this->cashier_user;
        $report->cashier = $this->cashier;
        $report->dependency_name = $this->dependency_name;
        $report->concept = $this->concept;

        $report->start_date = $this->start_date;
        $report->end_date = $this->end_date;

        $report->account = $this->account;
        $report->payment_methods = json_encode($this->selectedMethods);

        $report->filter = $this->orderDirection;

        $report->save();

        $id = $report->id;

        session()->flash('message', 'Reporte registrado con éxito.');

        return redirect()->route('account_due_custome.export', $id);
    }

    public function render()
    {

        $query = TsrAccountDueIncomeReceipt::query();

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        if ($this->cashier) {
            $query->where('cashier', $this->cashier);
        }
        if ($this->cashier_user) {
            $query->where('cashier_user', $this->cashier_user);
        }

        if ($this->account) {
            $query->where('account', $this->account);
        }

        if ($this->dependency_name || $this->concept) {
            $query->whereHas('income', function ($query) {
                if ($this->dependency_name) {
                    $query->where('department', $this->dependency_name);
                }

                if ($this->concept) {
                    $query->where('concept', $this->concept);
                }
            });
        }

        // Filtrado por métodos de pago
        if (!empty($this->selectedMethods)) {
            // Inicializar una consulta de tipo "or"
            $query->where(function ($query) {
                foreach ($this->selectedMethods as $method) {
                    switch ($method) {
                        case 'Tarjeta':
                            $query->orWhere('total_card', '>', 0);
                            break;
                        case 'Cheque':
                        case 'Voucher':
                            $query->orWhere('total_check', '>', 0);
                            break;
                        case 'Transferencia':
                            $query->orWhere('total_transfer', '>', 0);
                            break;
                        case 'Efectivo':
                            $query->orWhere('total_cash', '>', 0);
                            break;
                    }
                }
            });
        }


        $incomes = $query->get();

        return view('livewire.tsr-accounts-due.reports.custome', [
            'incomes' => $incomes,
        ]);
    }
}
