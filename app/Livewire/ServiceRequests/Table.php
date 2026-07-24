<?php

namespace App\Livewire\ServiceRequests;

use App\Models\RegulatoryAgendaDependency;
use App\Models\ServiceRequest;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/* Listado del catálogo de Trámites y Servicios.
   Modo 0: backoffice (Mejora Regulatoria). Modo 1: portal ciudadano. */

class Table extends Component
{
    use WithPagination;

    // Modos: 0 backoffice, 1 portal ciudadano
    #[Locked]
    public $mode = 0;

    public $search = '';

    public $filterDependency = '';

    public $filterType = '';

    public $filterStatus = '';

    public $dependencies = [];

    public $popularRequests = [];

    public function mount()
    {
        $this->fetchDependencies();

        if ($this->mode == 1) {
            $this->fetchPopularRequests();
        }
    }

    public function fetchDependencies()
    {
        $this->dependencies = RegulatoryAgendaDependency::orderBy('name')->get();
    }

    public function fetchPopularRequests()
    {
        $this->popularRequests = ServiceRequest::where('is_favorite', true)
            ->where('status', ServiceRequest::STATUS_PUBLISHED)
            ->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterDependency()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function setTab($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'filterDependency', 'filterType', 'filterStatus']);
        $this->resetPage();
    }

    /**
     * Los métodos que mutan datos solo aplican al backoffice (modo 0),
     * que siempre se monta detrás de rutas autenticadas.
     */
    private function ensureBackoffice(): void
    {
        abort_if($this->mode != 0 || ! auth()->check(), 403);
    }

    public function toggleFavorite($id)
    {
        $this->ensureBackoffice();

        $request = ServiceRequest::findOrFail($id);

        $request->is_favorite = ! $request->is_favorite;
        $request->save();
    }

    public function delete($id)
    {
        $this->ensureBackoffice();

        $request = ServiceRequest::findOrFail($id);

        // La tabla de costos no tiene FK con cascade; se limpia manualmente
        $request->costs()->delete();
        $request->delete();

        session()->flash('success', 'El trámite ha sido eliminado correctamente.');
    }

    private function baseQuery()
    {
        $query = ServiceRequest::query();

        // El portal ciudadano solo muestra trámites publicados
        if ($this->mode == 1) {
            $query->where('status', ServiceRequest::STATUS_PUBLISHED);
        }

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('homoclave', 'like', '%'.$this->search.'%')
                    ->orWhere('dependency_name', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->filterDependency !== '') {
            $query->where('dependency_name', $this->filterDependency);
        }

        if ($this->filterType !== '') {
            $query->where('type', $this->filterType);
        }

        return $query;
    }

    public function render()
    {
        $query = $this->baseQuery();

        if ($this->mode == 0 && $this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        $stats = [
            'total' => ServiceRequest::count(),
            'published' => ServiceRequest::where('status', ServiceRequest::STATUS_PUBLISHED)->count(),
            'review' => ServiceRequest::where('status', ServiceRequest::STATUS_REVIEW)->count(),
            'drafts' => ServiceRequest::where('status', ServiceRequest::STATUS_DRAFT)->count(),
        ];

        return view('service_requests.utilities.table', [
            'requests' => $query->orderBy('updated_at', 'desc')->paginate(10),
            'stats' => $stats,
        ]);
    }
}
