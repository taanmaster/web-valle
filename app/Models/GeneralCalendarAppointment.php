<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralCalendarAppointment extends Model
{
    protected $fillable = [
        'folio',
        'general_calendar_procedure_id',
        'date',
        'start_time',
        'end_time',
        'full_name',
        'email',
        'phone',
        'approval_id',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function procedure()
    {
        return $this->belongsTo(GeneralCalendarProcedure::class, 'general_calendar_procedure_id');
    }

    /**
     * Folio único: CG + año + secuencial de 4 dígitos (CG20260001)
     */
    public static function generateFolio(): string
    {
        $year = date('Y');

        $last = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $next = $last ? intval(substr($last->folio, -4)) + 1 : 1;

        return 'CG' . $year . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
