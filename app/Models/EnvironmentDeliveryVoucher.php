<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentDeliveryVoucher extends Model
{
    use HasFactory;

    /**
     * Renglones que dibuja el mockup del vale de entrega de planta.
     */
    public const ITEM_ROWS = 6;

    protected $fillable = [
        'environment_request_id',
        'lugar_plantacion',
        'fecha_entrega',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
    ];

    public function environmentRequest()
    {
        return $this->belongsTo(EnvironmentRequest::class);
    }

    public function items()
    {
        return $this->hasMany(EnvironmentDeliveryVoucherItem::class);
    }
}
