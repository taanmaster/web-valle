<?php

namespace App\Livewire\Citizen\CivilProtection;

use App\Models\CivilProtectionCase;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Detalle del expediente de Protección Civil desde el perfil del ciudadano
 */
class CaseDetail extends Component
{
    use WithFileUploads;

    public CivilProtectionCase $case;

    /** Correcciones de documentos rechazados, por id de documento */
    public $uploads = [];

    public $showPaymentOrder = false;

    /**
     * Estatus en los que el ciudadano todavía puede cancelar
     */
    public const CANCELLABLE = ['en_revision', 'requiere_correccion', 'entrega_fisica'];

    public function mount(CivilProtectionCase $case)
    {
        abort_unless($case->user_id === Auth::id() && $case->status !== 'borrador', 404);
        $this->case = $case;
    }

    public function updatedUploads($file, $documentId)
    {
        $document = $this->case->documents()->findOrFail($documentId);
        abort_unless(in_array($document->status, ['rechazado', 'sin_entregar'])
            && ! in_array($this->case->status, CivilProtectionCase::FINAL_STATUSES), 403);

        $this->validate(
            ['uploads.'.$documentId => 'file|max:20480|mimes:'.$document->accept_mimes],
            [],
            ['uploads.'.$documentId => $document->name]
        );

        $document->addVersion($file, Auth::id(), true);
        unset($this->uploads[$documentId]);
        $this->case->refresh();
    }

    public function cancel()
    {
        abort_unless(in_array($this->case->status, self::CANCELLABLE), 403);

        $this->case->update(['status' => 'cancelado']);
        $this->case->log('cancelado', 'Trámite cancelado por el ciudadano.', Auth::id());
    }

    /**
     * Mensaje principal según el estatus
     */
    private function headline(): string
    {
        return match ($this->case->status) {
            'en_revision' => 'Recibimos tu solicitud con folio '.$this->case->folio.'. Protección Civil revisará tus documentos.',
            'requiere_correccion' => 'Algunos documentos necesitan corrección. Revisa el motivo y sube una nueva versión.',
            'entrega_fisica' => 'Tus documentos fueron aprobados. Entrega los originales en las oficinas de Protección Civil.',
            'inspeccion_programada' => 'Tu inspección está programada. Un inspector visitará el lugar.',
            'inspeccion_observaciones' => 'La inspección tuvo observaciones. Protección Civil se pondrá en contacto contigo.',
            'entero_generado' => 'Tu entero está listo. Acude a pagar a las oficinas de Protección Civil para continuar.',
            'pago_confirmado' => 'Confirmamos tu pago. Estamos preparando tu documento.',
            'emitido' => 'Tu '.mb_strtolower($this->case->procedure->type_label).' fue emitida.',
            'no_procede' => 'Tu solicitud no procede. Revisa los mensajes de Protección Civil.',
            'cancelado' => 'Este trámite fue cancelado.',
            default => '',
        };
    }

    public function render()
    {
        $this->case->load(['procedure', 'documents.latestVersion', 'logs', 'paymentOrderAuthor']);

        return view('livewire.citizen.civil-protection.case-detail', [
            'headline' => $this->headline(),
            'canCancel' => in_array($this->case->status, self::CANCELLABLE),
        ]);
    }
}
