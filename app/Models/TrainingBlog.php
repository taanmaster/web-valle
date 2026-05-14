<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingBlog extends Model
{
    use HasFactory;

    protected $table = 'training_blogs';

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
        return $this->hasMany(TrainingBlogImage::class, 'training_blog_id');
    }
}
