<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummonFollowup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function summon()
    {
        return $this->belongsTo(Summon::class);
    }
}
