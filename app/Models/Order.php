<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'total'        => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'paid_at'      => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateFolio(): string
    {
        do {
            $folio = strtoupper(substr(uniqid(), -10));
        } while (static::where('folio', $folio)->exists());

        return $folio;
    }

    /**
     * Efectos posteriores a la confirmación del pago.
     * Por cada item con un trámite vinculado, si su modelo define
     * onOnlinePaymentCompleted(), lo invoca para que avance su estado
     * (ej. la Solicitud de Alta de Proveedor pasa a 'padron_activo').
     * Idempotente: cada trámite decide si aplica el cambio.
     */
    public function applyPaidSideEffects(): void
    {
        foreach ($this->items as $item) {
            if (!$item->related_model_type || !$item->related_model_id) {
                continue;
            }

            $class = $item->related_model_type;
            if (!class_exists($class)) {
                continue;
            }

            $model = $class::find($item->related_model_id);
            if ($model && method_exists($model, 'onOnlinePaymentCompleted')) {
                $model->onOnlinePaymentCompleted($this);
            }
        }
    }
}
