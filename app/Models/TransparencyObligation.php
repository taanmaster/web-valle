<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyObligation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dependency()
    {
    	return $this->belongsTo(TransparencyDependency::class, 'dependency_id');
    }

    public function documents()
    {
        return $this->hasMany(TransparencyDocument::class, 'obligation_id');
    }
}
