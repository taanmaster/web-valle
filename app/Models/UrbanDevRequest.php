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
        'inspector_id',
        'inspection_start_date',
        'inspector_license_number',
        'building_type',
        'payment_date',
        'payment_ref_number_1',
        'payment_ref_number_2',
        'payment_amount',
        'inspection_validity_start',
        'inspection_validity_end',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'inspection_start_date' => 'date',
        'payment_date' => 'date',
        'inspection_validity_start' => 'date',
        'inspection_validity_end' => 'date',
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
     * Relación con el inspector
     */
    public function inspector()
    {
        return $this->belongsTo(\App\Models\User::class, 'inspector_id');
    }

    /**
     * Obtener el estado en formato legible
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'new' => 'Nuevo',
            'entry' => 'Ingreso',
            'validation' => 'Validación',
            'requires_correction' => 'Requiere Corrección',
            'inspection' => 'Inspección',
            'resolved' => 'Resolución'
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
            'entry' => 'info',
            'validation' => 'warning',
            'requires_correction' => 'danger',
            'inspection' => 'secondary',
            'resolved' => 'success'
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

    /**
     * Obtener el tipo de edificación en formato legible
     */
    public function getBuildingTypeLabelAttribute()
    {
        $types = [
            'casa_habitacion' => 'Casa Habitación',
            'bodega' => 'Bodega',
            'local_comercial' => 'Local Comercial',
            'otro' => 'Otro'
        ];

        return $types[$this->building_type] ?? $this->building_type;
    }

    /**
     * Obtener el domicilio del ciudadano relacionado
     */
    public function getUserAddressAttribute()
    {
        $citizen = \App\Models\Citizen::where('email', $this->user->email)->first();
        
        if (!$citizen) {
            return 'No disponible';
        }

        $addressParts = [];
        
        if ($citizen->street) {
            $addressParts[] = $citizen->street;
        }
        
        if ($citizen->colony) {
            $addressParts[] = $citizen->colony;
        }
        
        if ($citizen->address && !in_array($citizen->address, $addressParts)) {
            $addressParts[] = $citizen->address;
        }

        return !empty($addressParts) ? implode(', ', $addressParts) : 'No disponible';
    }
}
