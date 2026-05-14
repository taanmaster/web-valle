<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralBlog extends Model
{
    use HasFactory;

    protected $table = 'general_blogs';

    protected $fillable = [
        'type',
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
        return $this->hasMany(GeneralBlogImage::class, 'general_blog_id');
    }
}
