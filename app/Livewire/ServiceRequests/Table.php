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
    public $popularRequests = [];

    public $mode = 0;


    public function mount()
    {
        $this->fetchDependencies();

        if ($this->mode == 1) {
            $this->fetchPopularRequests();
        }
    }

    public function fetchPopularRequests()
    {
        $this->popularRequests = ServiceRequest::where('is_favorite', true)->get();
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

    public function toggleFavorite($id)
    {
        $request = ServiceRequest::findOrFail($id);

        $request->is_favorite = !$request->is_favorite;
        $request->save();
    }

    public function render()
    {
        $query = ServiceRequest::query();

        if ($this->title !== '') {
            $query->where('name', $this->title);
        }

        if ($this->dependency_name !== '') {
            $query->where('dependency_name', $this->dependency_name);
        }

        return view('service_requests.utilities.table', [
            'requests' => $query->paginate(10)
        ]);
    }
}
