<?php

namespace App\Livewire\ProteccionCivil\Requests;

use App\Models\UrbanDevRequestReview;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'filterStatus']);
        $this->resetPage();
    }

    public function render()
    {
        $base = UrbanDevRequestReview::where('dependency', 'proteccion_civil');

        $counts = [
            'total' => (clone $base)->count(),
            'recibida' => (clone $base)->where('status', 'recibida')->count(),
            'en_revision' => (clone $base)->where('status', 'en_revision')->count(),
            'emitida' => (clone $base)->where('status', 'emitida')->count(),
        ];

        $query = UrbanDevRequestReview::query()
            ->where('dependency', 'proteccion_civil')
            ->with('urbanDevRequest.user');

        if ($this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('property_address', 'like', "%{$search}%")
                    ->orWhereHas('urbanDevRequest', function ($rq) use ($search) {
                        $rq->where('folio', 'like', "%{$search}%");
                    })
                    ->orWhereHas('urbanDevRequest.user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $reviews = $query->latest('sent_at')->paginate(10);

        return view('livewire.proteccion-civil.requests.table', [
            'reviews' => $reviews,
            'counts' => $counts,
        ]);
    }
}
