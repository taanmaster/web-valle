<?php

namespace App\Livewire\Market\Stalls;

use App\Models\MarketCollectionNote;
use App\Models\MarketStall;
use Auth;
use Livewire\Component;
use Session;

class Show extends Component
{
    public MarketStall $stall;

    public $year;

    public $showStatement = false;

    public $showNotice = false;

    public $confirmingDeactivate = false;

    // Gestión de cobro (mismo modal que el listado)
    public $noteStallId = null;

    public $noteDate;

    public $noteComment = '';

    public function mount(MarketStall $stall)
    {
        $this->stall = $stall;
        $this->year = now()->year;
    }

    public function openNote()
    {
        $this->noteStallId = $this->stall->id;
        $this->noteDate = now()->toDateString();
        $this->noteComment = '';
        $this->resetValidation();
    }

    public function saveNote()
    {
        $this->validate(['noteDate' => 'required|date|before_or_equal:today', 'noteComment' => 'required|string|max:2000'], [], ['noteDate' => 'fecha', 'noteComment' => 'comentario']);

        MarketCollectionNote::create([
            'market_stall_id' => $this->stall->id,
            'user_id' => Auth::id(),
            'date' => $this->noteDate,
            'comment' => $this->noteComment,
        ]);

        $this->noteStallId = null;
    }

    public function deactivate()
    {
        abort_unless($this->stall->status === 'activo', 403);

        $this->stall->update(['status' => 'baja', 'deactivated_at' => now(), 'deactivated_by' => Auth::id()]);
        $this->confirmingDeactivate = false;

        Session::flash('success', 'El espacio quedó dado de baja. Su historial se conserva.');
    }

    /**
     * Estado de cuenta del año: un renglón por mes con su boleta (si existe)
     */
    private function months(): array
    {
        $tickets = $this->stall->activeTickets->keyBy(fn ($t) => $t->period->format('Y-m'));
        $unpaid = collect($this->stall->unpaid_periods)->map->format('Y-m')->flip();
        $start = $this->stall->billing_start->copy()->startOfMonth();
        $months = [];

        for ($m = 1; $m <= 12; $m++) {
            $date = now()->setDate($this->year, $m, 1)->startOfDay();
            $key = $date->format('Y-m');
            $ticket = $tickets[$key] ?? null;

            $state = match (true) {
                (bool) $ticket => 'pagado',
                $date->lt($start) => 'no_aplica',
                $unpaid->has($key) && $date->isSameMonth(now()) => 'por_vencer',
                $unpaid->has($key) => 'adeudo',
                default => 'por_generar',
            };

            $months[] = ['date' => $date, 'ticket' => $ticket, 'state' => $state];
        }

        return $months;
    }

    public function render()
    {
        $this->stall->load(['rate', 'activeTickets', 'collectionNotes.user']);

        $years = range(max($this->stall->billing_start->year, now()->year - 4), now()->year);

        return view('livewire.market.stalls.show', [
            'months' => $this->months(),
            'years' => $years,
            'siblings' => $this->stall->siblings()->load(['rate', 'activeTickets']),
        ]);
    }
}
