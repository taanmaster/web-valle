<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueIncomeReceipt extends Model
{
    use HasFactory;

    public function income()
    {
        return $this->belongsTo(TsrAccountDueIncome::class, 'account_due_income_id');
    }
}
