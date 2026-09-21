<?php

namespace App\Livewire\UrbanDev\SareRequests;

use App\Models\SareRequestReview;
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
        $counts = [
            'total' => SareRequestReview::where('dependency', 'urban_dev')->count(),
            'nuevo' => SareRequestReview::where('dependency', 'urban_dev')->where('status', 'nuevo')->count(),
            'en_proceso' => SareRequestReview::where('dependency', 'urban_dev')->where('status', 'en_proceso')->count(),
            'completado' => SareRequestReview::where('dependency', 'urban_dev')->where('status', 'completado')->count(),
        ];

        $query = SareRequestReview::query()
            ->where('dependency', 'urban_dev')
            ->with('sareRequest.user');

        if ($this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('sareRequest', function ($sq) use ($search) {
                    $sq->where('request_num', 'like', "%{$search}%");
                })->orWhereHas('sareRequest.user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $reviews = $query->latest()->paginate(10);

        return view('urban_dev.sare_requests.utilities.table', [
            'reviews' => $reviews,
            'counts' => $counts,
        ]);
    }
}
