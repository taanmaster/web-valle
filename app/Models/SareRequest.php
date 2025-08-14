<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SareRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'request_type',
        'description',
        'request_num',
        'request_date',
        'catastral_num',
        'rfc_name',
        'rfc_num',
        'property_owner',
        'office_phone',
        'mobile_phone',
        'email',
        'legal_representative_name',
        'legal_representative_father_last_name',
        'legal_representative_mother_last_name',
        'legal_representative_office_phone',
        'legal_representative_mobile_phone',
        'legal_representative_personal_phone',
        'legal_representative_email',
        'legal_representative_ownership_document',
        'establishment_legal_cause',
        'establishment_legal_cause_addon',
        'establishment_good_faith_clause',
        'establishment_address_street',
        'establishment_address_number',
        'establishment_address_neighborhood',
        'establishment_address_municipality',
        'establishment_address_state',
        'establishment_address_postal_code',
        'establishment_use',
        'commercial_name',
        'aprox_investment',
        'jobs_to_generate',
        'is_location_in_operation',
        'operation_start_date',
        'business_hours',
        'zoning_front',
        'zoning_rear',
        'zoning_left',
        'zoning_right',
        'license_num',
        'vobo_favorable',
        'entry_date',
        'exit_date',
        'document_type'
    ];

    protected $casts = [
        'is_location_in_operation' => 'boolean',
        'vobo_favorable' => 'boolean',
        'entry_date' => 'datetime',
        'exit_date' => 'datetime',
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
        return $this->hasMany(\App\Models\SareRequestFile::class);
    }

    /**
     * Obtener el estado en formato legible
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'new' => 'Nuevo',
            'in_progress' => 'En Progreso',
            'cancelled' => 'Cancelado',
            'payment_pending' => 'Pago Pendiente',
            'authorized' => 'Autorizado',
            'rejected' => 'Rechazado',
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
            'in_progress' => 'warning',
            'cancelled' => 'secondary',
            'payment_pending' => 'info',
            'authorized' => 'success',
            'rejected' => 'danger',
            'validation' => 'dark'
        ];

        return $colors[$this->status] ?? 'primary';
    }
}
