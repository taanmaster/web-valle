<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueProvisionalInteger extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->belongsTo(TsrAccountDueProfile::class, 'account_due_profile_id');
    }

    public function incomes()
    {
        return $this->hasMany(TsrAccountDueIncome::class, 'provisional_integer_id');
    }
}
