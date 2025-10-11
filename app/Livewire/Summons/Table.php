<?php

namespace App\Livewire\Summons;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Http\Request;

use App\Models\Summon;

class Table extends Component
{

    public $mode = 0; // 0: Listado, 1: Index

    public function render()
    {
        $summons = Summon::paginate(10);

        return view('summons.utilities.table', [
            'summons' => $summons,
        ]);
    }
}
