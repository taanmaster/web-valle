<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulatoryAgendaDependency extends Model
{
    use HasFactory;

    protected $table = 'regulatory_agenda_dependencies';
    protected $guarded = [];

    protected $casts = [
        'in_index' => 'boolean',
    ];

    public function regulations()
    {
        return $this->hasMany(RegulatoryAgendaRegulation::class, 'dependency_id');
    }

    public function simplifications()
    {
        return $this->hasMany(SimplificationAgenda::class, 'dependency_id');
    }
}
