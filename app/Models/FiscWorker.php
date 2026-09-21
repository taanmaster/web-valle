<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        's3_asset_url',
        'filesize',
        'employee_number',
        'name',
        'last_name',
        'issue_date',
        'validity_date_start',
        'validity_date_end',
        'position',
        'email',
        'phone',
        'extension',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'validity_date_start' => 'date',
        'validity_date_end' => 'date',
    ];

    /**
     * Obtener el nombre completo del trabajador
     */
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name;
    }
}
