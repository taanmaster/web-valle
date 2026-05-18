<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralBlogImage extends Model
{
    use HasFactory;

    protected $table = 'general_blog_images';

    protected $fillable = [
        'general_blog_id',
        'image_path',
    ];

    public function blog()
    {
        return $this->belongsTo(GeneralBlog::class, 'general_blog_id');
    }
}
