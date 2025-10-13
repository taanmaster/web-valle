<?php

namespace App\Livewire\Front\TransparencyObligations;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

//Modelos
use App\Models\TransparencyObligation;
use App\Models\TransparencyDocument;


class Table extends Component
{
    use WithPagination;

    //Mode: 0 normal, 1 Filtrado por obligación, 2 Sin tipo
    public $mode;

    public $dependency;
    public $type;

    public $transparency_obligation;

    public $period = '';
    public $year = '';
    public $selectedObligation = '';

    public $years = ['2028', '2027', '2026', '2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015'];

    public function mount()
    {
    }

    public function resetFilters()
    {
        $this->period = '';
        $this->year = '';

        if ($this->mode != 1) {
            $this->selectedObligation = '';
        }
    }

    public function render()
    {
        if ($this->mode == 2) {
            $obligations = TransparencyObligation::where('dependency_id', $this->dependency)->get();
        } else {
            $obligations = TransparencyObligation::where('dependency_id', $this->dependency)->where('type', $this->type)->get();
        }

        $query = TransparencyDocument::query();

        if ($this->period) {
            $query->where('period', $this->period);
        }
        if ($this->year !== '') {
            $query->where('year', $this->year);
        }
        if ($this->selectedObligation) {
            $query->where('obligation_id', $this->selectedObligation);
        }

        $documents = $query->get();

        return view('front.dependencies.utilities.table', [
            'documents' => $documents,
            'obligations' => $obligations,
        ]);
    }
}
