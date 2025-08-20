<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFDoctorConsult extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_doctor_consults';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'consult_num',
        'consult_date',
        'consult_description',
        'consult_type_id',
        'status'
    ];

    protected $casts = [
        'consult_date' => 'date',
        'doctor_id' => 'integer',
        'patient_id' => 'integer',
        'consult_type_id' => 'integer',
    ];

    public function doctor()
    {
        return $this->belongsTo(DIFDoctor::class, 'doctor_id');
    }

    public function consultType()
    {
        return $this->belongsTo(DIFConsultType::class, 'consult_type_id');
    }

    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'patient_id');
    }

    // Accesor para obtener el nombre del estado
    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'Pendiente',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada'
        ];

        return $statuses[$this->status] ?? 'Desconocido';
    }

    // Accesor para obtener el badge del estado
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-warning',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger'
        ];

        return $badges[$this->status] ?? 'bg-secondary';
    }
}
