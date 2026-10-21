<?php

namespace App\Livewire\ProteccionCivil\Validity;

use App\Models\CivilProtectionCase;
use Livewire\Component;

class Table extends Component
{
    public $search = '';

    public $filterStatus = '';

    public function clearFilters()
    {
        $this->reset(['search', 'filterStatus']);
    }

    /**
     * Expedientes cerrados con documento emitido. La vigencia se calcula en PHP
     * porque depende de los días de vigencia de cada trámite.
     */
    public static function issuedCases(string $search = '')
    {
        return CivilProtectionCase::with('procedure')
            ->where('status', 'emitido')->whereNotNull('document_number')
            ->when($search, fn ($q) => $q->where(fn ($q) => $q
                ->where('applicant_name', 'like', "%{$search}%")
                ->orWhere('document_number', 'like', "%{$search}%")
                ->orWhere('folio', 'like', "%{$search}%")))
            ->orderBy('expires_at')
            ->get();
    }

    public function render()
    {
        $cases = self::issuedCases($this->search);
        $counts = $cases->countBy('validity_status');

        return view('livewire.proteccion-civil.validity.table', [
            'cases' => $this->filterStatus ? $cases->where('validity_status', $this->filterStatus) : $cases,
            'filters' => [
                '' => ['Todos', $cases->count(), 'dark'],
                'vigente' => ['Vigentes', $counts['vigente'] ?? 0, 'success'],
                'por_vencer' => ['Por vencer', $counts['por_vencer'] ?? 0, 'warning'],
                'vencida' => ['Vencidas', $counts['vencida'] ?? 0, 'danger'],
            ],
        ]);
    }
}
