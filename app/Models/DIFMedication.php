<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFMedication extends Model
{
    use HasFactory;

    protected $table = 'd_i_f_medications';

    protected $fillable = [
        'generic_name',
        'commercial_name',
        'description',
        'formula',
        'type',
        'type_num',
        'type_dosage',
        'use_type',
        'is_active',
    ];

    public function variants()
    {
        return $this->hasMany(DIFMedicationVariant::class, 'medication_id');
    }

    /**
     * Obtener el total de existencias de todas las variantes
     */
    public function getTotalStock()
    {
        return $this->variants->sum(function($variant) {
            return $variant->getCurrentStock();
        });
    }

    /**
     * Obtener el conteo de variantes
     */
    public function getVariantsCount()
    {
        return $this->variants->count();
    }

    /**
     * Obtener el estado general del inventario del medicamento
     */
    public function getOverallStockStatus()
    {
        $totalStock = $this->getTotalStock();
        
        if ($totalStock <= 0) {
            return [
                'status' => 'agotado',
                'badge_class' => 'bg-danger',
                'label' => 'Sin Stock'
            ];
        } elseif ($totalStock <= 10) {
            return [
                'status' => 'bajo',
                'badge_class' => 'bg-warning text-dark',
                'label' => 'Stock Bajo'
            ];
        } else {
            return [
                'status' => 'disponible',
                'badge_class' => 'bg-success',
                'label' => 'Disponible'
            ];
        }
    }
}
