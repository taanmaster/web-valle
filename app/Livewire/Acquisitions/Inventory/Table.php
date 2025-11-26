<?php

namespace App\Livewire\Acquisitions\Inventory;

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

use App\Models\AcquisitionInventoryMovement;
class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $mode = 0;

    public function render()
    {
        $query = AcquisitionInventoryMovement::query();

        $movements = $query->latest()->paginate(10);

        return view('acquisitions.inventory.utilities.table', [
            'movements' => $movements,
        ]);
    }
}
