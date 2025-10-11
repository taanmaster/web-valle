<?php

namespace App\Livewire\CouncilMinute;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Http\Request;

use App\Models\CouncilMinute;

class Table extends Component
{

    public $mode = 0; // 0: Listado, 1: Index

    public $years = [];
    public $active_year = '';

    public function mount()
    {
        $this->years = CouncilMinute::groupBy('year')->orderBy('year', 'desc')->pluck('year')->toArray();

        $this->active_year = $this->years[0] ?? '';
    }

    public function activeYear($year)
    {
        $this->active_year = $year;
    }

    public function changeStatus($id)
    {
        $minute = CouncilMinute::find($id);
        $minute->is_active = !$minute->is_active;
        $minute->save();
    }

    public function render()
    {
        $minutes = CouncilMinute::where('year', $this->active_year)
            ->orderBy('session')
            ->get()
            ->groupBy('session');

        return view('council_minutes.utilities.table', [
            'minutes' => $minutes,
        ]);
    }
}
