<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscPrivateEventRequest extends Model
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
        'venue',
        'attendees',
        'alcohol_sales',
    ];

    protected $casts = [
        'event_date' => 'date',
        'alcohol_sales' => 'boolean',
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
        return $this->hasMany(FiscPrivateEventRequestFile::class);
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
