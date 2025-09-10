<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplanBlog extends Model
{
    use HasFactory;

    protected $guarded = [
        'title',
        'slug',
        'image',
        'type',
        'published_at',
    ];
}
