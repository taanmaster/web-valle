<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFService extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_services';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
