<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsrAdminRevenueColletionSection extends Model
{
    use HasFactory;

    protected $table = 'tsr_admin_revenue_colletion_sections';
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(TsrAdminRevenueColletionArticle::class, 'section_id');
    }
}
