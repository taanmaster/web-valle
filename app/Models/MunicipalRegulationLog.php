<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipalRegulationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'regulation_id',
        'action',
        'user_id',
    ];

    public function regulation()
    {
        return $this->belongsTo(MunicipalRegulation::class, 'regulation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
