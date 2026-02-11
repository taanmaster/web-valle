<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'appointment_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'attendance_status',
        'full_name',
        'email',
        'phone',
        'notes',
        'confirmed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'date' => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // ──────────────────────────────────────────────
    // Relaciones
    // ──────────────────────────────────────────────

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ──────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Citas agendadas que no han sido confirmadas y tienen más de 24 horas.
     */
    public function scopePendingConfirmation($query)
    {
        return $query->where('status', 'scheduled')
            ->where('created_at', '<', Carbon::now()->subHours(24));
    }

    // ──────────────────────────────────────────────
    // Métodos
    // ──────────────────────────────────────────────

    /**
     * Genera un folio único para la cita.
     * Formato: CT + año + secuencial de 4 dígitos (CT20260001)
     */
    public static function generateFolio(): string
    {
        $year = date('Y');
        $lastBooking = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastBooking
            ? intval(substr($lastBooking->folio, -4)) + 1
            : 1;

        return 'CT' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    // ──────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'Agendada',
            'confirmed' => 'Confirmada',
            'cancelled' => 'Cancelada',
            default => 'Desconocido',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getAttendanceLabelAttribute(): string
    {
        return match ($this->attendance_status) {
            'attended' => 'Asistió',
            'not_attended' => 'No Asistió',
            default => 'Pendiente',
        };
    }

    public function getAttendanceColorAttribute(): string
    {
        return match ($this->attendance_status) {
            'attended' => 'success',
            'not_attended' => 'danger',
            default => 'info',
        };
    }
}
