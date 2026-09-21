<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SareRequestReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'sare_request_id',
        'dependency',
        'status',
        'sent_at',
        'sent_by',
        'inspector_id',
        'inspection_date',
        'measured_area',
        'observations',
        'permit_document_name',
        'permit_document_s3_url',
        'permit_document_size',
        'payment_amount',
        'payment_reference',
        'payment_document_name',
        'payment_document_s3_url',
        'payment_document_size',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'inspection_date' => 'datetime',
        'payment_amount' => 'decimal:2',
    ];

    /**
     * Relación con la solicitud SARE original
     */
    public function sareRequest()
    {
        return $this->belongsTo(SareRequest::class);
    }

    /**
     * Relación con el inspector asignado (roster de Desarrollo Urbano)
     */
    public function inspector()
    {
        return $this->belongsTo(UrbanDevWorker::class, 'inspector_id');
    }

    /**
     * Usuario que envió la solicitud a la dependencia
     */
    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    /**
     * Evidencia fotográfica de la inspección
     */
    public function photos()
    {
        return $this->hasMany(SareRequestReviewPhoto::class);
    }

    /**
     * Recalcula el estatus a partir de lo que realmente se ha capturado:
     *   nuevo       → nada capturado todavía
     *   en_proceso  → hay algo capturado (inspección, permiso o pago) pero no ambos documentos
     *   completado  → permiso y pago con documento presentes
     */
    public function refreshStatus(): string
    {
        $hasPermit = filled($this->permit_document_s3_url);
        $hasPayment = filled($this->payment_document_s3_url);

        if ($hasPermit && $hasPayment) {
            return 'completado';
        }

        $hasSomething = $hasPermit || $hasPayment || filled($this->inspection_date);

        return $hasSomething ? 'en_proceso' : 'nuevo';
    }

    /**
     * Obtener el estado en formato legible
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'nuevo' => 'Nuevo',
            'en_proceso' => 'En Proceso',
            'completado' => 'Completado',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Obtener el color del badge según el estado
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'nuevo' => 'secondary',
            'en_proceso' => 'warning',
            'completado' => 'success',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Tamaño del documento de permiso en formato legible
     */
    public function getPermitFormattedSizeAttribute()
    {
        return $this->formatBytes($this->permit_document_size);
    }

    /**
     * Tamaño del comprobante de pago en formato legible
     */
    public function getPaymentFormattedSizeAttribute()
    {
        return $this->formatBytes($this->payment_document_size);
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
