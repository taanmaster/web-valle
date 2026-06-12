<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralCalendarClosure extends Model
{
    protected $fillable = [
        'general_calendar_procedure_id',
        'date',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function procedure()
    {
        return $this->belongsTo(GeneralCalendarProcedure::class, 'general_calendar_procedure_id');
    }
}
