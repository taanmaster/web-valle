<?php

namespace App\Livewire\Panteon;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Panteon;

class EntriesTable extends Component
{
    use WithPagination;

    public $filter_folio = '';
    public $filter_fecha = '';
    public $show_filters = false;

    public function toggleFilters()
    {
        $this->show_filters = !$this->show_filters;
    }

    public function resetFilters()
    {
        $this->filter_folio = '';
        $this->filter_fecha = '';
        $this->resetPage();
    }

    public function updatedFilterFolio()
    {
        $this->resetPage();
    }

    public function updatedFilterFecha()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Panteon::query();

        if ($this->filter_folio) {
            $query->where('folio', 'like', '%' . $this->filter_folio . '%');
        }

        if ($this->filter_fecha) {
            $query->whereDate('fecha', $this->filter_fecha);
        }

        $panteones = $query->latest()->paginate(10);

        return view('panteones.utilities.entries-table', [
            'panteones' => $panteones,
        ]);
    }
}
