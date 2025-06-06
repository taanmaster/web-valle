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
        'address',
        'message',
        'subject',
    ];

    public function files()
    {
        return $this->hasMany(CitizenComplainFile::class, 'complain_id');
    }
}
