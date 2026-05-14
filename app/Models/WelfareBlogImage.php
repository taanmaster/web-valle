<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WelfareBlogImage extends Model
{
    use HasFactory;

    protected $table = 'welfare_blog_images';

    protected $guarded = [];

    public function welfareBlog()
    {
        return $this->belongsTo(WelfareBlog::class, 'welfare_blog_id');
    }
}
