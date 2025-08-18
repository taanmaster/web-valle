<?php

namespace App\Livewire\ServiceRequests;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

//Modelos
use App\Models\ServiceRequest;
use App\Models\TransparencyDependency;

class Table extends Component
{

    use WithPagination;

    public $title = '';
    public $dependency_name = '';

    public $dependencies = [];

    public $mode = 0;


    public function mount()
    {
        $this->fetchDependencies();
    }

    public function fetchDependencies()
    {
        $this->dependencies = TransparencyDependency::get();
    }

    public function resetFilters()
    {
        $this->title = '';
        $this->dependency_name = '';
    }

    public function render()
    {
        $query = ServiceRequest::query();

        if ($this->title !== '') {
            $query->where('title', $this->title);
        }

        if ($this->dependency_name !== '') {
            $query->where('dependency_name', $this->dependency_name);
        }

        return view('service-requests.utilities.table', [
            'requests' => $query->paginate(10)
        ]);
    }
}
