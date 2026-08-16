<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentDeliveryVoucherItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'environment_delivery_voucher_id',
        'especie',
        'cantidad',
    ];

    public function voucher()
    {
        return $this->belongsTo(EnvironmentDeliveryVoucher::class, 'environment_delivery_voucher_id');
    }
}
