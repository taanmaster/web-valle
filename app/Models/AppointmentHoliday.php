<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentHoliday extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'date',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // ──────────────────────────────────────────────
    // Relaciones
    // ──────────────────────────────────────────────

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
