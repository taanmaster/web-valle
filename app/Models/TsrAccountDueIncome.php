<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAccountDueIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'department',
        'concept',
        'folio',
        'provisional_integer_id',
        'qty_text',
        'qty_integer',
        'name',
        'type_of_person',
        'rfc_curp',
        'address',
        'zipcode',
        'code',
        'observations',
        'work',
        'locality',
        'basis'
    ];

    public function integer()
    {
        return $this->belongsTo(TsrAccountDueProvisionalInteger::class, 'provisional_integer_id');
    }

    public function receipt()
    {
        return $this->hasOne(TsrAccountDueIncomeReceipt::class, 'account_due_income_id');
    }
}
