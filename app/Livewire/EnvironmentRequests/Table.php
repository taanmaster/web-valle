<?php

namespace App\Livewire\EnvironmentRequests;

use App\Models\EnvironmentRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $requestType = '';

    public $status = '';

    public $folio = '';

    public $nombre = '';

    public $fecha_inicio = '';

    public $fecha_fin = '';

    public function clearFilters()
    {
        $this->reset(['requestType', 'status', 'folio', 'nombre', 'fecha_inicio', 'fecha_fin']);
        $this->resetPage();
    }

    public function updating($property)
    {
        if (in_array($property, ['requestType', 'status', 'folio', 'nombre', 'fecha_inicio', 'fecha_fin'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $counts = [
            'total' => EnvironmentRequest::count(),
            'nuevas' => EnvironmentRequest::where('status', EnvironmentRequest::STATUS_NUEVA)->count(),
            'inspeccion' => EnvironmentRequest::where('status', EnvironmentRequest::STATUS_INSPECCION)->count(),
            'aprobadas' => EnvironmentRequest::where('status', EnvironmentRequest::STATUS_APROBADA)->count(),
        ];

        $query = EnvironmentRequest::query();

        if ($this->requestType !== '') {
            $query->where('request_type', $this->requestType);
        }

        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        if ($this->folio !== '') {
            $query->where('folio', 'like', '%'.$this->folio.'%');
        }

        if ($this->nombre !== '') {
            $query->where('nombre', 'like', '%'.$this->nombre.'%');
        }

        if ($this->fecha_inicio !== '') {
            $query->whereDate('fecha_solicitud', '>=', $this->fecha_inicio);
        }

        if ($this->fecha_fin !== '') {
            $query->whereDate('fecha_solicitud', '<=', $this->fecha_fin);
        }

        $requests = $query->latest()->paginate(10);

        return view('environment.requests.utilities.table', [
            'requests' => $requests,
            'counts' => $counts,
        ]);
    }
}
