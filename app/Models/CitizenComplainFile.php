<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenComplainFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function complain()
    {
        return $this->belongsTo(CitizenComplain::class, 'complain_id');
    }
}
