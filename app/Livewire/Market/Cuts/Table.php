<?php

namespace App\Livewire\Market\Cuts;

use App\Models\MarketCut;
use App\Models\MarketTicket;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

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
        $this->reset(['dateFrom', 'dateTo']);
    }

    public function render()
    {
        $cuts = MarketCut::with('creator')
            ->withCount(['tickets as missing_receipts' => fn ($q) => $q->whereNull('receipt_s3_url')->whereNull('cancelled_at')])
            ->when($this->dateFrom, fn ($q) => $q->whereDate('cut_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('cut_date', '<=', $this->dateTo))
            ->orderByDesc('cut_date')->orderByDesc('id')
            ->paginate(20);

        $pending = MarketTicket::stage('por_cortar');

        return view('livewire.market.cuts.table', [
            'cuts' => $cuts,
            'pendingCount' => (clone $pending)->count(),
            'pendingTotal' => (clone $pending)->sum('amount'),
        ]);
    }
}
