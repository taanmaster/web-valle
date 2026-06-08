<?php

namespace App\Livewire\TsrAccountsDue\IncomesReceipts;

use Livewire\Component;

// Ayudantes
use Auth;
use Carbon\Carbon;
use Livewire\Attributes\Validate;

//Modelos
use App\Models\TsrAccountDueIncomeReceipt;

class Crud extends Component
{
    public $mode = 0;

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
    public $total_transfer = 0;
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
        $this->cashier_user = Auth::user()->name ?? '';
        $this->depositor = $this->income->name ?? '';
        $this->qty_integer = $this->income->qty_integer ?? '';
        $this->qty_text = $this->income->qty_text ?? '';
    }

    public function updatedQtyInteger($value)
    {
        if ($value === '' || $value === null) {
            $this->qty_text = '';
            return;
        }

        $this->qty_text = $this->formatAmountToWords((float) $value);
    }

    private function formatAmountToWords(float $totalAmt, string $currency = 'PESOS'): string
    {
        $enteros = (int) floor($totalAmt);
        $decimales = str_pad((int) round(($totalAmt - $enteros) * 100), 2, '0', STR_PAD_LEFT);

        return $this->numToWordsPDF($enteros) . ' ' . $currency . ' CON ' . $decimales . '/100';
    }

    private function numToWordsPDF(int $n): string
    {
        if ($n === 0) {
            return 'CERO';
        }

        $u = [
            '', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE',
            'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE',
            'DIECIOCHO', 'DIECINUEVE', 'VEINTE'
        ];
        $d = ['', '', 'VEINTI', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
        $c = [
            '', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS',
            'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'
        ];

        if ($n <= 20) {
            return $u[$n];
        }

        if ($n === 100) {
            return 'CIEN';
        }

        if ($n < 100) {
            $dz = intdiv($n, 10);
            $un = $n % 10;

            if ($un === 0) {
                return $d[$dz];
            }

            return $dz === 2
                ? 'VEINTI' . strtolower($u[$un])
                : $d[$dz] . ' Y ' . $u[$un];
        }

        if ($n < 1000) {
            $cv = intdiv($n, 100);
            $r = $n % 100;
            return $r === 0 ? $c[$cv] : $c[$cv] . ' ' . $this->numToWordsPDF($r);
        }

        if ($n < 2000) {
            return 'MIL' . ($n % 1000 > 0 ? ' ' . $this->numToWordsPDF($n % 1000) : '');
        }

        if ($n < 1000000) {
            $m = intdiv($n, 1000);
            $r = $n % 1000;
            return $this->numToWordsPDF($m) . ' MIL' . ($r > 0 ? ' ' . $this->numToWordsPDF($r) : '');
        }

        if ($n < 2000000) {
            return 'UN MILLON' . ($n % 1000000 > 0 ? ' ' . $this->numToWordsPDF($n % 1000000) : '');
        }

        $m = intdiv($n, 1000000);
        $r = $n % 1000000;

        return $this->numToWordsPDF($m) . ' MILLONES' . ($r > 0 ? ' ' . $this->numToWordsPDF($r) : '');
    }

    public function changeStep($num)
    {
        // Flujo simplificado: se conserva el metodo para compatibilidad,
        // pero el recibo ya no utiliza pasos.
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

    public function updatedTotalCash()
    {
        $this->syncTotals();
    }

    public function updatedTotalCard()
    {
        $this->syncTotals();
    }

    public function updatedTotalCheck()
    {
        $this->syncTotals();
    }

    public function updatedTotalTransfer()
    {
        $this->syncTotals();
    }

    private function syncTotals(): void
    {
        $totalCash = (float) ($this->total_cash ?: 0);
        $totalCard = (float) ($this->total_card ?: 0);
        $totalCheck = (float) ($this->total_check ?: 0);
        $totalTransfer = (float) ($this->total_transfer ?: 0);

        $total = $totalCash + $totalCard + $totalCheck + $totalTransfer;

        $this->qty_integer = $total;
        $this->total = $total;
        $this->qty_text = $this->formatAmountToWords($total);
    }

    public function save()
    {
        $totalCash = (float) ($this->total_cash ?: 0);
        $totalCard = (float) ($this->total_card ?: 0);
        $totalCheck = (float) ($this->total_check ?: 0);
        $totalTransfer = (float) ($this->total_transfer ?: 0);
        $total = $totalCash + $totalCard + $totalCheck + $totalTransfer;

        $this->qty_integer = $total;
        $this->total = $total;
        $this->qty_text = $this->formatAmountToWords($total);

        TsrAccountDueIncomeReceipt::create([
            'account_due_income_id' => $this->account_due_income_id,
            'cashier_user' => $this->cashier_user,
            'cashier' => $this->cashier,
            'qty_text' => $this->qty_text,
            'qty_integer' => $this->qty_integer,
            'depositor' => $this->depositor,
            'total_cash' => $totalCash,
            'denominations' => null,
            'denominations_cashier' => $this->denominations_cashier,
            'denominations_payed' => $this->denominations_payed,
            'total_card' => $totalCard,
            'total_check' => $totalCheck,
            'total_transfer' => $totalTransfer,
            'account' => $this->account,
            'total' => $total,
        ]);

        if (!empty($this->income?->provisional_integer_id)) {
            $integer = $this->income->integer;
            if ($integer) {
                $integer->update(['status' => 'cobrado']);
            }
        }

        session()->flash('message', 'Cobro registrado con éxito.');

        // Mensaje de sesión
        return redirect()->route('account_due_incomes.show', $this->account_due_income_id);
    }

    public function render()
    {
        return view('tsr_accounts_due.incomes_receipts.utilities.crud');
    }
}
