<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilProtectionCase extends Model
{
    use HasFactory;

    /**
     * Estatus del expediente: clave => [número, etiqueta, color, siguiente acción (nota bajo el folio)]
     */
    public const STATUSES = [
        'borrador' => [1, 'Borrador', 'secondary', null],
        'en_revision' => [2, 'En revisión documental', 'primary', 'Revisar documentos'],
        'requiere_correccion' => [3, 'Requiere corrección', 'warning', null],
        'entrega_fisica' => [4, 'Entrega física pendiente', 'warning', 'Recibir originales'],
        'inspeccion_programada' => [5, 'Inspección programada', 'primary', null],
        'inspeccion_observaciones' => [6, 'Inspección con observaciones', 'warning', null],
        'entero_generado' => [7, 'Entero generado – Pago pendiente', 'warning', 'Confirmar pago'],
        'pago_confirmado' => [8, 'Pago confirmado', 'primary', 'Emitir documento'],
        'emitido' => [9, 'Emitido', 'success', null],
        'no_procede' => [10, 'No procede', 'danger', null],
        'cancelado' => [null, 'Cancelado', 'secondary', null],
    ];

    /**
     * Estatus que exigen tener aprobados todos los documentos obligatorios
     */
    public const REQUIRES_APPROVED_DOCUMENTS = [
        'entrega_fisica', 'inspeccion_programada', 'inspeccion_observaciones',
        'entero_generado', 'pago_confirmado', 'emitido',
    ];

    public const FINAL_STATUSES = ['emitido', 'no_procede', 'cancelado'];


    protected $fillable = [
        'folio',
        'civil_protection_procedure_id',
        'user_id',
        'created_by',
        'origin',
        'person_type',
        'applicant_name',
        'phone',
        'email',
        'status',
        'submitted_at',
        'payment_order_folio',
        'payment_order_concept',
        'payment_order_amount',
        'payment_order_note',
        'payment_order_generated_at',
        'payment_order_generated_by',
        'payment_receipt_name',
        'payment_receipt_s3_url',
        'payment_date',
        'payment_confirmed_at',
        'document_consecutive',
        'document_number',
        'document_name',
        'document_s3_url',
        'issued_at',
        'expires_at',
    ];

    protected $casts = [
        'payment_order_amount' => 'decimal:2',
        'payment_order_generated_at' => 'datetime',
        'submitted_at' => 'datetime',
        'payment_date' => 'date',
        'payment_confirmed_at' => 'datetime',
        'issued_at' => 'datetime',
        'expires_at' => 'date',
    ];

    /**
     * Siguiente folio consecutivo del año: PC-2026-0192
     */
    public static function nextFolio(): string
    {
        $prefix = 'PC-'.now()->year.'-';
        $last = static::where('folio', 'like', $prefix.'%')->orderByDesc('folio')->value('folio');
        $next = $last ? ((int) substr($last, strlen($prefix))) + 1 : 1;

        return $prefix.str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Folio del entero: ENT + prefijo del folio + resto del folio + año (PC-2026-0092 → ENT-PC-0092-2026)
     */
    public function getPaymentOrderFolioPreviewAttribute(): string
    {
        [$prefix, $year, $number] = explode('-', $this->folio);

        return "ENT-{$prefix}-{$number}-{$year}";
    }

    /**
     * Asigna el número de opinión/permiso: PREFIJO-CONSECUTIVO-AÑO, consecutivo por prefijo de trámite
     */
    public function nextDocumentConsecutive(): int
    {
        return (static::where('civil_protection_procedure_id', $this->civil_protection_procedure_id)
            ->max('document_consecutive') ?? 0) + 1;
    }

    public function documentNumberFor(int $consecutive, $date = null): string
    {
        return $this->procedure->folio_prefix.'-'.$consecutive.'-'.($date ? \Carbon\Carbon::parse($date)->year : now()->year);
    }

    public function procedure()
    {
        return $this->belongsTo(CivilProtectionProcedure::class, 'civil_protection_procedure_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(CivilProtectionCaseDocument::class)->orderBy('sort_order');
    }

    public function logs()
    {
        return $this->hasMany(CivilProtectionCaseLog::class)->latest('id');
    }

    public function inspections()
    {
        return $this->hasMany(CivilProtectionInspection::class)->latest('id');
    }

    public function latestInspection()
    {
        return $this->hasOne(CivilProtectionInspection::class)->latestOfMany();
    }

    public function getStatusNumberAttribute()
    {
        return self::STATUSES[$this->status][0] ?? null;
    }

    public function getStatusLabelAttribute()
    {
        $number = $this->status_number;

        return ($number ? $number.'. ' : '').(self::STATUSES[$this->status][1] ?? $this->status);
    }

    public function getStatusColorAttribute()
    {
        return self::STATUSES[$this->status][2] ?? 'secondary';
    }

    public function getNextActionAttribute()
    {
        return self::STATUSES[$this->status][3] ?? null;
    }

    public function getOriginLabelAttribute()
    {
        return $this->origin === 'online' ? 'En línea' : 'Presencial';
    }

    public function getPersonTypeLabelAttribute()
    {
        return $this->person_type === 'moral' ? 'Persona moral' : 'Persona física';
    }

    /**
     * Días transcurridos desde que se recibió la solicitud
     */
    public function getDaysElapsedAttribute(): int
    {
        return (int) ($this->submitted_at ?? $this->created_at)->startOfDay()->diffInDays(now()->startOfDay());
    }

    /**
     * Expedientes que ya llegaron a Protección Civil (excluye borradores en línea)
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', '!=', 'borrador');
    }

    /**
     * Estatus en los que el ciudadano tiene algo pendiente
     */
    public function getRequiresCitizenActionAttribute(): bool
    {
        return in_array($this->status, ['borrador', 'requiere_correccion', 'entero_generado']);
    }

    /**
     * Días de vigencia restantes del documento emitido (0 cuando ya venció)
     */
    public function getRemainingDaysAttribute(): ?int
    {
        if ($this->status !== 'emitido' || ! $this->expires_at) {
            return null;
        }

        return max(0, (int) now()->startOfDay()->diffInDays($this->expires_at, false));
    }

    /**
     * Estado de vigencia del documento emitido:
     * vigente = le queda más de la mitad de su vigencia · por_vencer = la mitad o menos · vencida = 0 días
     */
    public function getValidityStatusAttribute(): ?string
    {
        $days = $this->remaining_days;

        if ($days === null) {
            return null;
        }

        if ($days === 0) {
            return 'vencida';
        }

        $total = $this->issued_at ? $this->issued_at->startOfDay()->diffInDays($this->expires_at) : $this->procedure->validity_days;

        return $days > $total / 2 ? 'vigente' : 'por_vencer';
    }

    /**
     * [etiqueta, color] de la vigencia, o null si no hay documento emitido
     */
    public function getValidityAttribute(): ?array
    {
        return match ($this->validity_status) {
            'vencida' => ['Vencida', 'danger'],
            'por_vencer' => ['Por vencer · '.$this->remaining_days.' d', 'warning'],
            'vigente' => ['Vigente · '.$this->remaining_days.' d', 'success'],
            default => null,
        };
    }

    /**
     * Ids de expedientes emitidos por vencer. La regla depende de la vigencia de cada trámite,
     * por eso se calcula en PHP (el volumen de documentos emitidos es bajo).
     */
    public static function expiringSoonIds(): array
    {
        return static::with('procedure')->where('status', 'emitido')->get()
            ->filter(fn ($case) => $case->validity_status === 'por_vencer')
            ->pluck('id')->all();
    }

    public function scopeExpiringSoon($query)
    {
        return $query->whereIn('id', static::expiringSoonIds());
    }

    /**
     * Días que lleva el expediente en su estatus actual
     */
    public function getDaysInStatusAttribute(): int
    {
        $since = $this->logs->firstWhere('status', $this->status)?->created_at ?? $this->created_at;

        return (int) $since->startOfDay()->diffInDays(now()->startOfDay());
    }

    public function paymentOrderAuthor()
    {
        return $this->belongsTo(User::class, 'payment_order_generated_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function requiredDocumentsApproved(): bool
    {
        return ! $this->documents->where('is_required', true)->where('status', '!=', 'aceptado')->count();
    }

    public function originalsReceived(): bool
    {
        return ! $this->documents->where('requires_original', true)->where('status', '!=', 'sin_entregar')
            ->where('original_received', false)->count();
    }

    /**
     * Agrega al expediente los requisitos que se sumaron al trámite después de iniciarlo
     */
    public function syncNewRequirements(): void
    {
        $existing = $this->documents()->pluck('civil_protection_procedure_requirement_id')->filter()->all();

        $this->procedure->requirements()->whereNotIn('id', $existing)->get()
            ->each(fn ($requirement) => $this->documents()->create(
                CivilProtectionCaseDocument::attributesFromRequirement($requirement) + ['added_after_start' => true]
            ));
    }

    /**
     * Registra un movimiento en la línea de tiempo y, si hay ciudadano vinculado, le envía el mensaje
     */
    public function log(string $status, ?string $note = null, ?int $userId = null, ?string $citizenMessage = null): void
    {
        $this->logs()->create(['status' => $status, 'note' => $note, 'user_id' => $userId]);

        if ($citizenMessage && $this->user_id) {
            CitizenMessage::create([
                'user_id' => $this->user_id,
                'sent_by' => $userId,
                'subject' => 'Expediente '.$this->folio.' — '.$this->procedure->name,
                'body' => $citizenMessage,
                'related_model_type' => self::class,
                'related_model_id' => $this->id,
            ]);
        }
    }
}
