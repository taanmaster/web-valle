<?php

namespace App\Livewire\Market\Cuts;

use App\Models\MarketCut;
use App\Models\MarketTicket;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Corte del día: junta las boletas cobradas que no están en ningún corte, concilia el efectivo
 * y queda entregado a Tesorería en un solo paso.
 */
class Create extends Component
{
    public $cutDate;

    public $cashCounted = '';

    public $receivedBy = '';

    public $notes = '';

    public function mount()
    {
        $this->cutDate = now()->toDateString();
        $this->receivedBy = MarketCut::latest('id')->value('treasury_received_by') ?? '';
    }

    private function pending()
    {
        return MarketTicket::with('stall')->stage('por_cortar')
            ->whereDate('created_at', '<=', $this->cutDate)
            ->orderBy('series')->orderBy('folio')->get();
    }

    public function close()
    {
        $tickets = $this->pending();

        $this->validate([
            'cutDate' => 'required|date|before_or_equal:today',
            'cashCounted' => 'required|numeric|min:0',
            'receivedBy' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ], [], ['cutDate' => 'fecha del corte', 'cashCounted' => 'efectivo contado', 'receivedBy' => 'recibió en Tesorería']);

        if ($tickets->isEmpty()) {
            $this->addError('cutDate', 'No hay boletas cobradas pendientes de corte.');

            return;
        }

        $total = $tickets->sum('amount');
        $difference = round($this->cashCounted - $total, 2);

        if ($difference != 0 && ! trim($this->notes)) {
            $this->addError('notes', 'Hay una diferencia de $'.number_format($difference, 2).'. Explícala en observaciones.');

            return;
        }

        $cut = DB::transaction(function () use ($tickets, $total) {
            $cut = MarketCut::create([
                'cut_date' => $this->cutDate,
                'created_by' => Auth::id(),
                'tickets_count' => $tickets->count(),
                'system_total' => $total,
                'cash_counted' => $this->cashCounted,
                'treasury_received_by' => $this->receivedBy,
                'notes' => $this->notes ?: null,
            ]);

            MarketTicket::whereIn('id', $tickets->pluck('id'))->update(['market_cut_id' => $cut->id]);

            return $cut;
        });

        return redirect()->route('market.cuts.show', ['cut' => $cut, 'imprimir' => 1]);
    }

    public function render()
    {
        $tickets = $this->pending();
        $total = $tickets->sum('amount');

        return view('livewire.market.cuts.create', [
            'tickets' => $tickets,
            'total' => $total,
            'difference' => is_numeric($this->cashCounted) ? round($this->cashCounted - $total, 2) : null,
        ]);
    }
}
