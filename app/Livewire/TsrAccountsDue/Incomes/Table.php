<?php

namespace App\Livewire\TsrAccountsDue\Incomes;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

//Modelos
use App\Models\TsrAccountDueIncome;
use App\Models\TransparencyDependency;


class Table extends Component
{
    use WithPagination;

    public $start_date = '';
    public $end_date = '';
    public $departments_names = [];
    public $concepts_names = [];
    public $basis_names = [];
    public $code = '';

    public $dependencies = [];
    public $concepts = [];
    public $basis = [];

    public function mount()
    {
        // Cargar las dependencias de transparencia
        $this->dependencies = TransparencyDependency::where('belongs_to_treasury', true)->get();
    }

    public function resetFilters()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->departments_names = [];
        $this->concepts_names = [];
        $this->basis_names = [];
        $this->code = [];
    }

    public function render()
    {
        $query = TsrAccountDueIncome::query();

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        if ($this->code !== '') {
            $query->where('code', 'like', '%' . $this->code . '%');
        }

        if (!empty($this->departments_names)) {
            $query->whereIn('department', $this->departments_names);
        }

        if (!empty($this->concepts_names)) {
            $query->whereIn('concept', $this->concepts_names);
        }

        if (!empty($this->basis_names)) {
            $query->whereIn('basis', $this->basis_names);
        }

        $incomes = $query->latest()->paginate(8);

        return view('tsr_accounts_due.incomes.utilities.table', [
            'incomes' => $incomes,
        ]);
    }
}
