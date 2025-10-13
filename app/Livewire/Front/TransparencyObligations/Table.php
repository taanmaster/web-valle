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

class Table extends Component
{
    use WithPagination;

    public $dependency;

    public $period = '';
    public $type = '';

    public function resetFilters()
    {
        $this->period = '';
        $this->type = '';
    }

    public function render()
    {
        $query = TransparencyObligation::where('dependency_id', $this->dependency);

        if ($this->period) {
            $query->where('update_period', $this->period);
        }
        if ($this->type !== '') {
            $query->where('type', $this->type);
        }

        $obligations = $query->get();

        return view('front.dependencies.utilities.table', [
            'obligations' => $obligations,
        ]);
    }
}
