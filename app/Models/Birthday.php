<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Birthday extends Model
{
    protected $fillable = ['name', 'area', 'birthday_date'];

    protected $casts = [
        'birthday_date' => 'date',
    ];
}
