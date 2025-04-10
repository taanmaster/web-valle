<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAdminRevenueColletionClause extends Model
{
    use HasFactory;

    protected $table = 'tsr_admin_revenue_colletion_clauses';
    protected $guarded = [];

    public function fraction()
    {
        return $this->belongsTo(TsrAdminRevenueColletionFraction::class, 'fraction_id');
    }

    public function variants()
    {
        return $this->hasMany(TsrAdminRevenueColletionVariant::class, 'clause_id');
    }
}
