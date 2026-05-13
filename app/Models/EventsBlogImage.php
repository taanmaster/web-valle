<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsBlogImage extends Model
{
    use HasFactory;

    protected $table = 'events_blog_images';

    protected $guarded = [];

    public function eventsBlog()
    {
        return $this->belongsTo(EventsBlog::class, 'events_blog_id');
    }
}
