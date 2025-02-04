<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialSupportType extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function supports()
    {
        return $this->hasMany(FinancialSupport::class, 'type_id', 'id');
    }
}
