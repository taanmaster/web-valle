<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsBlog extends Model
{
    use HasFactory;

    protected $table = 'events_blogs';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content_1',
        'content_2',
        'hero_img',
        'published_at',
        'is_active',
    ];

    public function images()
    {
        return $this->hasMany(EventsBlogImage::class, 'events_blog_id');
    }
}
