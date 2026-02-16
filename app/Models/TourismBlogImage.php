<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourismBlogImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function blog()
    {
        return $this->belongsTo(TourismBlog::class, 'tourism_blog_id');
    }
}
