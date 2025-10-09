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

    public function mount() {}

    public function resetFilters()
    {

    }

    public function render()
    {
        return view('municipal_inspections.utilities.table');
    }
}
