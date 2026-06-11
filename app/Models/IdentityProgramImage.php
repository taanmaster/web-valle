<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityProgramImage extends Model
{
    protected $fillable = [
        'identity_program_id',
        'image_path',
    ];

    public function program()
    {
        return $this->belongsTo(IdentityProgram::class, 'identity_program_id');
    }
}
