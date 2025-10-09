<?php

namespace App\Livewire\MunicipalInspection;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Http\Request;

use App\Models\MunicipalInspection;

class Table extends Component
{

    use WithPagination;

    public $mode = 0; // 0: Listado, 1: Index

    public $years = [];
    public $active_year = '';

    public $dependencies = [];

    public function mount() {
        $this->years = MunicipalInspection::groupBy('year')->orderBy('year', 'desc')->pluck('year')->toArray();

        $this->active_year = $this->years[0] ?? '';
    }

    public function resetFilters()
    {

    }

    public function activeYear($year)
    {
        $this->active_year = $year;
    }

    public function changeStatus($id)
    {
        $inspection = MunicipalInspection::find($id);
        $inspection->is_active = !$inspection->is_active;
        $inspection->save();
    }

    public function render()
    {
        $inspections = MunicipalInspection::where('year', $this->active_year)
            ->orderBy('dependency')
            ->get()
            ->groupBy('dependency');


        return view('municipal_inspections.utilities.table', [
            'inspections_by_dependency' => $inspections
        ]);
    }
}
