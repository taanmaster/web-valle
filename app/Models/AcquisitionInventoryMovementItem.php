<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcquisitionInventoryMovementItem extends Model
{
    protected $table = 'acquisition_inventory_movement_items';

    protected $fillable = [
        'movement_id',
        'material_id',
        'quantity',
    ];

    public function movement(): BelongsTo
    {
        return $this->belongsTo(AcquisitionInventoryMovement::class, 'movement_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(AcquisitionMaterial::class, 'material_id');
    }
}
