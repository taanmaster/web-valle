<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyDependency extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(TransparencyFile::class, 'dependency_id');
    }

    public function obligations()
    {
        return $this->hasMany(TransparencyObligation::class, 'dependency_id');
    }

    public function users()
    {
        return $this->hasMany(TransparencyDependencyUser::class, 'dependency_id');
    }
}
