<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GazetteFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function gazette()
    {
    	return $this->belongsTo(Gazette::class, 'gazette_id');
    }

    public function uploader()
    {
    	return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}