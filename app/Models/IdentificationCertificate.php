<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentificationCertificate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment()
    {
        return $this->hasOne(IdentificationCertificatePayment::class, 'certificate_id');
    }

    /**
     * Efecto al confirmarse el pago en línea de la constancia.
     * Lo invoca Order::applyPaidSideEffects() cuando la orden vinculada queda "Pagado".
     * Avanza la constancia de 'Pago pendiente' a 'Pago recibido'.
     */
    public function onOnlinePaymentCompleted(Order $order): void
    {
        if ($this->status === 'Pago pendiente') {
            $this->update(['status' => 'Pago recibido']);
        }
    }
}
