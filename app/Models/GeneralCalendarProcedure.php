<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GeneralCalendarProcedure extends Model
{
    public const SLOT_MINUTES = 30;

    // Orden de presentación L-D con índice Carbon (0=domingo ... 6=sábado)
    public const DAYS = [
        1 => 'L',
        2 => 'M',
        3 => 'M',
        4 => 'J',
        5 => 'V',
        6 => 'S',
        0 => 'D',
    ];

    public const DAY_NAMES = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    protected $fillable = [
        'name',
        'slug',
        'dependencia',
        'note',
        'attention_days',
        'attention_start',
        'attention_end',
        'requires_id',
        'status',
        'created_date',
    ];

    protected $casts = [
        'attention_days' => 'array',
        'requires_id'    => 'boolean',
        'status'         => 'boolean',
        'created_date'   => 'date',
    ];

    public function blocks()
    {
        return $this->hasMany(GeneralCalendarBlock::class)->orderBy('start_time');
    }

    public function closures()
    {
        return $this->hasMany(GeneralCalendarClosure::class)->orderBy('date');
    }

    public function appointments()
    {
        return $this->hasMany(GeneralCalendarAppointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public static function generateSlug(string $name): string
    {
        $slug  = Str::slug($name);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Bloques de 30 min para una fecha: configurados para ese día de la semana,
     * excluyendo cierres, citas ya agendadas y horas pasadas si es hoy.
     *
     * @return array<int, array{start: string, end: string, available: bool, appointment: ?GeneralCalendarAppointment}>
     */
    public function slotsForDate(string $date): array
    {
        $carbonDate = Carbon::parse($date);

        if ($carbonDate->lt(Carbon::today())) {
            return [];
        }

        $blocks = $this->blocks()->where('day_of_week', $carbonDate->dayOfWeek)->get();

        if ($blocks->isEmpty()) {
            return [];
        }

        $closures = $this->closures()->whereDate('date', $date)->get();

        $booked = $this->appointments()
            ->whereDate('date', $date)
            ->where('status', '!=', 'cancelled')
            ->get()
            ->keyBy(fn ($a) => Carbon::parse($a->start_time)->format('H:i'));

        $now     = Carbon::now();
        $isToday = $carbonDate->isToday();

        $slots = [];

        foreach ($blocks as $block) {
            $start = Carbon::parse($date . ' ' . $block->start_time);
            $end   = $start->copy()->addMinutes(self::SLOT_MINUTES);

            if ($isToday && $start->lt($now)) {
                continue;
            }

            // Bloqueado por cierre/suspensión (traslape con el periodo)
            $closed = $closures->contains(function ($closure) use ($date, $start, $end) {
                $cStart = Carbon::parse($date . ' ' . $closure->start_time);
                $cEnd   = Carbon::parse($date . ' ' . $closure->end_time);

                return $start->lt($cEnd) && $end->gt($cStart);
            });

            if ($closed) {
                continue;
            }

            $key         = $start->format('H:i');
            $appointment = $booked->get($key);

            $slots[] = [
                'start'       => $key,
                'end'         => $end->format('H:i'),
                'available'   => $appointment === null,
                'appointment' => $appointment,
            ];
        }

        return $slots;
    }
}
