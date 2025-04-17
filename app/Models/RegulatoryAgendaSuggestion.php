<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulatoryAgendaSuggestion extends Model
{
    use HasFactory;

    protected $table = 'regulatory_agenda_suggestions';
    protected $guarded = [];

    public function regulation()
    {
        return $this->belongsTo(RegulatoryAgendaRegulation::class, 'regulation_id');
    }
}
