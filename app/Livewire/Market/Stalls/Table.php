<?php

namespace App\Livewire\Market\Stalls;

use App\Models\MarketCollectionNote;
use App\Models\MarketStall;
use Auth;
use Livewire\Component;

/**
 * Padrón del Mercado. Incluye la cartera vencida: las tarjetas de adeudo filtran la lista.
 */
class Table extends Component
{
    public $search = '';

    public $filterType = '';

    public $filterLocation = '';

    public $filterBusiness = '';

    public $filterStatus = '';

    // Registrar gestión de cobro desde la lista
    public $noteStallId = null;

    public $noteDate;

    public $noteComment = '';

    // Aviso de adeudo imprimible
    public $noticeStallId = null;

    public function clearFilters()
    {
        $this->reset(['search', 'filterType', 'filterLocation', 'filterBusiness', 'filterStatus']);
    }

    public function openNote($id)
    {
        $this->noteStallId = $id;
        $this->noteDate = now()->toDateString();
        $this->noteComment = '';
        $this->resetValidation();
    }

    public function saveNote()
    {
        $this->validate(['noteDate' => 'required|date|before_or_equal:today', 'noteComment' => 'required|string|max:2000'], [], ['noteDate' => 'fecha', 'noteComment' => 'comentario']);

        MarketCollectionNote::create([
            'market_stall_id' => $this->noteStallId,
            'user_id' => Auth::id(),
            'date' => $this->noteDate,
            'comment' => $this->noteComment,
        ]);

        $this->noteStallId = null;
    }

    public function render()
    {
        // El estatus de pago se calcula con las boletas de cada espacio, por eso se filtra en PHP
        $all = MarketStall::with(['rate', 'activeTickets:id,market_stall_id,period,cancelled_at', 'collectionNotes'])
            ->orderBy('number')->get();

        $withDebt = $all->filter(fn ($s) => $s->months_owed > 0);

        $kpis = [
            'con_adeudo' => ['Adeudo total', '$'.number_format($withDebt->sum('debt'), 2), 'dark', $withDebt->count().' locatarios con adeudo'],
            'por_vencer' => ['Por vencer', $all->where('payment_status', 'por_vencer')->count(), 'warning', 'Mes actual sin pagar'],
            'vencido' => ['Vencidos', $all->where('payment_status', 'vencido')->count(), 'orange', '1 mes atrasado'],
            'moroso' => ['Morosos', $all->where('payment_status', 'moroso')->count(), 'danger', '2 meses o más'],
        ];

        $stalls = $all
            ->when($this->search, fn ($c) => $c->filter(fn ($s) => str_contains(mb_strtolower($s->tenant_name.' '.$s->number.' '.$s->space_number), mb_strtolower($this->search))))
            ->when($this->filterType, fn ($c) => $c->where('space_type', $this->filterType))
            ->when($this->filterLocation, fn ($c) => $c->where('location', $this->filterLocation))
            ->when($this->filterBusiness, fn ($c) => $c->where('business', $this->filterBusiness))
            ->when($this->filterStatus === 'con_adeudo', fn ($c) => $c->filter(fn ($s) => $s->months_owed > 0)->sortByDesc('months_owed'))
            ->when($this->filterStatus && $this->filterStatus !== 'con_adeudo', fn ($c) => $c->where('payment_status', $this->filterStatus));

        return view('livewire.market.stalls.table', [
            'stalls' => $stalls,
            'kpis' => $kpis,
            'businesses' => $all->pluck('business')->unique()->sort()->values(),
            'debtView' => in_array($this->filterStatus, ['con_adeudo', 'por_vencer', 'vencido', 'moroso']),
            'noteStall' => $this->noteStallId ? $all->firstWhere('id', $this->noteStallId) : null,
            'noticeStall' => $this->noticeStallId ? $all->firstWhere('id', $this->noticeStallId) : null,
        ]);
    }
}
