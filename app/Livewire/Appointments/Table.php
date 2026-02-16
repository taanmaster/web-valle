<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\BackofficeDependency;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterDependency = '';
    public $filterStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterDependency()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterDependency = '';
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function delete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        session()->flash('success', 'Trámite eliminado correctamente.');
    }

    public function render()
    {
        $appointments = Appointment::with('dependency')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterDependency, function ($q) {
                $q->where('backoffice_dependency_id', $this->filterDependency);
            })
            ->when($this->filterStatus !== '', function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $dependencies = BackofficeDependency::orderBy('name')->get();

        return view('livewire.appointments.table', [
            'appointments' => $appointments,
            'dependencies' => $dependencies,
        ]);
    }
}
