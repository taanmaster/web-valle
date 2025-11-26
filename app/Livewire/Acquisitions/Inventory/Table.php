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
use App\Models\AcquisitionMaterial;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $mode = 0;

    public $view = '';

    public function income()
    {
        $this->view = 'Entrada';

        $this->mode = 1;
    }

    public function outcome()
    {
        $this->view = 'Salida';
        $this->mode = 2;
    }

    public function showAll()
    {
        $this->view = '';

        $this->mode = 0;
    }

    public function render()
    {
        if ($this->mode != 0) {
        $query = AcquisitionInventoryMovement::query();

        if (in_array($this->view, ['Entrada', 'Salida'])) {
            $query->where('type', $this->view);
        }
        } else {
            $query = AcquisitionMaterial::query();
        }

        $movements = $query->latest()->paginate(10);

        return view('acquisitions.inventory.utilities.table', [
            'movements' => $movements,
        ]);
    }
}
