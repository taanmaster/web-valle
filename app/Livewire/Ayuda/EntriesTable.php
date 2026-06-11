<?php

namespace App\Livewire\Ayuda;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Guia;
use App\Models\GuiaCategoria;

class EntriesTable extends Component
{
    use WithPagination;

    public $show_filters = false;
    public $filter_fecha = '';
    public $filter_categoria = '';
    public $filter_dependencia = '';

    public function toggleFilters(): void
    {
        $this->show_filters = !$this->show_filters;
    }

    public function resetFilters(): void
    {
        $this->filter_fecha = '';
        $this->filter_categoria = '';
        $this->filter_dependencia = '';
        $this->resetPage();
    }

    public function updatedFilterFecha(): void { $this->resetPage(); }
    public function updatedFilterCategoria(): void { $this->resetPage(); }
    public function updatedFilterDependencia(): void { $this->resetPage(); }

    public function render()
    {
        $query = Guia::with('categoria')->latest();

        if ($this->filter_fecha) {
            $query->whereDate('fecha_entrada', $this->filter_fecha);
        }
        if ($this->filter_categoria) {
            $query->where('guia_categoria_id', $this->filter_categoria);
        }
        if ($this->filter_dependencia) {
            $query->where('dependencia', 'like', '%' . $this->filter_dependencia . '%');
        }

        return view('ayuda.utilities.entries-table', [
            'guias'      => $query->paginate(12),
            'categorias' => GuiaCategoria::orderBy('nombre')->get(),
        ]);
    }
}
