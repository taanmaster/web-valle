<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrbanDevRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'request_type',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Relación con archivos adjuntos
     */
    public function files()
    {
        return $this->hasMany(\App\Models\UrbanDevRequestFile::class);
    }

    /**
     * Obtener el estado en formato legible
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'new' => 'Nuevo',
            'initial_review' => 'Revisión Inicial',
            'requirement_validation' => 'Validación de Requisitos',
            'requires_correction' => 'Requiere Corrección',
            'payment_pending' => 'Espera de Pago',
            'authorization_process' => 'Proceso de Autorización',
            'authorized' => 'Autorizada',
            'rejected' => 'Rechazada',
            // Estados legacy
            'in_progress' => 'En Progreso',
            'cancelled' => 'Cancelado',
            'validation' => 'Validación'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Obtener el color del badge según el estado
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'new' => 'primary',
            'initial_review' => 'info',
            'requirement_validation' => 'warning',
            'requires_correction' => 'danger',
            'payment_pending' => 'warning',
            'authorization_process' => 'info',
            'authorized' => 'success',
            'rejected' => 'danger',
            // Estados legacy
            'in_progress' => 'warning',
            'cancelled' => 'secondary',
            'validation' => 'dark'
        ];

        return $colors[$this->status] ?? 'primary';
    }

    /**
     * Obtener el tipo de solicitud en formato legible
     */
    public function getRequestTypeLabelAttribute()
    {
        $types = [
            'uso-de-suelo' => 'Licencia de Uso de Suelo',
            'constancia-de-factibilidad' => 'Constancia de Factibilidad',
            'permiso-de-anuncios' => 'Permiso de Anuncios y Toldos',
            'certificacion-numero-oficial' => 'Certificación de Número Oficial',
            'permiso-de-division' => 'Permiso de División',
            'uso-de-via-publica' => 'Uso de Vía Pública',
            'licencia-de-construccion' => 'Licencia de Construcción',
            'permiso-construccion-panteones' => 'Permiso de Construcción en Panteones',
            // Valores legacy
            'uso_suelo' => 'Uso de Suelo',
            'constancia_factibilidad' => 'Constancia de Factibilidad',
            'permiso_anuncios' => 'Permiso de Anuncios',
            'certificacion_numero_oficial' => 'Certificación de Número Oficial',
            'permiso_division' => 'Permiso de División',
            'uso_via_publica' => 'Uso de Vía Pública',
            'licencia_construccion' => 'Licencia de Construcción',
            'permiso_construccion_panteones' => 'Permiso de Construcción en Panteones',
            'general' => 'General'
        ];

        return $types[$this->request_type] ?? $this->request_type;
    }
}
