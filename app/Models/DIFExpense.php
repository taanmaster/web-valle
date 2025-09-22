<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'ammount',
        'recipient',
        'concept',
        'value',
    ];
}
