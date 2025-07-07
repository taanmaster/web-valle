<?php

namespace App\Livewire\TapAccountsPayable;

use Livewire\Component;
use Carbon\Carbon;

//Modelos
use App\Models\TreasuryAccountPayableContractorChecklist;
use App\Models\TreasuryAccountPayableSupplier;
use App\Models\TreasuryAccountPayableSupplierChecklistAutorization;

class Dashboard extends Component
{
    public $start_date = '';
    public $end_date = '';

    public $total_accounts;
    public $programmed_accounts;
    public $overdue_accounts;
    public $payed_accounts;

    public function mount()
    {
        $inicio = Carbon::now()->startOfWeek();

        $this->start_date = $inicio->format('Y-m-d');

        $this->end_date = Carbon::now()->format('Y-m-d');


        $this->total_accounts = TreasuryAccountPayableSupplierChecklistAutorization::get()->count();
    }

    public function render()
    {
        $baseQuery = TreasuryAccountPayableSupplierChecklistAutorization::query();

        if ($this->start_date && $this->end_date) {
            $baseQuery->whereBetween('created_at', [
                Carbon::parse($this->start_date)->startOfDay(),
                Carbon::parse($this->end_date)->endOfDay(),
            ]);
        }

        $query = $baseQuery->get();


        $status = $query->groupBy('status');

        $elements = $status->all();

        $this->total_accounts = $query->count();

        $pagados = $status['pagado'] ?? collect();
        $vencidos = $status['vencido'] ?? collect();
        $programados = $status['programado'] ?? collect();


        return view('livewire.tap-accounts-payable.dashboard', [
            'elements' => $elements,
            'pagados' => $pagados,
            'vencidos' => $vencidos,
            'programados' => $programados
        ]);
    }
}
