<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\HRApplication;

class HRVacancy extends Model
{
    protected $table = 'hr_vacancies';

    protected $fillable = [
        'status',
        'published_at',
        'position_name',
        'dependency',
        'employment_type',
        'work_schedule',
        'location',
        'description',
        'requirements',
        'closing_date',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'closing_date' => 'datetime',
    ];

    public function applications()
    {
        return $this->hasMany(HRApplication::class, 'hr_vacancy_id');
    }

    /**
     * Computed status based on dates:
     * - Programada: published_at is in the future
     * - Abierta: published_at is in the past and closing_date is in the future (or null)
     * - Cerrada: closing_date is in the past
     */
    public function getComputedStatusAttribute()
    {
        $now = Carbon::now();

        if ($this->published_at && $this->published_at->gt($now)) {
            return 'Programada';
        }

        if ($this->closing_date && $this->closing_date->lt($now)) {
            return 'Cerrada';
        }

        return 'Abierta';
    }
}
