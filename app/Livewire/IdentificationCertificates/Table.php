<?php

namespace App\Livewire\IdentificationCertificates;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\IdentificationCertificate;

class Table extends Component
{
    use WithPagination;

    public $mode = 0; // 0: Admin, 1: Citizen
    public $userId = null;

    public $statusFilter = '';
    public $typeFilter = '';
    public $startDate = '';
    public $endDate = '';

    protected $queryString = [
        'statusFilter' => ['except' => ''],
    ];

    public function mount(int $mode = 0, $userId = null): void
    {
        $this->mode   = $mode;
        $this->userId = $userId;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    #[On('filterByType')]
    public function filterByType(string $type = ''): void
    {
        $this->typeFilter = $type;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->statusFilter = '';
        $this->typeFilter = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = IdentificationCertificate::query();

        // Si es modo ciudadano, filtrar por usuario
        if ($this->mode == 1 && $this->userId) {
            $query->where('user_id', $this->userId);
        }

        // Filtro por estatus
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Filtro por tipo de constancia
        if ($this->typeFilter) {
            $query->where('certificate_type', $this->typeFilter);
        }

        // Filtro por fechas
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        $certificates = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('identification_certificates.utilities.table', [
            'certificates' => $certificates,
            'mode'         => $this->mode,
        ]);
    }
}
