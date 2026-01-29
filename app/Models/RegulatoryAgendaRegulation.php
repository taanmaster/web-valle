<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulatoryAgendaRegulation extends Model
{
    use HasFactory;

    protected $table = 'regulatory_agenda_regulations';
    protected $guarded = [];

    public function dependency()
    {
        return $this->belongsTo(RegulatoryAgendaDependency::class, 'dependency_id');
    }

    public function suggestions()
    {
        return $this->hasMany(RegulatoryAgendaSuggestion::class, 'regulation_id');
    }
}
