<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'borrador';

    public const STATUS_REVIEW = 'en_revision';

    public const STATUS_PUBLISHED = 'publicado';

    public const STATUS_LABELS = [
        self::STATUS_DRAFT => 'Borrador',
        self::STATUS_REVIEW => 'En revisión',
        self::STATUS_PUBLISHED => 'Publicado',
    ];

    protected $guarded = [];

    protected $casts = [
        'channels' => 'array',
        'submission_forms' => 'array',
        'payment_options' => 'array',
        'can_start_online' => 'boolean',
        'can_finish_online' => 'boolean',
        'requires_inspection' => 'boolean',
        'has_alternate_office' => 'boolean',
        'afirmativa_ficta' => 'boolean',
        'negativa_ficta' => 'boolean',
        'allows_renewal' => 'boolean',
        'collects_personal_data' => 'boolean',
        'is_favorite' => 'boolean',
    ];

    public function costs()
    {
        return $this->hasMany(ServiceRequestCost::class, 'service_request_id');
    }

    public function requirementItems()
    {
        return $this->hasMany(ServiceRequestRequirement::class, 'service_request_id');
    }

    public function relatedProcedures()
    {
        return $this->hasMany(ServiceRequestRelatedProcedure::class, 'service_request_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? 'Borrador';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => 'success',
            self::STATUS_REVIEW => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Modalidad mostrada en el listado, derivada de los canales de atención.
     */
    public function getModalityLabelAttribute(): string
    {
        $channels = $this->channels ?? [];

        $online = in_array('En línea', $channels) || $this->can_start_online;
        $inPerson = in_array('Presencial', $channels);

        if ($online && $inPerson) {
            return 'En línea / Presencial';
        }

        if ($online) {
            return 'En línea';
        }

        if ($inPerson) {
            return 'Presencial';
        }

        return '—';
    }
}
