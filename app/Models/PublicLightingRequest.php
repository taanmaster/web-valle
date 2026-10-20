<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicLightingRequest extends Model
{
    use HasFactory;

    /**
     * Estados de la petición (clave => [etiqueta, color de badge])
     */
    public const STATUSES = [
        'recibida' => ['Recibida', 'secondary'],
        'en_atencion' => ['En atención', 'warning'],
        'atendida' => ['Atendida', 'info'],
        'cerrada' => ['Cerrada', 'success'],
        'informacion_insuficiente' => ['Información insuficiente', 'danger'],
    ];

    protected $fillable = [
        'user_id',
        'folio',
        'status',
        'full_name',
        'phone',
        'email',
        'colony',
        'street',
        'number',
        'between_streets',
        'references',
        'map_url',
        'location_photo_name',
        'location_photo_s3_url',
        'description',
        'pole_number',
        'problem_since',
        'terms_accepted',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
    ];

    /**
     * Relación con el ciudadano solicitante
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Fotografías de evidencia del problema (enviadas por el ciudadano)
     */
    public function files()
    {
        return $this->hasMany(PublicLightingRequestFile::class)->where('type', 'citizen');
    }

    /**
     * Fotografías de evidencia de atención (subidas por el personal)
     */
    public function attentionFiles()
    {
        return $this->hasMany(PublicLightingRequestFile::class)->where('type', 'attention');
    }

    /**
     * Historial de cambios de estatus y mensajes enviados al ciudadano
     */
    public function logs()
    {
        return $this->hasMany(PublicLightingRequestLog::class)->latest();
    }

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status][0] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return self::STATUSES[$this->status][1] ?? 'secondary';
    }

    /**
     * Ubicación en una sola línea
     */
    public function getFullAddressAttribute()
    {
        return trim($this->street.' '.$this->number).', '.$this->colony;
    }
}
