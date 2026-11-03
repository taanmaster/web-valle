<?php

namespace App\Livewire\ProteccionCivil\Cases;

use App\Models\CivilProtectionCase;
use App\Models\CivilProtectionCaseDocument;
use App\Models\CivilProtectionInspection;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public CivilProtectionCase $case;

    /** Nuevas versiones subidas por el consultor, indexadas por id de documento */
    public $uploads = [];

    // Rechazo de documento
    public $rejectingId = null;

    public $rejectionReason = '';

    // Cambio de estatus
    public $showStatusModal = false;

    public $newStatus = '';

    public $statusNote = '';

    // Entero (se genera desde su sección cuando la inspección resulta sin observaciones)
    public $paymentConcept = '';

    public $paymentAmount = '';

    public $paymentNote = 'Tu entero está listo. Acude a pagar a las oficinas de Protección Civil para continuar.';

    public $showPaymentOrder = false;

    // Confirmar pago
    public $paymentDate = '';

    public $paymentReceipt;

    // Documento emitido
    public $issueDate = '';

    public $signedDocument;

    // Agendar inspección
    public $showInspectionModal = false;

    public $inspectionDate = '';

    public $inspectionTime = '10:00';

    public $inspectorId = '';

    public $inspectionNote = '';

    // Resultado de inspección (inspector)
    public $visitDate = '';

    public $result = '';

    public $observations = '';

    public $photos = [];

    public $act;

    /**
     * Estatus que se asignan desde su propia sección del detalle, no desde el modal
     */
    public const SECTION_STATUSES = ['borrador', 'entero_generado', 'pago_confirmado', 'emitido'];

    public function mount(CivilProtectionCase $case)
    {
        abort_unless($this->canManage() || $this->isAssignedInspector($case), 403);
        abort_if($case->status === 'borrador', 404);

        $case->syncNewRequirements();
        $this->case = $case;
        $this->visitDate = now()->toDateString();
        $this->paymentDate = now()->toDateString();
        $this->issueDate = now()->toDateString();
        $this->paymentConcept = 'Derechos por '.mb_strtolower($case->procedure->name);
    }

    public function canManage(): bool
    {
        return Auth::user()->hasAnyRole(['proteccion_civil', 'all']);
    }

    private function isAssignedInspector(CivilProtectionCase $case): bool
    {
        return $case->inspections()->where('inspector_id', Auth::id())->exists();
    }

    private function document($id): CivilProtectionCaseDocument
    {
        abort_unless($this->canManage() && ! $this->isClosed(), 403);

        return $this->case->documents()->findOrFail($id);
    }

    /* ---------- Documentos ---------- */

    public function accept($id)
    {
        $this->document($id)->update(['status' => 'aceptado', 'rejection_reason' => null]);
    }

    public function startReject($id)
    {
        $this->document($id);
        $this->rejectingId = $id;
        $this->rejectionReason = '';
        $this->resetValidation();
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|string|max:500'], [], ['rejectionReason' => 'motivo del rechazo']);

        $document = $this->document($this->rejectingId);
        $document->update(['status' => 'rechazado', 'rejection_reason' => $this->rejectionReason]);

        $this->case->log(
            $this->case->status,
            'Documento rechazado: '.$document->name.'. Motivo: '.$this->rejectionReason,
            Auth::id(),
            'Tu documento «'.$document->name.'» del expediente '.$this->case->folio.' fue rechazado. Motivo: '.$this->rejectionReason
        );

        $this->reset(['rejectingId', 'rejectionReason']);
    }

    public function updatedUploads($file, $documentId)
    {
        $document = $this->document($documentId);

        $this->validate(
            ['uploads.'.$documentId => 'file|max:20480|mimes:'.$document->accept_mimes],
            [],
            ['uploads.'.$documentId => $document->name]
        );

        $document->addVersion($file, Auth::id());
        unset($this->uploads[$documentId]);
        $this->case->refresh();
    }

    public function toggleOriginal($id)
    {
        $document = $this->document($id);
        $document->update(['original_received' => ! $document->original_received]);
    }

    /* ---------- Estatus ---------- */

    /**
     * Un expediente emitido, que no procede o cancelado ya no cambia de estatus
     */
    public function isClosed(): bool
    {
        return in_array($this->case->status, CivilProtectionCase::FINAL_STATUSES);
    }

    public function openStatusModal()
    {
        abort_unless($this->canManage() && ! $this->isClosed(), 403);
        $this->reset(['newStatus', 'statusNote']);
        $this->resetValidation();
        $this->showStatusModal = true;
    }

    public function changeStatus()
    {
        abort_unless($this->canManage() && ! $this->isClosed(), 403);

        $allowed = array_diff(array_keys(CivilProtectionCase::STATUSES), self::SECTION_STATUSES);

        $this->validate([
            'newStatus' => 'required|in:'.implode(',', $allowed),
            'statusNote' => 'nullable|string|max:2000',
        ], [], ['newStatus' => 'nuevo estatus', 'statusNote' => 'mensaje al ciudadano']);

        $this->case->load('documents');

        if (in_array($this->newStatus, CivilProtectionCase::REQUIRES_APPROVED_DOCUMENTS) && ! $this->case->requiredDocumentsApproved()) {
            $this->addError('newStatus', 'No puede pasar a la siguiente etapa hasta tener los documentos obligatorios aprobados.');

            return;
        }

        if ($this->newStatus === 'inspeccion_programada' && ! $this->case->originalsReceived()) {
            $this->addError('newStatus', 'Marca como recibidos los documentos que requieren original antes de programar la inspección.');

            return;
        }

        $this->case->update(['status' => $this->newStatus]);

        // Las inspecciones pendientes de un expediente cerrado quedan como "No realizada"
        if (in_array($this->newStatus, ['no_procede', 'cancelado'])) {
            $this->case->inspections()->where('result', 'pendiente')->update(['result' => 'no_realizada']);
        }

        $this->case->log(
            $this->newStatus,
            $this->statusNote ?: null,
            Auth::id(),
            $this->statusNote ?: 'Tu expediente '.$this->case->folio.' cambió al estatus «'.$this->case->status_label.'».'
        );

        $this->showStatusModal = false;
    }

    /* ---------- Entero, pago y documento emitido ---------- */

    /**
     * El entero se habilita cuando el inspector registró la inspección sin observaciones
     */
    public function canGeneratePaymentOrder(): bool
    {
        return $this->canManage() && ! $this->isClosed() && ! $this->case->payment_order_folio
            && $this->case->latestInspection?->result === 'sin_observaciones';
    }

    public function generatePaymentOrder()
    {
        abort_unless($this->canGeneratePaymentOrder(), 403);

        $this->validate([
            'paymentAmount' => 'required|numeric|min:0.01',
            'paymentConcept' => 'required|string|max:255',
            'paymentNote' => 'required|string|max:1000',
        ], [], ['paymentAmount' => 'monto', 'paymentConcept' => 'concepto', 'paymentNote' => 'nota al ciudadano']);

        $this->case->update([
            'status' => 'entero_generado',
            'payment_order_folio' => $this->case->payment_order_folio_preview,
            'payment_order_concept' => $this->paymentConcept,
            'payment_order_amount' => $this->paymentAmount,
            'payment_order_note' => $this->paymentNote,
            'payment_order_generated_at' => now(),
            'payment_order_generated_by' => Auth::id(),
        ]);

        $this->case->log(
            'entero_generado',
            'Entero '.$this->case->payment_order_folio.' por $'.number_format($this->paymentAmount, 2).'.',
            Auth::id(),
            $this->paymentNote.' Entero '.$this->case->payment_order_folio.' por $'.number_format($this->paymentAmount, 2).'.'
        );

        $this->showPaymentOrder = true;
    }

    public function confirmPayment()
    {
        abort_unless($this->canManage() && $this->case->status === 'entero_generado', 403);

        $this->validate([
            'paymentDate' => 'required|date|before_or_equal:today',
            'paymentReceipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], ['paymentReceipt.required' => 'Adjunta el recibo de pago.'], ['paymentDate' => 'fecha de pago']);

        $this->case->update([
            'status' => 'pago_confirmado',
            'payment_date' => $this->paymentDate,
            'payment_receipt_name' => $this->paymentReceipt->getClientOriginalName(),
            'payment_receipt_s3_url' => $this->storeFile($this->paymentReceipt, 'pagos'),
            'payment_confirmed_at' => now(),
        ]);

        $this->case->log('pago_confirmado', null, Auth::id(),
            'Confirmamos el pago del entero '.$this->case->payment_order_folio.' de tu expediente '.$this->case->folio.'.');

        $this->reset('paymentReceipt');
    }

    public function issueDocument()
    {
        abort_unless($this->canManage() && $this->case->status === 'pago_confirmado', 403);

        $this->validate([
            'issueDate' => 'required|date|before_or_equal:today',
            'signedDocument' => 'required|file|mimes:pdf|max:20480',
        ], ['signedDocument.required' => 'Sube el PDF firmado.'], ['issueDate' => 'fecha de emisión']);

        $consecutive = $this->case->nextDocumentConsecutive();
        $issued = \Carbon\Carbon::parse($this->issueDate);

        $this->case->update([
            'status' => 'emitido',
            'document_consecutive' => $consecutive,
            'document_number' => $this->case->documentNumberFor($consecutive, $issued),
            'document_name' => $this->signedDocument->getClientOriginalName(),
            'document_s3_url' => $this->storeFile($this->signedDocument, 'emitidos'),
            'issued_at' => $issued,
            'expires_at' => $issued->copy()->addDays($this->case->procedure->validity_days)->toDateString(),
        ]);

        $this->case->log('emitido', 'Documento '.$this->case->document_number.' emitido.', Auth::id(),
            'Tu '.mb_strtolower($this->case->procedure->type_label).' '.$this->case->document_number
                .' fue emitida. Vigente hasta el '.$this->case->expires_at->format('d/m/Y').'.');

        $this->reset('signedDocument');
    }

    private function storeFile($file, string $folder): string
    {
        $path = 'proteccion_civil/expedientes/'.$this->case->id.'/'.$folder.'/'
            .Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($path, file_get_contents($file->getRealPath()));

        return Storage::disk('s3')->url($path);
    }

    /* ---------- Inspección ---------- */

    public function canScheduleInspection(): bool
    {
        $latest = $this->case->latestInspection;

        return $this->canManage() && $this->case->status === 'inspeccion_programada'
            && (! $latest || $latest->result !== 'pendiente');
    }

    public function openInspectionModal()
    {
        abort_unless($this->canScheduleInspection(), 403);
        $this->reset(['inspectionDate', 'inspectorId', 'inspectionNote']);
        $this->inspectionTime = '10:00';
        $this->showInspectionModal = true;
    }

    public function scheduleInspection()
    {
        abort_unless($this->canScheduleInspection(), 403);

        $this->validate([
            'inspectionDate' => 'required|date|after_or_equal:today',
            'inspectionTime' => 'required|date_format:H:i',
            'inspectorId' => 'required|exists:users,id',
            'inspectionNote' => 'nullable|string|max:1000',
        ], [], ['inspectionDate' => 'fecha', 'inspectionTime' => 'hora', 'inspectorId' => 'inspector']);

        $inspection = $this->case->inspections()->create([
            'inspector_id' => $this->inspectorId,
            'scheduled_by' => Auth::id(),
            'scheduled_at' => $this->inspectionDate.' '.$this->inspectionTime,
            'note_to_citizen' => $this->inspectionNote ?: null,
        ]);

        $when = $inspection->scheduled_at->format('d/m/Y \a \l\a\s H:i');
        $this->case->log(
            'inspeccion_programada',
            'Inspección agendada para el '.$when.' con '.$inspection->inspector->name.'.',
            Auth::id(),
            'La inspección de tu expediente '.$this->case->folio.' quedó agendada para el '.$when.'.'
                .($this->inspectionNote ? ' '.$this->inspectionNote : '')
        );

        $this->showInspectionModal = false;
    }

    public function saveInspectionResult()
    {
        $inspection = $this->case->latestInspection;
        abort_unless($inspection && $inspection->result === 'pendiente'
            && ($inspection->inspector_id === Auth::id() || $this->canManage()), 403);

        $this->validate([
            'visitDate' => 'required|date|before_or_equal:today',
            'result' => 'required|in:sin_observaciones,con_observaciones,no_procede',
            'observations' => 'required_unless:result,sin_observaciones|nullable|string|max:5000',
            'photos.*' => 'image|max:10240',
            'act' => 'nullable|file|mimes:pdf|max:20480',
        ], [], ['visitDate' => 'fecha de la visita', 'result' => 'resultado', 'observations' => 'observaciones', 'act' => 'acta']);

        $folder = 'proteccion_civil/inspecciones/'.$inspection->id.'/';
        $photos = collect($this->photos)->map(function ($photo) use ($folder) {
            $path = $folder.Str::random(12).'.'.$photo->getClientOriginalExtension();
            Storage::disk('s3')->put($path, file_get_contents($photo->getRealPath()));

            return ['name' => $photo->getClientOriginalName(), 'url' => Storage::disk('s3')->url($path)];
        })->all();

        $data = [
            'visit_date' => $this->visitDate,
            'result' => $this->result,
            'observations' => $this->observations ?: null,
            'photos' => $photos,
            'registered_at' => now(),
        ];

        if ($this->act) {
            $path = $folder.'acta_'.Str::random(8).'.pdf';
            Storage::disk('s3')->put($path, file_get_contents($this->act->getRealPath()));
            $data['act_name'] = $this->act->getClientOriginalName();
            $data['act_s3_url'] = Storage::disk('s3')->url($path);
        }

        $inspection->update($data);

        $this->case->log($this->case->status, 'Resultado de inspección registrado: '.$inspection->result_label.'.', Auth::id());

        $this->reset(['result', 'observations', 'photos', 'act']);
    }

    public function render()
    {
        $this->case->load(['procedure', 'creator', 'paymentOrderAuthor', 'documents.versions.uploader', 'logs.user', 'latestInspection.inspector']);

        $documents = $this->case->documents;
        $delivered = $documents->where('status', '!=', 'sin_entregar');

        return view('livewire.proteccion-civil.cases.show', [
            'documents' => $documents,
            'summary' => $delivered->where('status', 'aceptado')->count().' de '.$delivered->count()
                .' entregados aceptados · '.$documents->count().' requisitos',
            'inspection' => $this->case->latestInspection,
            'canManage' => $this->canManage(),
            'isClosed' => $this->isClosed(),
            'canGeneratePaymentOrder' => $this->canGeneratePaymentOrder(),
            'nextDocumentNumber' => $this->case->status === 'pago_confirmado'
                ? $this->case->documentNumberFor($this->case->nextDocumentConsecutive(), $this->issueDate ?: null)
                : null,
            'issueExpires' => $this->issueDate
                ? \Carbon\Carbon::parse($this->issueDate)->addDays($this->case->procedure->validity_days)
                : null,
            'responsible' => $this->case->logs->whereNotNull('user_id')->first()?->user?->name ?? $this->case->creator?->name,
            'canSchedule' => $this->canScheduleInspection(),
            'inspectors' => $this->showInspectionModal
                ? User::role('inspector_proteccion_civil')->orderBy('name')->get(['id', 'name'])
                : collect(),
        ]);
    }
}
