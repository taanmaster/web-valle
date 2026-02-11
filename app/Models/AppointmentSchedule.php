<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
    ];

    /**
     * Nombres de los días de la semana en español.
     */
    public const DAY_NAMES = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    // ──────────────────────────────────────────────
    // Relaciones
    // ──────────────────────────────────────────────

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // ──────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────

    public function getDayNameAttribute(): string
    {
        return self::DAY_NAMES[$this->day_of_week] ?? 'Desconocido';
    }
}
