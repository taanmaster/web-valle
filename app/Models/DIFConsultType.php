<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFConsultType extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_consult_types';

    protected $fillable = [
        'name',
        'description',
    ];
}
