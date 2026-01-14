<?php

namespace App\Services;

use App\Models\AcquisitionMaterial;
use App\Models\AcquisitionInventoryMovement;
use App\Models\AcquisitionInventoryMovementItem;

class InventoryService
{
    public function applyToStock(AcquisitionInventoryMovementItem $movement)
    {
        $material = $movement->material;

        $current = $material->current_stock;

        $type = $movement->movement->type;

        $newStock = $type === 'Entrada'
            ? $current + $movement->quantity
            : $current - $movement->quantity;

        // Actualizar existencias
        $material->update(['current_stock' => $newStock]);
    }
}
