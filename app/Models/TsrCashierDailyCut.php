<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrCashierDailyCut extends Model
{
    use HasFactory;

    protected $fillable = [
        'cut_date',
        'cashier',
        'cashier_user',
        'total_cash',
        'denominations',
        'denominations_cashier',
        'denominations_payed',
    ];

    protected $casts = [
        'cut_date' => 'date',
        'denominations' => 'array',
    ];
}
