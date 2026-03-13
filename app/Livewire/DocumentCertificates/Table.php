<?php

namespace App\Livewire\DocumentCertificates;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DocumentCertificate;

class Table extends Component
{
    use WithPagination;

    public $mode = 0; // 0: Admin, 1: Citizen
    public $userId = null;

    public $statusFilter = '';
    public $startDate = '';
    public $endDate = '';

    protected $queryString = [
        'statusFilter' => ['except' => ''],
    ];

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->statusFilter = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = DocumentCertificate::query();

        if ($this->mode == 1 && $this->userId) {
            $query->where('user_id', $this->userId);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        $certificates = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('document_certificates.utilities.table', [
            'certificates' => $certificates,
        ]);
    }
}
