<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date_start',
        'date_end',
        'location',
        'blog_url',
        'is_active',
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Opciones del selector de hora: día completo en tramos de 30 minutos
     * (12:00 AM – 11:30 PM), tal como pide la spec del calendario.
     */
    public static function timeOptions(): array
    {
        $options = [];

        for ($minutes = 0; $minutes < 1440; $minutes += 30) {
            $time = Carbon::createFromTime(intdiv($minutes, 60), $minutes % 60);
            $options[$time->format('H:i')] = $time->format('g:i A');
        }

        return $options;
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->date_start?->format('d/m/Y H:i');
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->date_end?->format('d/m/Y H:i');
    }
}
