<?php

namespace App\Livewire\Environment\UrbanDevRequests;

use App\Models\UrbanDevRequestReview;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = '';

    public $filterFormat = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterFormat()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'filterStatus', 'filterFormat']);
        $this->resetPage();
    }

    public function render()
    {
        $base = UrbanDevRequestReview::where('dependency', 'medio_ambiente');

        $counts = [
            'alto_impacto' => (clone $base)->where('format', 'alto_impacto')->where('status', '!=', 'emitida')->count(),
            'licencia_ambiental_funcionamiento' => (clone $base)->where('format', 'licencia_ambiental_funcionamiento')->where('status', '!=', 'emitida')->count(),
            'manejo_de_residuos' => (clone $base)->where('format', 'manejo_de_residuos')->where('status', '!=', 'emitida')->count(),
            'emitida' => (clone $base)->where('status', 'emitida')->count(),
        ];

        $query = UrbanDevRequestReview::query()
            ->where('dependency', 'medio_ambiente')
            ->with('urbanDevRequest.user');

        if ($this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterFormat !== '') {
            $query->where('format', $this->filterFormat);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('property_address', 'like', "%{$search}%")
                    ->orWhere('establishment_name', 'like', "%{$search}%")
                    ->orWhereHas('urbanDevRequest', function ($rq) use ($search) {
                        $rq->where('folio', 'like', "%{$search}%");
                    })
                    ->orWhereHas('urbanDevRequest.user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $reviews = $query->latest('sent_at')->paginate(10);

        return view('livewire.environment.urban-dev-requests.table', [
            'reviews' => $reviews,
            'counts' => $counts,
        ]);
    }
}
