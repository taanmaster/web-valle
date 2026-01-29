<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimplificationAgendaSuggestion extends Model
{
    use HasFactory;

    protected $table = 'simplification_agenda_suggestions';
    protected $guarded = [];

    public function simplification()
    {
        return $this->belongsTo(SimplificationAgenda::class, 'simplification_id');
    }
}
