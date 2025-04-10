<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAdminRevenueColletionArticle extends Model
{
    use HasFactory;

    protected $table = 'tsr_admin_revenue_colletion_articles';
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(TsrAdminRevenueColletionSection::class, 'section_id');
    }

    public function fractions()
    {
        return $this->hasMany(TsrAdminRevenueColletionFraction::class, 'article_id');
    }
}
