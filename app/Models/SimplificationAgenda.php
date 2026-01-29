<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimplificationAgenda extends Model
{
    use HasFactory;

    protected $table = 'simplification_agendas';
    protected $guarded = [];

    protected $casts = [
        'high_frequency' => 'boolean',
        'priority_grupos' => 'boolean',
        'high_burocratic_cost' => 'boolean',
        'in_person' => 'boolean',
        'air_commitment' => 'boolean',
        'others' => 'boolean',
        'is_active' => 'boolean',
        'date_start' => 'date',
        'end_date' => 'date',
    ];

    public function dependency()
    {
        return $this->belongsTo(RegulatoryAgendaDependency::class, 'dependency_id');
    }

    public function suggestions()
    {
        return $this->hasMany(SimplificationAgendaSuggestion::class, 'simplification_id');
    }
}
