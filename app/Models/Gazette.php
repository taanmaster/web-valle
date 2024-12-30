<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gazette extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(GazetteFile::class);
    }
}
