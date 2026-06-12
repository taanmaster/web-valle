<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralCalendarBlock extends Model
{
    protected $fillable = [
        'general_calendar_procedure_id',
        'day_of_week',
        'start_time',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
    ];

    public function procedure()
    {
        return $this->belongsTo(GeneralCalendarProcedure::class, 'general_calendar_procedure_id');
    }
}
