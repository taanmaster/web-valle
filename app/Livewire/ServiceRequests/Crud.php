<?php

namespace App\Livewire\ServiceRequests;

use App\Models\RegulatoryAgendaDependency;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCost;
use App\Models\ServiceRequestRelatedProcedure;
use App\Models\ServiceRequestRequirement;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

/* Cédula del catálogo municipal de Trámites y Servicios (Mejora Regulatoria).
   En modo edición cada cambio se guarda automáticamente; en modo creación
   todo se persiste hasta dar clic en "Guardar borrador". */

class Crud extends Component
{
    use WithFileUploads;

    // Campos escalares que se guardan automáticamente al editar
    private const SCALAR_FIELDS = [
        // A. Datos generales de control administrativo
        'dependency_name', 'admin_unit', 'receiving_area', 'resolving_area',
        'issuing_authority', 'applying_authority', 'liaison_name', 'liaison_position',
        'liaison_email', 'liaison_phone', 'elaboration_date',
        // B. Identificación del trámite o servicio
        'name', 'homoclave', 'type', 'responsible_subject', 'description', 'modality',
        // C. Canal de atención y disponibilidad
        'can_start_online', 'can_finish_online', 'online_url',
        // E. Fundamento jurídico y regulación
        'legal_basis', 'regulation_name', 'regulation_media',
        'regulation_publication_date', 'regulation_articles',
        // G. Presentación y formato de la solicitud
        'format_name', 'format_media', 'format_publication_date',
        // H. Inspección o verificación
        'requires_inspection', 'inspection_objective', 'inspection_authority',
        'inspection_moment', 'inspection_legal_basis', 'inspection_criteria',
        // I. Contacto, oficinas y horarios
        'contact_area', 'contact_advisor', 'contact_phone', 'contact_email',
        'contact_media', 'reception_address', 'has_alternate_office',
        'alternate_office_url', 'schedule_days', 'schedule_reception',
        'schedule_resolution', 'non_working_days',
        // J. Plazos de resolución y prevención
        'resolution_time', 'resolution_time_unit', 'resolution_legal_basis',
        'afirmativa_ficta', 'negativa_ficta', 'ficta_legal_basis',
        'prevention_time', 'compliance_time', 'prevention_media', 'prevention_legal_basis',
        // K. Costos, derechos y formas de pago
        'applicable_amount', 'fee_legal_basis', 'variable_fee_method',
        // L. Vigencia, criterios de resolución y frecuencia
        'validity', 'validity_legal_basis', 'allows_renewal', 'resolution_criteria',
        'annual_requests', 'reported_period', 'information_source', 'frequency_observations',
        // M. Información al solicitante, sanciones y privacidad
        'applicant_records', 'sanction_conduct', 'sanction_applicable',
        'sanction_legal_basis', 'collects_personal_data', 'personal_data_types',
        'privacy_notice_name', 'privacy_notice_url',
    ];

    private const BOOLEAN_FIELDS = [
        'can_start_online', 'can_finish_online', 'requires_inspection',
        'has_alternate_office', 'afirmativa_ficta', 'negativa_ficta',
        'allows_renewal', 'collects_personal_data',
    ];

    private const ARRAY_FIELDS = ['channels', 'submission_forms', 'payment_options'];

    #[Locked]
    public $request;

    public $dependencies = [];

    // Modos: 0 crear, 1 ver, 2 editar
    #[Locked]
    public $mode = 0;

    public $status = ServiceRequest::STATUS_DRAFT;

    public $lastSavedAt = null;

    // A. Datos generales de control administrativo
    public $dependency_name = '';

    public $admin_unit = '';

    public $receiving_area = '';

    public $resolving_area = '';

    public $issuing_authority = '';

    public $applying_authority = '';

    public $liaison_name = '';

    public $liaison_position = '';

    public $liaison_email = '';

    public $liaison_phone = '';

    public $elaboration_date = '';

    // B. Identificación del trámite o servicio
    public $name = '';

    public $homoclave = '';

    public $type = '';

    public $responsible_subject = '';

    public $description = '';

    public $modality = '';

    // C. Canal de atención y disponibilidad
    public $channels = [];

    public $can_start_online = '';

    public $can_finish_online = '';

    public $online_url = '';

    // D. Requisitos (repetible)
    public $requirementRows = [];

    // E. Fundamento jurídico y regulación
    public $legal_basis = '';

    public $regulation_name = '';

    public $regulation_media = '';

    public $regulation_publication_date = '';

    public $regulation_articles = '';

