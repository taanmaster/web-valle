<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilProtectionInspection extends Model
{
    use HasFactory;

    public const RESULTS = [
        'pendiente' => ['Pendiente de registrar', 'primary'],
        'sin_observaciones' => ['Sin observaciones', 'success'],
        'con_observaciones' => ['Con observaciones', 'warning'],
        'no_procede' => ['No procede', 'danger'],
        'no_realizada' => ['No realizada', 'secondary'],
    ];

    protected $fillable = [
        'civil_protection_case_id',
        'inspector_id',
        'scheduled_by',
        'scheduled_at',
        'note_to_citizen',
        'result',
        'visit_date',
        'observations',
        'photos',
        'act_name',
        'act_s3_url',
        'registered_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'visit_date' => 'date',
        'photos' => 'array',
        'registered_at' => 'datetime',
    ];

    public function case()
    {
        return $this->belongsTo(CivilProtectionCase::class, 'civil_protection_case_id');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function getResultLabelAttribute()
    {
        return self::RESULTS[$this->result][0] ?? $this->result;
    }

    public function getResultColorAttribute()
    {
        return self::RESULTS[$this->result][1] ?? 'secondary';
    }
}
