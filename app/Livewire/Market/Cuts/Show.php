<?php

namespace App\Livewire\Market\Cuts;

use App\Livewire\Market\Tickets\Show as TicketShow;
use App\Models\MarketCut;
use Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Detalle del corte. Aquí se adjuntan en bloque los recibos que devuelve Tesorería:
 * si el nombre del archivo trae el folio (p. ej. "recibo A-01311.pdf") se asigna solo.
 */
class Show extends Component
{
    use WithFileUploads;

    public MarketCut $cut;

    #[Url(as: 'imprimir')]
    public $showPrint = false;

    /** Archivos subidos en bloque */
    public $bulk = [];

    /** Archivos que no se pudieron emparejar: índice => id de boleta elegido a mano */
    public $assign = [];

    /** Recibo individual por boleta */
    public $single = [];

    public function mount(MarketCut $cut)
    {
        $this->cut = $cut;
        $this->showPrint = (bool) $this->showPrint;
    }

    private function attach($ticket, $file): void
    {
        $ticket->update([
            'receipt_name' => $file->getClientOriginalName(),
            'receipt_s3_url' => TicketShow::storeFile($file, 'recibos'),
            'receipt_attached_at' => now(),
            'receipt_attached_by' => Auth::id(),
        ]);
    }

    /**
     * Empareja cada archivo con la boleta cuyo folio aparece en el nombre; los que no, quedan para asignar a mano
     */
    public function updatedBulk()
    {
        $this->validate(['bulk.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240'], [], ['bulk.*' => 'recibo']);

        $tickets = $this->cut->tickets()->whereNull('cancelled_at')->get();
        $unmatched = [];

        foreach ($this->bulk as $file) {
            $name = strtoupper($file->getClientOriginalName());
            $ticket = $tickets->first(fn ($t) => preg_match('/'.$t->series.'[\s_-]?0*'.$t->folio.'(?!\d)/', $name));

            $ticket ? $this->attach($ticket, $file) : $unmatched[] = $file;
        }

        $this->bulk = $unmatched;
        $this->assign = [];
    }

    public function assignUnmatched()
    {
        foreach ($this->assign as $index => $ticketId) {
            if ($ticketId && isset($this->bulk[$index])) {
                $this->attach($this->cut->tickets()->findOrFail($ticketId), $this->bulk[$index]);
                unset($this->bulk[$index]);
            }
        }

        $this->bulk = array_values($this->bulk);
        $this->assign = [];
    }

    public function discardUnmatched()
    {
        $this->reset(['bulk', 'assign']);
    }

    public function updatedSingle($file, $ticketId)
    {
        $this->validate(['single.'.$ticketId => 'file|mimes:pdf,jpg,jpeg,png|max:10240'], [], ['single.'.$ticketId => 'recibo']);
        $this->attach($this->cut->tickets()->findOrFail($ticketId), $file);
        unset($this->single[$ticketId]);
    }

    public function render()
    {
        $this->cut->load(['tickets.stall', 'creator']);
        $active = $this->cut->tickets->whereNull('cancelled_at');

        return view('livewire.market.cuts.show', [
            'tickets' => $this->cut->tickets,
            'missing' => $active->whereNull('receipt_s3_url'),
        ]);
    }
}