    // F. Trámites o servicios relacionados (repetible)
    public $relatedRows = [];

    // G. Presentación y formato de la solicitud
    public $submission_forms = [];

    public $format_name = '';

    public $format_media = '';

    public $format_publication_date = '';

    public $format_upload = null;

    public $steps_upload = null;

    public $procedure_upload = null;

    // H. Inspección o verificación
    public $requires_inspection = '';

    public $inspection_objective = '';

    public $inspection_authority = '';

    public $inspection_moment = '';

    public $inspection_legal_basis = '';

    public $inspection_criteria = '';

    // I. Contacto, oficinas y horarios
    public $contact_area = '';

    public $contact_advisor = '';

    public $contact_phone = '';

    public $contact_email = '';

    public $contact_media = '';

    public $reception_address = '';

    public $has_alternate_office = '';

    public $alternate_office_url = '';

    public $schedule_days = '';

    public $schedule_reception = '';

    public $schedule_resolution = '';

    public $non_working_days = '';

    // J. Plazos de resolución y prevención
    public $resolution_time = '';

    public $resolution_time_unit = '';

    public $resolution_legal_basis = '';

    public $afirmativa_ficta = '';

    public $negativa_ficta = '';

    public $ficta_legal_basis = '';

    public $prevention_time = '';

    public $compliance_time = '';

    public $prevention_media = '';

    public $prevention_legal_basis = '';

    // K. Costos, derechos y formas de pago
    public $applicable_amount = '';

    public $fee_legal_basis = '';

    public $variable_fee_method = '';

    public $payment_options = [];

    public $costRows = [];

    // L. Vigencia, criterios de resolución y frecuencia
    public $validity = '';

    public $validity_legal_basis = '';

    public $allows_renewal = '';

    public $resolution_criteria = '';

    public $annual_requests = '';

    public $reported_period = '';

    public $information_source = '';

    public $frequency_observations = '';

    // M. Información al solicitante, sanciones y privacidad
    public $applicant_records = '';

    public $sanction_conduct = '';

    public $sanction_applicable = '';

    public $sanction_legal_basis = '';

    public $collects_personal_data = '';

    public $personal_data_types = '';

    public $privacy_notice_name = '';

    public $privacy_notice_url = '';

    public function mount()
    {
        $this->fetchDependencies();

        if ($this->request != null) {
            $this->loadRequestData();
        }
    }

    public function fetchDependencies()
    {
        $this->dependencies = RegulatoryAgendaDependency::orderBy('name')->get();
    }

    public function loadRequestData()
    {
        foreach (self::SCALAR_FIELDS as $field) {
            if (in_array($field, self::BOOLEAN_FIELDS)) {
                $this->$field = $this->request->$field === null ? '' : (string) (int) $this->request->$field;
            } else {
                $this->$field = (string) ($this->request->$field ?? '');
            }
        }

        foreach (self::ARRAY_FIELDS as $field) {
            $this->$field = $this->request->$field ?? [];
        }

        $this->status = $this->request->status ?? ServiceRequest::STATUS_DRAFT;

        $this->requirementRows = $this->request->requirementItems()->get()->map(fn ($item) => [
            'id' => $item->id,
            'name' => $item->name ?? '',
            'presentation' => $item->presentation ?? [],
            'third_party_issued' => $item->third_party_issued === null ? '' : (string) (int) $item->third_party_issued,
            'observations' => $item->observations ?? '',
        ])->toArray();

        $this->relatedRows = $this->request->relatedProcedures()->get()->map(fn ($item) => [
            'id' => $item->id,
            'name' => $item->name ?? '',
            'homoclave' => $item->homoclave ?? '',
            'subject_level' => $item->subject_level ?? '',
            'relation_type' => $item->relation_type ?? '',
        ])->toArray();

        $this->costRows = $this->request->costs()->get()->map(fn ($item) => [
            'id' => $item->id,
            'ammount' => $item->ammount ?? '',
            'description' => $item->description ?? '',
        ])->toArray();
    }

    /* ------------------------------------------------------------------ */
    /* Autoguardado */
    /* ------------------------------------------------------------------ */

    public function updated($property, $value)
    {
        if (! $this->isAutosavable()) {
            return;
        }

        $root = strtok($property, '.');

        if (in_array($root, ['requirementRows', 'relatedRows', 'costRows'])) {
            $this->persistRow($root, $property);

            return;
        }

        if (in_array($root, self::ARRAY_FIELDS)) {
            $this->request->update([$root => $this->$root]);
            $this->markSaved();

            return;
        }

        if (in_array($root, self::SCALAR_FIELDS)) {
            $this->request->update([$root => $this->castValue($root, $this->$root)]);
            $this->markSaved();
        }
    }

