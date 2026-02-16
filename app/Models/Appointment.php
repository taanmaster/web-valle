<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'backoffice_dependency_id',
        'description',
        'slot_duration',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'slot_duration' => 'integer',
    ];

    // ──────────────────────────────────────────────
    // Relaciones
    // ──────────────────────────────────────────────

    public function dependency()
    {
        return $this->belongsTo(BackofficeDependency::class, 'backoffice_dependency_id');
    }

    public function schedules()
    {
        return $this->hasMany(AppointmentSchedule::class);
    }

    public function holidays()
    {
        return $this->hasMany(AppointmentHoliday::class);
    }

    public function bookings()
    {
        return $this->hasMany(AppointmentBooking::class);
    }

    // ──────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // ──────────────────────────────────────────────
    // Métodos de Slug
    // ──────────────────────────────────────────────

    public static function generateSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    // ──────────────────────────────────────────────
    // Métodos de Disponibilidad
    // ──────────────────────────────────────────────

    /**
     * Verifica si un día es inhábil para este trámite.
     */
    public function isHoliday(string $date): bool
    {
        return $this->holidays()->where('date', $date)->exists();
    }

    /**
     * Obtiene los horarios configurados para un día de la semana dado.
     */
    public function getSchedulesForDay(int $dayOfWeek)
    {
        return $this->schedules()->where('day_of_week', $dayOfWeek)->orderBy('start_time')->get();
    }

    /**
     * Genera los slots de tiempo disponibles para una fecha dada.
     *
     * @param string $date Fecha en formato Y-m-d
     * @return array Array de slots con 'start_time', 'end_time', 'available'
     */
    public function generateSlots(string $date): array
    {
        $carbonDate = Carbon::parse($date);

        // Si la fecha es pasada, no hay slots
        if ($carbonDate->lt(Carbon::today())) {
            return [];
        }

        // Si es día inhábil, no hay slots
        if ($this->isHoliday($date)) {
            return [];
        }

        // Obtener horarios del día de la semana
        $dayOfWeek = $carbonDate->dayOfWeek; // 0=domingo, 6=sábado
        $schedules = $this->getSchedulesForDay($dayOfWeek);

        if ($schedules->isEmpty()) {
            return [];
        }

        // Obtener bookings existentes (no cancelados) para esta fecha
        $existingBookings = $this->bookings()
            ->where('date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('start_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $slots = [];
        $now = Carbon::now();
        $isToday = $carbonDate->isToday();

        foreach ($schedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);

            while ($start->copy()->addMinutes($this->slot_duration)->lte($end)) {
                $slotStart = $start->format('H:i');
                $slotEnd = $start->copy()->addMinutes($this->slot_duration)->format('H:i');

                // Si es hoy, no mostrar slots que ya pasaron
                if ($isToday && $start->lt($now)) {
                    $start->addMinutes($this->slot_duration);
                    continue;
                }

                $isBooked = in_array($slotStart, $existingBookings);

                $slots[] = [
                    'start_time' => $slotStart,
                    'end_time' => $slotEnd,
                    'available' => !$isBooked,
                ];

                $start->addMinutes($this->slot_duration);
            }
        }

        return $slots;
    }

    /**
     * Calcula la disponibilidad de un mes completo.
     *
     * @return array Mapa [fecha => ['total' => int, 'available' => int, 'percentage' => float, 'color' => string]]
     */
    public function getAvailabilityForMonth(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        $today = Carbon::today();

        // Pre-cargar días inhábiles del mes
        $holidays = $this->holidays()
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        // Pre-cargar bookings del mes (no cancelados)
        $bookings = $this->bookings()
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->where('status', '!=', 'cancelled')
            ->get()
            ->groupBy(fn($b) => Carbon::parse($b->date)->format('Y-m-d'));

        // Pre-cargar schedules por día de la semana
        $schedulesByDay = $this->schedules->groupBy('day_of_week');

        $availability = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $dateStr = $current->format('Y-m-d');
            $dayOfWeek = $current->dayOfWeek;

            // Fecha pasada
            if ($current->lt($today)) {
                $availability[$dateStr] = [
                    'total' => 0,
                    'available' => 0,
                    'percentage' => 0,
                    'color' => '#6c757d', // gris
                ];
                $current->addDay();
                continue;
            }

            // Día inhábil
            if (in_array($dateStr, $holidays)) {
                $availability[$dateStr] = [
                    'total' => 0,
                    'available' => 0,
                    'percentage' => 0,
                    'color' => '#6c757d', // gris
                ];
                $current->addDay();
                continue;
            }

            // Sin horarios configurados para este día
            if (!isset($schedulesByDay[$dayOfWeek]) || $schedulesByDay[$dayOfWeek]->isEmpty()) {
                $availability[$dateStr] = [
                    'total' => 0,
                    'available' => 0,
                    'percentage' => 0,
                    'color' => '#6c757d', // gris
                ];
                $current->addDay();
                continue;
            }

            // Calcular total de slots
            $totalSlots = 0;
            $now = Carbon::now();
            $isToday = $current->isToday();

            foreach ($schedulesByDay[$dayOfWeek] as $schedule) {
                $start = Carbon::parse($schedule->start_time);
                $end = Carbon::parse($schedule->end_time);

                while ($start->copy()->addMinutes($this->slot_duration)->lte($end)) {
                    if ($isToday && $start->lt($now)) {
                        $start->addMinutes($this->slot_duration);
                        continue;
                    }
                    $totalSlots++;
                    $start->addMinutes($this->slot_duration);
                }
            }

            // Bookings existentes para este día
            $bookedCount = isset($bookings[$dateStr]) ? $bookings[$dateStr]->count() : 0;
            $availableSlots = max(0, $totalSlots - $bookedCount);

            // Calcular porcentaje y color
            $percentage = $totalSlots > 0 ? ($availableSlots / $totalSlots) * 100 : 0;

            if ($totalSlots === 0 || $availableSlots === 0) {
                $color = '#6c757d'; // gris - sin disponibilidad
            } elseif ($percentage <= 25) {
                $color = '#dc3545'; // rojo - baja disponibilidad
            } elseif ($percentage <= 50) {
                $color = '#ffc107'; // amarillo - media disponibilidad
            } else {
                $color = '#198754'; // verde - alta disponibilidad
            }

            $availability[$dateStr] = [
                'total' => $totalSlots,
                'available' => $availableSlots,
                'percentage' => round($percentage),
                'color' => $color,
            ];

            $current->addDay();
        }

        return $availability;
    }
}
