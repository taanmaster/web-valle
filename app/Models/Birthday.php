<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Birthday extends Model
{
    public const MONTHS = [
        1  => 'Enero',
        2  => 'Febrero',
        3  => 'Marzo',
        4  => 'Abril',
        5  => 'Mayo',
        6  => 'Junio',
        7  => 'Julio',
        8  => 'Agosto',
        9  => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    protected $fillable = [
        'month',
        'photo',
    ];

    public function getMonthNameAttribute(): string
    {
        return self::MONTHS[$this->month] ?? '';
    }
}
