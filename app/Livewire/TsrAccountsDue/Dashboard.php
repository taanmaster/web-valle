<?php

namespace App\Livewire\TsrAccountsDue;

use Livewire\Component;
use Carbon\Carbon;


//Modelos
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueIncomeReceipt;
use App\Models\TsrAccountDueProfile;
use App\Models\TsrAccountDueProvisionalInteger;
use App\Models\TransparencyDependency;

class Dashboard extends Component
{
    public $start_date = '';
    public $end_date = '';

    // Dependencias de tesorería
    public $dependencies = [];

    public $selectDependency;

    public $activeAccounts = '';

    public $total = '';

    public $weekDays = [];
    public $data = [];
    public $jsonData;


    public function mount()
    {
        // Cargar las dependencias de transparencia
        $this->dependencies = TransparencyDependency::where('belongs_to_treasury', true)->get();

        $inicio = Carbon::now()->startOfWeek();


        $this->start_date = $inicio->format('Y-m-d');

        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->selectDependency = $this->dependencies->first()->name;

        $this->activeAccounts = TsrAccountDueProfile::get()->count();

        $this->total = TsrAccountDueProvisionalInteger::sum('qty_integer');

        for ($i = 0; $i < 5; $i++) {
            $this->weekDays[] = $inicio->copy()->addDays($i)->format('d');
        }


        for ($i = 0; $i < 5; $i++) {
            $fecha = $inicio->copy()->addDays($i);
            $incomes = $this->totalIncomes($fecha); // Función que debes definir para obtener el total

            $this->data[] = [
                'x' => $fecha->format('d'), // Día del mes
                'y' => $incomes // Total de TsrAccountDueIncomes
            ];
        }

        $this->jsonData = json_encode($this->data);
    }

    function totalIncomes($fecha)
    {
        return TsrAccountDueIncome::whereDate('created_at', $fecha)->count();
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

        $incomes = $query->latest()->paginate(8);


        $querytwo = TsrAccountDueIncome::query();

        if ($this->start_date) {
            $querytwo->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $querytwo->whereDate('created_at', '<=', $this->end_date);
        }

        if ($this->selectDependency) {
            $querytwo->where('department', $this->selectDependency);
        }

        $ingresos = $querytwo->latest()->paginate(8);


        return view('livewire.tsr-accounts-due.dashboard', [
            'incomes' => $incomes,
            'ingresos' => $ingresos,
        ]);
    }
}
