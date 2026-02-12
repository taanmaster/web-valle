<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourismBlog extends Model
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
        return $this->hasMany(TourismBlogImage::class, 'tourism_blog_id');
    }
}
