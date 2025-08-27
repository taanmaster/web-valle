<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFSocioEconomicTest extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_socio_economic_tests';

    protected $fillable = [
        'coordination_id',
        'citizen_id',
        'citizen_name',
        'citizen_last_name',
        'citizen_curp',
        'citizen_phone',
        'citizen_address',
        'status',
        'current_step',
        'can_go_back',
        'step_1_answers',
        'step_2_answers',
        'step_3_answers',
        'step_4_answers',
        'step_5_answers',
        'step_1_score',
        'step_2_score',
        'step_3_score',
        'step_4_score',
        'step_5_score',
        'total_score',
        'vulnerability_level',
        'recommended_support_type',
        'recommended_amount',
        'created_by',
        'approved_by',
        'approved_at',
        'notes'
    ];

    protected $casts = [
        'step_1_answers' => 'array',
        'step_2_answers' => 'array',
        'step_3_answers' => 'array',
        'step_4_answers' => 'array',
        'step_5_answers' => 'array',
        'can_go_back' => 'boolean',
        'approved_at' => 'datetime',
        'recommended_amount' => 'decimal:2'
    ];

    // Relaciones
    public function coordination()
    {
        return $this->belongsTo(DIFCoordination::class, 'coordination_id');
    }

    public function user()
    {
        return $this->belongsTo(CitizenMedicalProfile::class, 'citizen_id');
    }

    public function dependents()
    {
        return $this->hasMany(DIFSocioEconomicTestDependent::class, 'socio_economic_test_id');
    }

    public function files()
    {
        return $this->hasMany(DIFSocioEconomicTestFile::class, 'socio_economic_test_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Métodos de cálculo
    public function calculateTotalScore()
    {
        return ($this->step_1_score ?? 0) + 
               ($this->step_2_score ?? 0) + 
               ($this->step_3_score ?? 0) + 
               ($this->step_4_score ?? 0) + 
               ($this->step_5_score ?? 0);
    }

    public function getVulnerabilityLevel()
    {
        $total = $this->calculateTotalScore();
        
        if ($total >= 63) {
            return 'high_vulnerability';
        } elseif ($total >= 48 && $total <= 62) {
            return 'medium_vulnerability';
        } elseif ($total >= 31 && $total <= 47) {
            return 'low_vulnerability';
        } elseif ($total >= 25 && $total <= 30) {
            return 'no_assistance';
        } else {
            return 'unclassified';
        }
    }

    public function getVulnerabilityLevelText()
    {
        $level = $this->getVulnerabilityLevel();
        
        switch ($level) {
            case 'high_vulnerability':
                return 'ALTA VULNERABILIDAD';
            case 'medium_vulnerability':
                return 'MEDIA VULNERABILIDAD';
            case 'low_vulnerability':
                return 'BAJA VULNERABILIDAD';
            case 'no_assistance':
                return 'NO SUJETO A ASISTENCIA SOCIAL';
            default:
                return 'Sin clasificar';
        }
    }

    public function getRecommendedSupport()
    {
        $level = $this->getVulnerabilityLevel();
        
        switch ($level) {
            case 'no_assistance':
                return [
                    'type' => 'Ninguno',
                    'amount' => 0,
                    'description' => 'No califica para asistencia social'
                ];
            case 'low_vulnerability':
                return [
                    'type' => 'Apoyo básico',
                    'amount' => 1500,
                    'description' => 'Apoyo económico mensual de nivel básico'
                ];
            case 'medium_vulnerability':
                return [
                    'type' => 'Apoyo moderado',
                    'amount' => 3000,
                    'description' => 'Apoyo económico mensual de nivel moderado'
                ];
            case 'high_vulnerability':
                return [
                    'type' => 'Apoyo prioritario',
                    'amount' => 5000,
                    'description' => 'Apoyo económico mensual de nivel prioritario'
                ];
            default:
                return [
                    'type' => 'Por determinar',
                    'amount' => 0,
                    'description' => 'Requiere evaluación adicional'
                ];
        }
    }

    // Métodos de utilidad
    public function canAdvanceToStep($step)
    {
        return $this->current_step >= $step - 1;
    }

    public function isStepCompleted($step)
    {
        $answersField = "step_{$step}_answers";
        return !empty($this->$answersField);
    }

    public function getProgressPercentage()
    {
        return ($this->current_step / 5) * 100;
    }
}
