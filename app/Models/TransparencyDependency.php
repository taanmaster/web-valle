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
        return $this->hasMany(TransparencyFile::class);
    }

    public function obligations()
    {
        return $this->hasMany(TransparencyObligation::class);
    }
}
