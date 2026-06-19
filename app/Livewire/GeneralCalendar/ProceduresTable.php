<?php

namespace App\Livewire\GeneralCalendar;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\GeneralCalendarProcedure;

class ProceduresTable extends Component
{
    use WithPagination;

    public bool $show_filters = false;

    public $filter_nombre  = '';
    public $filter_estatus = '';

    public function toggleFilters(): void
    {
        $this->show_filters = !$this->show_filters;
    }

    public function resetFilters(): void
    {
        $this->reset(['filter_nombre', 'filter_estatus']);
        $this->resetPage();
    }

    public function updatedFilterNombre(): void
    {
        $this->resetPage();
    }

    public function updatedFilterEstatus(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        GeneralCalendarProcedure::findOrFail($id)->delete();

        session()->flash('success', 'Trámite eliminado correctamente.');
    }

    public function render()
    {
        $query = GeneralCalendarProcedure::query();

        if ($this->filter_nombre) {
            $query->where('name', 'like', '%' . $this->filter_nombre . '%');
        }

        if ($this->filter_estatus !== '') {
            $query->where('status', (bool) $this->filter_estatus);
        }

        return view('general-calendar.utilities.procedures-table', [
            'procedures' => $query->latest()->paginate(10),
        ]);
    }
}
