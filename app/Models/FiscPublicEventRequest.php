<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscPublicEventRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'folio',
        'status',
        'event_type',
        'event_date',
        'responsible_person',
        'schedule',
        'exact_location',
        'requires_street_closure',
        'is_in_community',
    ];

    protected $casts = [
        'event_date' => 'date',
        'requires_street_closure' => 'boolean',
        'is_in_community' => 'boolean',
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
        return $this->hasMany(FiscPublicEventRequestFile::class);
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
}
