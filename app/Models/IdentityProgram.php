<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityProgram extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content_1',
        'content_2',
        'hero_img',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function images()
    {
        return $this->hasMany(IdentityProgramImage::class);
    }
}