    private function isAutosavable(): bool
    {
        return $this->request != null && $this->mode != 1;
    }

    /**
     * Bloquea las acciones de escritura cuando el componente
     * se montó en modo solo lectura.
     */
    private function ensureEditable(): void
    {
        abort_if($this->mode == 1, 403);
    }

    private function castValue($field, $value)
    {
        if (in_array($field, self::BOOLEAN_FIELDS)) {
            return ($value === '' || $value === null) ? null : (bool) (int) $value;
        }

        return $value === '' ? null : $value;
    }

    private function markSaved()
    {
        $this->lastSavedAt = now()->format('H:i');
    }

    /* ------------------------------------------------------------------ */
    /* Filas repetibles (requisitos, relacionados, costos) */
    /* ------------------------------------------------------------------ */

    private function rowTemplate($collection): array
    {
        return match ($collection) {
            'requirementRows' => ['id' => null, 'name' => '', 'presentation' => [], 'third_party_issued' => '', 'observations' => ''],
            'relatedRows' => ['id' => null, 'name' => '', 'homoclave' => '', 'subject_level' => '', 'relation_type' => ''],
            'costRows' => ['id' => null, 'ammount' => '', 'description' => ''],
        };
    }

    private function rowModel($collection): string
    {
        return match ($collection) {
            'requirementRows' => ServiceRequestRequirement::class,
            'relatedRows' => ServiceRequestRelatedProcedure::class,
            'costRows' => ServiceRequestCost::class,
        };
    }

    private function rowData($collection, array $row): array
    {
        $data = collect($row)->except('id')->toArray();

        if ($collection === 'requirementRows') {
            $value = $data['third_party_issued'];
            $data['third_party_issued'] = ($value === '' || $value === null) ? null : (bool) (int) $value;
        }

        if ($collection === 'costRows') {
            $data['ammount'] = $data['ammount'] === '' ? null : $data['ammount'];
        }

        return $data;
    }

    public function addRow($collection)
    {
        $this->ensureEditable();

        if (! in_array($collection, ['requirementRows', 'relatedRows', 'costRows'])) {
            return;
        }

        $this->{$collection}[] = $this->rowTemplate($collection);

        if ($this->isAutosavable()) {
            $this->persistRowByIndex($collection, count($this->{$collection}) - 1);
        }
    }

    public function removeRow($collection, $index)
    {
        $this->ensureEditable();

        if (! in_array($collection, ['requirementRows', 'relatedRows', 'costRows'])) {
            return;
        }

        $row = $this->{$collection}[$index] ?? null;

        if ($row === null) {
            return;
        }

        if ($row['id'] !== null && $this->request != null) {
            $model = $this->rowModel($collection);
            $model::where('service_request_id', $this->request->id)->where('id', $row['id'])->delete();
            $this->markSaved();
        }

        unset($this->{$collection}[$index]);
        $this->{$collection} = array_values($this->{$collection});
    }

    private function persistRow($collection, $property)
    {
        // $property llega como "requirementRows.0.name"
        $segments = explode('.', $property);

        if (count($segments) < 2) {
            return;
        }

        $this->persistRowByIndex($collection, (int) $segments[1]);
    }

    private function persistRowByIndex($collection, $index)
    {
        if (! isset($this->$collection[$index]) || $this->request == null) {
            return;
        }

        $row = $this->$collection[$index];
        $model = $this->rowModel($collection);
        $data = $this->rowData($collection, $row);

        if ($row['id'] === null) {
            $created = $model::create(array_merge($data, ['service_request_id' => $this->request->id]));
            $this->$collection[$index]['id'] = $created->id;
        } else {
            $model::where('service_request_id', $this->request->id)
                ->where('id', $row['id'])
                ->update($data);
        }

        $this->markSaved();
    }

    private function syncRows($collection)
    {
        foreach (array_keys($this->$collection) as $index) {
            $this->persistRowByIndex($collection, $index);
        }
    }

    /* ------------------------------------------------------------------ */
    /* Archivos */
    /* ------------------------------------------------------------------ */

    private function uploadToS3($document): string
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName.'_'.uniqid().'.'.$extension;

        $filepath = 'institutional_development/requests/'.$filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    private function persistUpload($property, $column)
    {
        $this->validate([$property => 'file|max:10240']);

        if (! $this->isAutosavable()) {
            return;
        }

        $this->request->update([$column => $this->uploadToS3($this->$property)]);
        $this->reset($property);
        $this->markSaved();
    }

