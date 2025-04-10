<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrRevenueLawIncome extends Model
{
    use HasFactory;

    protected $table = 'tsr_revenue_law_incomes';
    protected $guarded = [];

    public function concepts()
    {
        return $this->hasMany(TsrRevenueLawConcept::class, 'income_id');
    }
}
