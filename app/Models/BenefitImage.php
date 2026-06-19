<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitImage extends Model
{
    protected $fillable = [
        'benefit_id',
        'image_path',
    ];

    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }
}
