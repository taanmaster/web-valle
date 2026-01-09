<?php

namespace App\Livewire\IdentificationCertificates;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\IdentificationCertificate;

class Table extends Component
{
    use WithPagination;

    public $mode = 0; // 0: Admin, 1: Citizen
    public $userId = null;

    public $search = '';
    public $statusFilter = '';
    public $startDate = '';
    public $endDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
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

        // Busqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('folio', 'like', '%' . $this->search . '%')
                    ->orWhere('full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('curp', 'like', '%' . $this->search . '%');
            });
        }

        // Filtro por estatus
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
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
        ]);
    }
}
