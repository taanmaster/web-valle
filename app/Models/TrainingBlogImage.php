<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingBlogImage extends Model
{
    use HasFactory;

    protected $table = 'training_blog_images';

    protected $guarded = [];

    public function trainingBlog()
    {
        return $this->belongsTo(TrainingBlog::class, 'training_blog_id');
    }
}
