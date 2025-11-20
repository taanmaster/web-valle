<?php

namespace App\Livewire\Acquisitions\Contracts;

use Livewire\Component;

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

use App\Models\Bidding;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $mode = 0;

    public function render()
    {
        $query = Bidding::query();

        if ($this->mode == 0) {

            $query->where('status', 'Proceso entregables');
        } else {
            $query->where('status', 'Cierre');
        }


        $biddings = $query->latest()->paginate(10);

        return view('acquisitions.contracts.utilities.table', [
            'biddings' => $biddings,
        ]);
    }
}
