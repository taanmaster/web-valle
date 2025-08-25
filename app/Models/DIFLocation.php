<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFLocation extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_locations';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'street_name',
        'street_num',
        'zip_code',
        'colony',
        'phone',
        'email',
        'type',
    ];
}
