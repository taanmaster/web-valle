<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulatoryAgendaDependency extends Model
{
    use HasFactory;

    protected $table = 'regulatory_agenda_dependencies';
    protected $guarded = [];

    public function regulations()
    {
        return $this->hasMany(RegulatoryAgendaRegulation::class, 'dependency_id');
    }

    public function suggestions()
    {
        return $this->hasMany(RegulatoryAgendaSuggestion::class, 'dependency_id');
    }
}
