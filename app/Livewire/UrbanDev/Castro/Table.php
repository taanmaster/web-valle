<?php

namespace App\Livewire\UrbanDev\Castro;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UrbanDevCastroRequest;

class Table extends Component
{
    use WithPagination;

    // Filtro por estado: all | pendiente | en_captura | completado
    public $filter = 'all';

    public $search = '';

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $counts = [
            'total'      => UrbanDevCastroRequest::count(),
            'pendiente'  => UrbanDevCastroRequest::where('status', 'pendiente')->count(),
            'en_captura' => UrbanDevCastroRequest::where('status', 'en_captura')->count(),
            'completado' => UrbanDevCastroRequest::where('status', 'completado')->count(),
        ];

        $query = UrbanDevCastroRequest::query()
            ->with('urbanDevRequest.user');

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('cuenta_predial', 'like', "%{$search}%")
                    ->orWhere('nombre_contribuyente', 'like', "%{$search}%")
                    ->orWhereHas('urbanDevRequest.user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $castros = $query->latest()->paginate(10);

        return view('urban_dev.catastro.utilities.table', [
            'castros' => $castros,
            'counts'  => $counts,
        ]);
    }
}
