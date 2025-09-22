<?php

namespace App\Livewire\DIF\Expenses;

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

//Modelos
use App\Models\DIFExpense;

use Livewire\Component;

class Table extends Component
{
    use WithPagination;

    public $start_date = '';
    public $end_date = '';
    public $type = '';

    public function mount() {}

    public function resetFilters()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->type = '';
    }

    public function downloadFile($id)
    {
        $expense = DIFExpense::find($id);

        $filename = "salida_" . Str::slug($expense->id) . ".pdf";

        $pdf = PDF::loadView('dif.expenses.utilities.pdf', [
            'expense' => $expense
        ]);

        // Crear directorio si no existe
        $directory = public_path('expenses/');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $pdf->save($directory . $filename);

        $myFile = $directory . $filename;

        return response()->download($myFile);
    }

    public function render()
    {
        $query = DIFExpense::query();

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }
        if ($this->type !== '') {
            $query->where('type', $this->type);
        }
        /*
        if ($this->product !== '') {
            $query->where('product', $this->product);
        }
        */


        $expenses = $query->latest()->paginate(8);

        return view('dif.expenses.utilities.table', [
            'expenses' => $expenses
        ]);
    }
}
