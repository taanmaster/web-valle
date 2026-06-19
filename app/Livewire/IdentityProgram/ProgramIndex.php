<?php

namespace App\Livewire\IdentityProgram;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\IdentityProgram;

class ProgramIndex extends Component
{
    use WithPagination;

    public $filter_fecha  = '';
    public $filter_titulo = '';

    public function resetFilters(): void
    {
        $this->reset(['filter_fecha', 'filter_titulo']);
        $this->resetPage();
    }

    public function updatedFilterFecha(): void
    {
        $this->resetPage();
    }

    public function updatedFilterTitulo(): void
    {
        $this->resetPage();
    }

    public function getHasFiltersProperty(): bool
    {
        return $this->filter_fecha !== '' || $this->filter_titulo !== '';
    }

    public function render()
    {
        // Solo entradas cuya fecha de entrada ya llegó (hoy o anterior)
        $query = IdentityProgram::whereDate('published_at', '<=', now());

        if ($this->filter_fecha) {
            $query->whereDate('published_at', $this->filter_fecha);
        }

        if ($this->filter_titulo) {
            $query->where('title', 'like', '%' . $this->filter_titulo . '%');
        }

        return view('identity-program.utilities.program-index', [
            'entries' => $query->orderByDesc('published_at')->orderByDesc('id')->paginate(12),
        ]);
    }
}
