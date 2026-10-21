<?php

namespace App\Livewire\ProteccionCivil\Inspections;

use App\Models\CivilProtectionInspection;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    public function render()
    {
        $mine = fn () => CivilProtectionInspection::where('inspector_id', Auth::id());

        $query = $mine()->with(['case.procedure'])
            ->when($this->search, fn ($q) => $q->whereHas('case', fn ($q) => $q
                ->where('folio', 'like', "%{$this->search}%")
                ->orWhere('applicant_name', 'like', "%{$this->search}%")
                ->orWhereHas('procedure', fn ($q) => $q->where('name', 'like', "%{$this->search}%"))))
            // Pendientes primero, luego las más recientes
            ->orderByRaw("result = 'pendiente' desc")
            ->orderByDesc('scheduled_at');

        $done = ['sin_observaciones', 'con_observaciones', 'no_procede'];

        $kpis = [
            'Por realizar' => $mine()->where('result', 'pendiente')->count(),
            'Para hoy' => $mine()->where('result', 'pendiente')->whereDate('scheduled_at', today())->count(),
            'Atrasadas' => $mine()->where('result', 'pendiente')->whereDate('scheduled_at', '<', today())->count(),
            'Realizadas' => $mine()->whereIn('result', $done)->count(),
            'Cerradas sin realizar' => $mine()->where('result', 'no_realizada')->count(),
        ];

        return view('livewire.proteccion-civil.inspections.table', [
            'inspections' => $query->paginate(20),
            'kpis' => $kpis,
            'total' => $mine()->count(),
        ]);
    }
}
