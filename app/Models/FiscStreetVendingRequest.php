<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscStreetVendingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'folio',
        'status',
        'full_name',
        'phone',
        'address',
        'business_type',
        'installation_type',
        'front_meters',
        'depth_meters',
        'awning_qty',
        'cart_qty',
        'table_qty',
        'chairs_qty',
        'option1_street',
        'option1_between_streets',
        'option1_photo_name',
        'option1_photo_s3_url',
        'option2_street',
        'option2_photo_name',
        'option2_photo_s3_url',
        'option3_street',
        'option3_photo_name',
        'option3_photo_s3_url',
        'work_days',
        'schedule_from',
        'schedule_to',
    ];

    /**
     * Relación con el ciudadano solicitante
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relación con los documentos adjuntos (lista de verificación)
     */
    public function files()
    {
        return $this->hasMany(FiscStreetVendingRequestFile::class);
    }

    /**
     * Obtener el estado en formato legible
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'nueva_solicitud' => 'Nuevo',
            'inspeccion' => 'Inspección',
            'aprobada' => 'Aprobada',
            'denegada' => 'Denegada',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Obtener el color del badge según el estado
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'nueva_solicitud' => 'secondary',
            'inspeccion' => 'warning',
            'aprobada' => 'success',
            'denegada' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Obtener los días de trabajo como arreglo (a partir del string separado por comas)
     */
    public function getWorkDaysArrayAttribute()
    {
        if (! $this->work_days) {
            return [];
        }

        return explode(',', $this->work_days);
    }
}
