<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrRevenueLawConcept extends Model
{
    use HasFactory;

    protected $table = 'tsr_revenue_law_concepts';
    protected $guarded = [];

    public function income()
    {
        return $this->belongsTo(TsrRevenueLawIncome::class, 'income_id');
    }
}
