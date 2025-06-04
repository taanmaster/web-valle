<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueIncome extends Model
{
    use HasFactory;

    public function provisionalInteger()
    {
        return $this->belongsTo(TsrAccountDueProvisionalInteger::class, 'provisional_integer_id');
    }

    public function receipt()
    {
        return $this->hasOne(TsrAccountDueIncomeReceipt::class, 'account_due_income_id');
    }
}
