<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dependency()
    {
    	return $this->belongsTo(TransparencyDependency::class, 'dependency_id');
    }
}
