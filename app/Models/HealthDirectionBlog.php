<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthDirectionBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content_1',
        'content_2',
        'hero_img',
        'category',
        'is_fav',
        'published_at',
        'writer'
    ];

    public function images()
    {
        return $this->hasMany(HealthDirectionBlogImage::class, 'health_direction_blog_id');
    }
}
