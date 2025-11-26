<?php

namespace App\Services;

use App\Models\AcquisitionMaterial;
use App\Models\AcquisitionInventoryMovement;

class InventoryService
{
    public function applyToStock(AcquisitionInventoryMovement $movement)
    {
        $material = $movement->material;

        $current = $material->current_stock;

        $newStock = $movement->type === 'Entrada'
            ? $current + $movement->quantity
            : $current - $movement->quantity;

        // Actualizar existencias
        $material->update(['current_stock' => $newStock]);
    }
}
