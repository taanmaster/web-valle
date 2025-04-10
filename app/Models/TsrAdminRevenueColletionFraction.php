<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAdminRevenueColletionFraction extends Model
{
    use HasFactory;

    protected $table = 'tsr_admin_revenue_colletion_fractions';
    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo(TsrAdminRevenueColletionArticle::class, 'article_id');
    }


    public function clauses()
    {
        return $this->hasMany(TsrAdminRevenueColletionClause::class, 'fraction_id');
    }
}
