<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAdminRevenueColletionVariant extends Model
{
    use HasFactory;

    protected $table = 'tsr_admin_revenue_colletion_variants';
    protected $guarded = [];

    public function clause()
    {
        return $this->belongsTo(TsrAdminRevenueColletionClause::class, 'clause_id');
    }
}
