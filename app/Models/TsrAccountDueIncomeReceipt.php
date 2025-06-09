<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueIncomeReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_due_income_id',
        'cashier_user',
        'cashier',
        'qty_text',
        'qty_integer',
        'depositor',
        'total_cash',
        'denominations',
        'total_card',
        'total_check',
        'account',
        'total',
    ];

    public function income()
    {
        return $this->belongsTo(TsrAccountDueIncome::class, 'account_due_income_id');
    }
}
