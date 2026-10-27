<?php

namespace App\Livewire\Market\Tickets;

use App\Models\MarketTicket;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public MarketTicket $ticket;

    public $receipt;

    public $showPrint = false;

    // Cancelación
    public $confirmingCancel = false;

    public $cancelReason = '';

    // Entrega del recibo
    public $showDelivery = false;

    public $deliveredAt;

    public $deliveredTo = '';

    public $deliveryProof;

    public $deliveryNotes = '';

    public function mount(MarketTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    public static function storeFile($file, string $folder): string
    {
        $path = 'mercado/'.$folder.'/'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($path, file_get_contents($file->getRealPath()));

        return Storage::disk('s3')->url($path);
    }

    /**
     * El recibo de Tesorería se adjunta normalmente desde el corte; aquí para casos sueltos o para reemplazarlo
     */
    public function updatedReceipt()
    {
        abort_unless($this->ticket->market_cut_id && ! $this->ticket->cancelled_at, 403);
        $this->validate(['receipt' => 'file|mimes:pdf,jpg,jpeg,png|max:10240'], [], ['receipt' => 'recibo']);

        $this->ticket->update([
            'receipt_name' => $this->receipt->getClientOriginalName(),
            'receipt_s3_url' => self::storeFile($this->receipt, 'recibos'),
            'receipt_attached_at' => now(),
            'receipt_attached_by' => Auth::id(),
        ]);
        $this->reset('receipt');
    }

    public function cancel()
    {
        abort_unless($this->ticket->can_cancel, 403);
        $this->validate(['cancelReason' => 'required|string|max:255'], [], ['cancelReason' => 'motivo de la cancelación']);

        $this->ticket->update(['cancelled_at' => now(), 'cancelled_by' => Auth::id(), 'cancel_reason' => $this->cancelReason]);
        $this->confirmingCancel = false;
    }

    public function openDelivery()
    {
        $this->deliveredAt = now()->toDateString();
        $this->deliveredTo = $this->ticket->stall->tenant_name;
        $this->reset(['deliveryProof', 'deliveryNotes']);
        $this->showDelivery = true;
    }

    public function deliver()
    {
        abort_unless($this->ticket->stage === 'recibo_listo', 403);

        $this->validate([
            'deliveredAt' => 'required|date|before_or_equal:today',
            'deliveredTo' => 'required|string|max:255',
            'deliveryProof' => 'nullable|image|max:10240',
            'deliveryNotes' => 'nullable|string|max:1000',
        ], [], ['deliveredAt' => 'fecha de entrega', 'deliveredTo' => 'recibió', 'deliveryProof' => 'acuse']);

        $this->ticket->update([
            'delivered_at' => $this->deliveredAt,
            'delivered_to' => $this->deliveredTo,
            'delivery_proof_s3_url' => $this->deliveryProof ? self::storeFile($this->deliveryProof, 'acuses') : null,
            'delivery_notes' => $this->deliveryNotes ?: null,
            'delivered_by' => Auth::id(),
        ]);
        $this->showDelivery = false;
    }

    public function render()
    {
        $this->ticket->load(['stall.rate', 'cut.creator', 'issuer', 'canceller', 'deliverer']);

        return view('livewire.market.tickets.show');
    }
}
