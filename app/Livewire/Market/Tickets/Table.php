<?php

namespace App\Livewire\Market\Tickets;

use App\Models\MarketTicket;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Boletas: un solo listado con la etapa de cada una (sustituye al listado de entregas)
 */
class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(as: 'etapa')]
    public $stage = '';

    public $search = '';

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
        $this->reset(['stage', 'search', 'dateFrom', 'dateTo']);
    }

    public function render()
    {
        $base = fn () => MarketTicket::query()
            ->when($this->search, fn ($q) => $q->where(fn ($q) => $q
                ->whereHas('stall', fn ($q) => $q->where('tenant_name', 'like', "%{$this->search}%")
                    ->orWhere('number', 'like', "%{$this->search}%")
                    ->orWhere('space_number', 'like', "%{$this->search}%"))
                ->orWhereRaw("CONCAT(series, '-', LPAD(folio, 5, '0')) like ?", ["%{$this->search}%"])))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo));

        $counts = collect(MarketTicket::STAGES)->map(fn ($s, $key) => $base()->stage($key)->count());

        return view('livewire.market.tickets.table', [
            'tickets' => $base()->with('stall')->when($this->stage, fn ($q) => $q->stage($this->stage))
                ->orderByDesc('id')->paginate(25),
            'counts' => $counts,
            'total' => $base()->count(),
        ]);
    }
}
