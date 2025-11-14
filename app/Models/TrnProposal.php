<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'filename',
        'filepath',
        'file_type',
        'filesize',
        'in_index',
    ];

    protected $casts = [
        'in_index' => 'boolean',
        'filesize' => 'integer',
    ];
}
