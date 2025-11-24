<?php

namespace App\Livewire\Acquisitions\Materials;

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

use App\Models\AcquisitionMaterial;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $query = AcquisitionMaterial::query();

        $materials = $query->latest()->paginate(10);

        return view('acquisitions.materials.utilities.table', [
            'materials' => $materials
        ]);
    }
}
