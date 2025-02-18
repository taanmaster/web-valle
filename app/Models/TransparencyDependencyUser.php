<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyDependencyUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dependency()
    {
    	return $this->belongsTo(TransparencyDependency::class, 'dependency_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
