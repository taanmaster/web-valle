<?php

namespace App\Livewire\DIF\Incomes;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;
use Carbon\Carbon;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Http\Request;

use Livewire\Component;
use App\Models\DIFIncome;

class Table extends Component
{
    use WithPagination;

    public $start_date = '';
    public $end_date = '';
    public $type = '';
    public $payment_method = '';

    public $total_ammount = '';

    public function mount() {
        $this->total_ammount = DIFIncome::sum('ammount');
    }

    public function resetFilters()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->type = '';
        $this->payment_method = '';
    }

    public function render()
    {
        $query = DIFIncome::query();

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }
        if ($this->type !== '') {
            $query->where('type', $this->type);
        }
        if ($this->payment_method !== '') {
            $query->where('payment_method', $this->payment_method);
        }

        $incomes = $query->latest()->paginate(8);

        return view('dif.incomes.utilities.table', [
            'incomes' => $incomes
        ]);
    }
}
