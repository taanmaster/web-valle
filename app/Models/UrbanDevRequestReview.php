<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrbanDevRequestReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'urban_dev_request_id',
        'dependency',
        'format',
        'status',
        'sent_at',
        'sent_by',
        'responsible_name',
        'technical_responsible',
        'construction_type',
        'establishment_name',
        'property_address',
        'latitude',
        'longitude',
        'resolution',
        'reference_number',
        'technical_notes',
        'conditions_requirements',
        'issued_by',
        'resolution_document_name',
        'resolution_document_s3_url',
        'resolution_document_size',
        'resolved_at',
        'resolved_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    /**
     * Solicitud de Desarrollo Urbano origen del dictamen
     */
    public function urbanDevRequest()
    {
        return $this->belongsTo(UrbanDevRequest::class);
    }

    /**
     * Usuario de Desarrollo Urbano que envió la solicitud a la dependencia
     */
    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    /**
     * Usuario de la dependencia receptora que capturó la resolución
     */
    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Recalcula el estatus a partir de lo que realmente se ha capturado:
     *   recibida    → nada capturado todavía por la dependencia receptora
     *   en_revision → hay algo capturado pero falta el oficio de resolución firmado
     *   emitida     → oficio de resolución firmado presente
     */
    public function refreshStatus(): string
    {
        if (filled($this->resolution_document_s3_url)) {
            return 'emitida';
        }

        $hasSomething = filled($this->resolution) || filled($this->technical_notes);

        return $hasSomething ? 'en_revision' : 'recibida';
    }

    public function getDependencyLabelAttribute()
    {
        $labels = [
            'proteccion_civil' => 'Protección Civil',
            'medio_ambiente' => 'Dirección de Medio Ambiente',
        ];

        return $labels[$this->dependency] ?? $this->dependency;
    }

    public function getFormatLabelAttribute()
    {
        $labels = [
            'alto_impacto' => 'Alto Impacto',
            'licencia_ambiental_funcionamiento' => 'Licencia Ambiental de Funcionamiento',
            'manejo_de_residuos' => 'Manejo de Residuos',
        ];

        return $labels[$this->format] ?? $this->format;
    }

    public function getStatusLabelAttribute()
    {
        $emitidaLabel = $this->dependency === 'medio_ambiente' ? 'Visto Bueno Emitido' : 'Opinión Emitida';

        $statuses = [
            'recibida' => 'Recibida',
            'en_revision' => 'En Revisión',
            'emitida' => $emitidaLabel,
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'recibida' => 'secondary',
            'en_revision' => 'warning',
            'emitida' => 'success',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getResolutionLabelAttribute()
    {
        $labels = [
            'factible' => 'Factible',
            'factible_con_condicionantes' => 'Factible con condicionantes',
            'no_factible' => 'No factible',
            'procedente' => 'Procedente',
            'procedente_con_condicionantes' => 'Procedente con condicionantes',
            'no_procedente' => 'No procedente',
        ];

        return $labels[$this->resolution] ?? $this->resolution;
    }

    public function getResolutionColorAttribute()
    {
        if (in_array($this->resolution, ['no_factible', 'no_procedente'])) {
            return 'danger';
        }

        if (in_array($this->resolution, ['factible_con_condicionantes', 'procedente_con_condicionantes'])) {
            return 'warning';
        }

        return 'success';
    }

    public function getResolutionDocumentFormattedSizeAttribute()
    {
        return $this->formatBytes($this->resolution_document_size);
    }

    private function formatBytes($bytes)
    {
        if (! $bytes) {
            return '0 bytes';
        }

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        } elseif ($bytes == 1) {
            return $bytes.' byte';
        }

        return $bytes.' bytes';
    }
}