    public function updatedFormatUpload()
    {
        $this->persistUpload('format_upload', 'format_filename');
    }

    public function updatedStepsUpload()
    {
        $this->persistUpload('steps_upload', 'steps_filename');
    }

    public function updatedProcedureUpload()
    {
        $this->persistUpload('procedure_upload', 'procedure_filename');
    }

    public function removeFile($column)
    {
        if (! $this->isAutosavable() || ! in_array($column, ['format_filename', 'steps_filename', 'procedure_filename'])) {
            return;
        }

        $this->request->update([$column => null]);
        $this->markSaved();
    }

    /* ------------------------------------------------------------------ */
    /* Guardado y flujo editorial */
    /* ------------------------------------------------------------------ */

    private function scalarData(): array
    {
        $data = [];

        foreach (self::SCALAR_FIELDS as $field) {
            $data[$field] = $this->castValue($field, $this->$field);
        }

        foreach (self::ARRAY_FIELDS as $field) {
            $data[$field] = $this->$field;
        }

        return $data;
    }

    private function createRequest(): void
    {
        $this->validate(['name' => 'required'], [], ['name' => 'nombre oficial']);

        $data = $this->scalarData();
        $data['status'] = ServiceRequest::STATUS_DRAFT;

        if ($this->format_upload) {
            $data['format_filename'] = $this->uploadToS3($this->format_upload);
        }

        if ($this->steps_upload) {
            $data['steps_filename'] = $this->uploadToS3($this->steps_upload);
        }

        if ($this->procedure_upload) {
            $data['procedure_filename'] = $this->uploadToS3($this->procedure_upload);
        }

        $this->request = ServiceRequest::create($data);

        $this->syncRows('requirementRows');
        $this->syncRows('relatedRows');
        $this->syncRows('costRows');
    }

    public function saveDraft()
    {
        $this->ensureEditable();

        if ($this->request == null) {
            $this->createRequest();

            Session::flash('success', 'Borrador guardado correctamente. Los siguientes cambios se guardarán en automático.');

            return redirect()->route('institucional_development.requests.edit', $this->request->id);
        }

        $this->validate(['name' => 'required'], [], ['name' => 'nombre oficial']);

        $this->request->update(array_merge($this->scalarData(), ['status' => ServiceRequest::STATUS_DRAFT]));
        $this->syncRows('requirementRows');
        $this->syncRows('relatedRows');
        $this->syncRows('costRows');

        $this->status = ServiceRequest::STATUS_DRAFT;
        $this->markSaved();

        Session::flash('success', 'Borrador guardado correctamente.');
    }

    public function sendToReview()
    {
        $this->ensureEditable();

        $this->validate(['name' => 'required'], [], ['name' => 'nombre oficial']);

        if ($this->request == null) {
            $this->createRequest();
            $this->request->update(['status' => ServiceRequest::STATUS_REVIEW]);

            Session::flash('success', 'El trámite fue enviado a revisión.');

            return redirect()->route('institucional_development.requests.edit', $this->request->id);
        }

        $this->request->update(['status' => ServiceRequest::STATUS_REVIEW]);
        $this->status = ServiceRequest::STATUS_REVIEW;
        $this->markSaved();

        Session::flash('success', 'El trámite fue enviado a revisión.');
    }

    public function publish()
    {
        $this->ensureEditable();

        $this->validate([
            'name' => 'required',
            'dependency_name' => 'required',
            'type' => 'required',
            'description' => 'required',
        ], [], [
            'name' => 'nombre oficial',
            'dependency_name' => 'dependencia',
            'type' => 'tipo',
            'description' => 'descripción',
        ]);

        if ($this->request == null) {
            $this->createRequest();
        }

        $this->request->update(['status' => ServiceRequest::STATUS_PUBLISHED]);
        $this->status = ServiceRequest::STATUS_PUBLISHED;
        $this->markSaved();

        Session::flash('success', 'El trámite fue publicado en el portal ciudadano.');

        return redirect()->route('institucional_development.requests.edit', $this->request->id);
    }

    public function backToDraft()
    {
        $this->ensureEditable();

        if ($this->request == null) {
            return;
        }

        $this->request->update(['status' => ServiceRequest::STATUS_DRAFT]);
        $this->status = ServiceRequest::STATUS_DRAFT;
        $this->markSaved();

        Session::flash('success', 'El trámite regresó a borrador y dejó de mostrarse en el portal.');
    }

    public function render()
    {
        return view('service_requests.utilities.crud');
    }
}
