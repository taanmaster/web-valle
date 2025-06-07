<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueProvisionalInteger extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_due_profile_id',
        'dependency_name',
        'qty_text',
        'qty_integer',
        'name',
        'address',
        'zipcode',
        'basis',
        'concept',
        'payment_method',
        'created_by',
        'director',
    ];

    public function profile()
    {
        return $this->belongsTo(TsrAccountDueProfile::class, 'account_due_profile_id');
    }

    public function incomes()
    {
        return $this->hasMany(TsrAccountDueIncome::class, 'provisional_integer_id');
    }
}
