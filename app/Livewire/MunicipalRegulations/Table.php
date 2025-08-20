<?php

namespace App\Livewire\MunicipalRegulations;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

use Illuminate\Http\Request;

//Modelos
use App\Models\MunicipalRegulation;

class Table extends Component
{

    use WithPagination;

    public $mode = 0; // 0: Listado, 1: Index

    public $title = '';
    public $regulation_type = '';
    public $publication_type = '';

    public function mount() {}

    public function resetFilters()
    {
        $this->title = '';
        $this->regulation_type = '';
        $this->publication_type = '';
    }

    public function render()
    {
        $query = MunicipalRegulation::query();

        if ($this->title !== '') {
            $query->where('title', $this->title);
        }

        if ($this->regulation_type !== '') {
            $query->where('regulation_type', $this->regulation_type);
        }

        if ($this->publication_type !== '') {
            $query->where('publication_type', $this->publication_type);
        }

        return view('municipal_regulations.utilities.table', [
            'regulations' => $query->paginate(10)
        ]);
    }
}
