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
     * Obtener lotes (entradas) disponibles para esta variante.
     * Devuelve un array de arrays con keys: parent_id, expiration_date (Carbon|null), available_qty
     */
    public function getBatches()
    {
        $entries = $this->stockMovements()->where('movement_type', 'inbound')->orderBy('expiration_date', 'asc')->get();

        $batches = [];

        foreach ($entries as $entry) {
            $consumed = $entry->children()->sum('quantity');
            $available = $entry->quantity - $consumed;

            if ($available > 0) {
                $batches[] = [
                    'parent_id' => $entry->id,
                    'expiration_date' => $entry->expiration_date,
                    'available_qty' => $available,
                ];
            }
        }

        return $batches;
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
