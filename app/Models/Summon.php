<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }

    public function followups()
    {
        return $this->hasMany(SummonFollowup::class);
    }
}
