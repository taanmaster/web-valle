<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenComplain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'status',
        'response',
        'response_date',
        'created_at',
        'updated_at'
    ];

    public function files()
    {
        return $this->hasMany(CitizenComplainFile::class, 'complain_id');
    }
}
