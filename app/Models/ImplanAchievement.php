<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplanAchievement extends Model
{
    use HasFactory;

    protected $guarded = [
        'title',
        'description',
        'hex',
        'image',
        'file',
        'published_at',
        'is_active',
    ];
}
