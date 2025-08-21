<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipalRegulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'regulation_type',
        'publication_type',
        'publication_date',
        'file',
        'pdf_file',
        'word_file',
    ];

    public function logs()
    {
        return $this->hasMany(MunicipalRegulationLog::class, 'regulation_id');
    }
}
