<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilProtectionCaseLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'civil_protection_case_id',
        'user_id',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        [$number, $label] = CivilProtectionCase::STATUSES[$this->status] ?? [null, $this->status];

        return ($number ? $number.'. ' : '').$label;
    }

    public function getStatusColorAttribute()
    {
        return CivilProtectionCase::STATUSES[$this->status][2] ?? 'secondary';
    }
}
