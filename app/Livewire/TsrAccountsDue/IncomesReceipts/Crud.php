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
use Barryvdh\DomPDF\Facade\Pdf;

//Modelos
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueIncomeReceipt;

class Crud extends Component
{
    public $mode = 0;
    public $step = 1;

    public $income;
    public $today;
    public $created_date;

    public $denominaciones = [
        1000 => 0,
        500 => 0,
        200 => 0,
        100 => 0,
        50 => 0,
        20 => 0,
        10 => 0,
        5 => 0,
        2 => 0,
        1 => 0,
        0.5 => 0,
    ];

    public $total_value = 0;

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
    public $denominations_cashier = '';
    public $denominations_payed = '';
    public $total_card = 0;
    public $total_check = 0;
    public $account = '';
    public $total = '';

    public function mount()
    {
        $this->today = Carbon::now()->format('Y-m-d');


        $this->created_date = $this->today;

        $this->account_due_income_id = $this->income->id;
    }

    public function changeStep($num)
    {
        $this->step = $num;
    }

    public function updatedDenominaciones()
    {
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total_value = 0;

        foreach ($this->denominaciones as $valor => $cantidad) {
            $this->total_value += $valor * $cantidad;
        }
    }

    public function save()
    {
        // Crear un array con las denominaciones que se van a guardar
        $saveDeno = array_filter($this->denominaciones, function ($cantidad) {
            return $cantidad > 0; // Solo guardar denominaciones con cantidad mayor a 0
        });

        $total = intval($this->total_value) + intval($this->total_card) + $this->total_check;

        TsrAccountDueIncomeReceipt::create([
            'account_due_income_id' => $this->account_due_income_id,
            'cashier_user' => $this->cashier_user,
            'cashier' => $this->cashier,
            'qty_text' => $this->qty_text,
            'qty_integer' => $this->qty_integer,
            'depositor' => $this->depositor,
            'total_cash' => $this->total_value,
            'denominations' => json_encode($saveDeno),
            'denominations_cashier' => $this->denominations_cashier,
            'denominations_payed' => $this->denominations_payed,
            'total_card' => $this->total_card,
            'total_check' => $this->total_check,
            'account' => $this->account,
            'total' => $total,
        ]);

        session()->flash('message', 'Cobro registrado con éxito.');

        // Mensaje de sesión
        return redirect()->route('account_due_incomes.close', $this->account_due_income_id);
    }

    public function generatePdf()
    {
        return redirect()->route('account_due_incomes.close', $this->account_due_income_id);
    }

    public function render()
    {
        return view('tsr_accounts_due.incomes_receipts.utilities.crud');
    }
}
