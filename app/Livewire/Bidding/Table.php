<?php

namespace App\Livewire\Bidding;

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

    public function mount()
    {
        $biddings = Bidding::whereNull('title')
            ->orWhere('title', '')
            ->get();

        foreach ($biddings as $bidding) {
            $bidding->delete();
        }
    }

    public function render()
    {
        $query = Bidding::query();

        $biddings = $query->latest()->paginate(10);

        return view('acquisitions.bidding.utilities.table', [
            'biddings' => $biddings,
        ]);
    }
}
