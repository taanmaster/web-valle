<?php

namespace App\Livewire\ProteccionCivil\Cases;

use App\Models\CivilProtectionCase;
use App\Models\CivilProtectionProcedure;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $filterStatus = '';

    public $filterProcedure = '';

    public $filterOrigin = '';

    public $dateFrom = '';

    public $dateTo = '';

    public function updating($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function clearFilters()
    {
        $this->reset(['search', 'filterStatus', 'filterProcedure', 'filterOrigin', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function render()
    {
        $query = CivilProtectionCase::submitted()->with('procedure')
            ->when($this->search, fn ($q) => $q->where(fn ($q) => $q
                ->where('folio', 'like', "%{$this->search}%")
                ->orWhere('applicant_name', 'like', "%{$this->search}%")))
            ->when($this->filterStatus === 'por_vencer', fn ($q) => $q->expiringSoon())
            ->when($this->filterStatus && $this->filterStatus !== 'por_vencer', fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterProcedure, fn ($q) => $q->where('civil_protection_procedure_id', $this->filterProcedure))
            ->when($this->filterOrigin, fn ($q) => $q->where('origin', $this->filterOrigin))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo));

        $kpis = [
            'en_revision' => ['En revisión', CivilProtectionCase::where('status', 'en_revision')->count()],
            'requiere_correccion' => ['Con correcciones', CivilProtectionCase::where('status', 'requiere_correccion')->count()],
            'inspeccion_programada' => ['Inspecciones programadas', CivilProtectionCase::where('status', 'inspeccion_programada')->count()],
            'entero_generado' => ['Pagos pendientes', CivilProtectionCase::where('status', 'entero_generado')->count()],
            'por_vencer' => ['Por vencer', CivilProtectionCase::expiringSoon()->count()],
        ];

        return view('livewire.proteccion-civil.cases.table', [
            'cases' => $query->latest('submitted_at')->paginate(20),
            'kpis' => $kpis,
            'procedures' => CivilProtectionProcedure::orderBy('name')->get(['id', 'name']),
        ]);
    }
}
