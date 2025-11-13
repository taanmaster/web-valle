<?php

namespace App\Livewire\Bidding\Contract;

use Livewire\Component;

class Table extends Component
{
    //Mode: 0 = All, 1 Closed
    public $mode = 0;

    public function render()
    {
        return view('acquisitions.contracts.utilities.table');
    }
}
