<?php

namespace App\Livewire\Market\Tickets;

use App\Models\MarketStall;
use App\Models\MarketTicket;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Cobrar: en una sola pantalla se elige al locatario, los meses y se imprimen las boletas.
 * El locatario paga en efectivo en ventanilla al emitirse la boleta.
 */
class Collect extends Component
{
    #[Url(as: 'stall')]
    public $stallId = null;

    public $search = '';

    /** Meses seleccionados, formato YYYY-MM */
    public $periods = [];

    /** Boletas recién emitidas (para imprimir) */
    public $issuedIds = [];

    // Entrega de recibos pendientes al locatario que viene a pagar
    public $deliverTo = '';

    public $deliverIds = [];

    public function mount()
    {
        if ($this->stallId) {
            $this->selectStall($this->stallId);
        }
    }

    public function selectStall($id)
    {
        $stall = MarketStall::with(['rate', 'activeTickets'])->where('status', 'activo')->findOrFail($id);
        $this->stallId = $stall->id;
        // Por omisión se marca el mes más antiguo pendiente: siempre se cobra del más antiguo al más reciente
        $this->periods = collect($stall->unpaid_periods)->take(1)->map->format('Y-m')->all();
        $this->deliverTo = $stall->tenant_name;
        $this->deliverIds = $this->pendingReceipts($stall)->pluck('id')->map(fn ($id) => (string) $id)->all();
        $this->issuedIds = [];
        $this->search = '';
    }

    public function changeStall()
    {
        $this->reset(['stallId', 'periods', 'issuedIds', 'deliverIds']);
    }

    public function selectAll()
    {
        $this->periods = collect($this->stall()->unpaid_periods)->map->format('Y-m')->all();
    }

    private function stall(): ?MarketStall
    {
        return $this->stallId ? MarketStall::with(['rate', 'activeTickets'])->find($this->stallId) : null;
    }

    private function pendingReceipts(MarketStall $stall)
    {
        // Recibos de Tesorería listos de todos los espacios de la persona (mismo teléfono)
        $ids = MarketStall::where('phone', $stall->phone)->pluck('id');

        return MarketTicket::with('stall')->whereIn('market_stall_id', $ids)->stage('recibo_listo')->orderBy('period')->get();
    }

    public function collect()
    {
        $stall = $this->stall();
        $unpaid = collect($stall->unpaid_periods)->map->format('Y-m');

        $this->validate(['periods' => 'required|array|min:1'], ['periods.required' => 'Selecciona al menos un mes.']);
        abort_if(collect($this->periods)->diff($unpaid)->isNotEmpty(), 422);

        // No se permite saltarse meses: deben ser los más antiguos
        $expected = $unpaid->take(count($this->periods))->all();
        if (collect($this->periods)->sort()->values()->all() !== $expected) {
            $this->addError('periods', 'Cobra primero los meses más antiguos.');

            return;
        }

        $rate = $stall->rate;

        $this->issuedIds = DB::transaction(function () use ($stall, $rate) {
            $ids = [];
            foreach (collect($this->periods)->sort() as $period) {
                [$series, $folio] = MarketTicket::nextFolio();
                $ids[] = MarketTicket::create([
                    'series' => $series,
                    'folio' => $folio,
                    'market_stall_id' => $stall->id,
                    'period' => $period.'-01',
                    'amount' => $rate->monthly_amount,
                    'fiscal_year' => $rate->fiscal_year,
                    'article' => $rate->article,
                    'subsection' => $rate->subsection,
                    'fraction' => $rate->fraction,
                    'issued_by' => Auth::id(),
                ])->id;
            }

            return $ids;
        });

        $this->periods = [];
    }

    public function deliver()
    {
        $this->validate([
            'deliverIds' => 'required|array|min:1',
            'deliverTo' => 'required|string|max:255',
        ], ['deliverIds.required' => 'Selecciona los recibos que se entregan.'], ['deliverTo' => 'recibió']);

        MarketTicket::whereIn('id', $this->deliverIds)->stage('recibo_listo')->update([
            'delivered_at' => now()->toDateString(),
            'delivered_to' => $this->deliverTo,
            'delivered_by' => Auth::id(),
        ]);

        $this->deliverIds = [];
    }

    public function render()
    {
        $stall = $this->stall();

        $results = ! $stall
            ? MarketStall::with(['rate', 'activeTickets'])->where('status', 'activo')
                ->when($this->search, fn ($q) => $q->where(fn ($q) => $q
                    ->where('tenant_name', 'like', "%{$this->search}%")
                    ->orWhere('number', 'like', "%{$this->search}%")
                    ->orWhere('space_number', 'like', "%{$this->search}%")))
                ->get()->sortByDesc('months_owed')->take(15)
            : collect();

        $selectedTotal = $stall ? count($this->periods) * (float) $stall->rate->monthly_amount : 0;

        return view('livewire.market.tickets.collect', [
            'stall' => $stall,
            'results' => $results,
            'selectedTotal' => $selectedTotal,
            'pendingReceipts' => $stall ? $this->pendingReceipts($stall) : collect(),
            'issued' => MarketTicket::with('stall.rate', 'issuer')->whereIn('id', $this->issuedIds)->orderBy('folio')->get(),
        ]);
    }
}
