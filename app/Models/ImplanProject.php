<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplanProject extends Model
{
    use HasFactory;

    protected $guarded = [
        'title',
        'slug',
        'description',
        'image',
        'file',
        'published_at',
        'is_active',
    ];
}
