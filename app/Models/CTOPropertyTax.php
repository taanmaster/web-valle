<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CTOPropertyTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'c_t_o_property_id',
        'tax_year',
        'bimonthly_period',
        'cuota_type',
        'issue_date',
        'folio',
        'property_value',
        'bimonthly_payment',
        'tax_rate',
        'current_amount',
        'arrears_amount',
        'effects',
        'arrears_period',
        'current_period_amount',
        'total_arrears',
        'current_account',
        'property_tax_total',
        'discount',
        'surcharges',
        'surcharges_discount',
        'execution_expenses_discount',
        'total_payment',
        'total_payment_text',
        'bank_reference',
        'payment_status',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'tax_year' => 'integer',
        'bimonthly_period' => 'integer',
        'issue_date' => 'date',
        'property_value' => 'decimal:2',
        'bimonthly_payment' => 'decimal:2',
        'tax_rate' => 'decimal:4',
        'current_amount' => 'decimal:2',
        'arrears_amount' => 'decimal:2',
        'effects' => 'decimal:2',
        'current_period_amount' => 'decimal:2',
        'total_arrears' => 'decimal:2',
        'current_account' => 'decimal:2',
        'property_tax_total' => 'decimal:2',
        'discount' => 'decimal:2',
        'surcharges' => 'decimal:2',
        'surcharges_discount' => 'decimal:2',
        'execution_expenses_discount' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Obtener la propiedad a la que pertenece este recibo
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(CTOProperty::class, 'c_t_o_property_id');
    }

    /**
     * Scope para filtrar por año
     */
    public function scopeYear($query, int $year)
    {
        return $query->where('tax_year', $year);
    }

    /**
     * Scope para filtrar por bimestre
     */
    public function scopeBimonthly($query, int $period)
    {
        return $query->where('bimonthly_period', $period);
    }

    /**
     * Scope para obtener solo recibos pendientes
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pendiente');
    }

    /**
     * Scope para obtener solo recibos pagados
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'pagado');
    }

    /**
     * Scope para obtener solo recibos vencidos
     */
    public function scopeOverdue($query)
    {
        return $query->where('payment_status', 'vencido');
    }

    /**
     * Marcar el recibo como pagado
     */
    public function markAsPaid(): void
    {
        $this->update([
            'payment_status' => 'pagado',
            'payment_date' => now(),
        ]);
    }
}
