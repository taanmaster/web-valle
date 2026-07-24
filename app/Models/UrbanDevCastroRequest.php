<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrbanDevCastroRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'urban_dev_request_id',
        'status',
        'fecha_solicitud',
        'fecha_entrega_documentos',
        'cuenta_predial',
        'nombre_contribuyente',
        'tipo_predio',
        'domicilio_predio',
        'localidad_colonia_ejido',
        'manzana_lote',
        'superficie',
        'uso_tramite',
        'url_expediente',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_entrega_documentos' => 'date',
        'superficie' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Solicitud de Desarrollo Urbano a la que pertenece esta captura de predio.
     */
    public function urbanDevRequest()
    {
        return $this->belongsTo(\App\Models\UrbanDevRequest::class, 'urban_dev_request_id');
    }

    /**
     * Estado en formato legible.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pendiente'  => 'Pendiente',
            'en_captura' => 'En captura',
            'completado' => 'Completado',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Color del badge según el estado.
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pendiente'  => 'warning',
            'en_captura' => 'danger',
            'completado' => 'success',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
