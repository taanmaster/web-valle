<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DIFMedicationVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_id',
        'name',
        'sku',
        'price',
        'type',
        'type_num',
        'type_dosage',
        'use_type',
        'attributes_json',
    ];
    
    protected $casts = [
        'attributes_json' => 'array',
    ];

    public function medication()
    {
        return $this->belongsTo(DIFMedication::class, 'medication_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(DIFStockMovement::class, 'variant_id');
    }

    /**
     * Obtener el stock actual de la variante
     */
    public function getCurrentStock()
    {
        $inbound = $this->stockMovements()->where('movement_type', 'inbound')->sum('quantity');
        $outbound = $this->stockMovements()->where('movement_type', 'outbound')->sum('quantity');
        
        return $inbound - $outbound;
    }

    /**
     * Obtener el estado del inventario
     */
    public function getStockStatus()
    {
        $currentStock = $this->getCurrentStock();
        
        if ($currentStock <= 0) {
            return [
                'status' => 'agotado',
                'badge_class' => 'bg-danger',
                'label' => 'Agotado'
            ];
        } elseif ($currentStock <= 3) {
            return [
                'status' => 'resurtir',
                'badge_class' => 'bg-warning text-dark',
                'label' => 'Resurtir Pronto'
            ];
        } else {
            return [
                'status' => 'disponible',
                'badge_class' => 'bg-success',
                'label' => 'Disponible'
            ];
        }
    }

    /**
     * Scope para filtrar por estado de inventario
     */
    public function scopeWithStockStatus($query, $status = null)
    {
        return $query->with(['stockMovements', 'medication']);
    }
}
