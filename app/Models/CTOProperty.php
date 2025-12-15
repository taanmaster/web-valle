<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CTOProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'taxpayer_type',
        'taxpayer_name',
        'taxpayer_phone',
        'street',
        'street_num',
        'int_num',
        'suburb',
        'cuota_type',
        'location_account',
        'location_type',
        'location_num',
        'location_note',
        'location_origin',
        'location_surface',
        'location_use',
        'location_law_value',
        'location_surface_built',
        'location_condition',
        'last_appraisal',
        'payment_anual',
        'payment_bimonthly',
        'tax_rate',
        'total_payment',
        'issue_date',
        'validity_date',
        'payment_date',
        'bank_reference_json',
        'notification_address',
        'notes',
    ];

    protected $casts = [
        'location_surface' => 'decimal:2',
        'location_law_value' => 'decimal:2',
        'location_surface_built' => 'decimal:2',
        'payment_anual' => 'decimal:2',
        'payment_bimonthly' => 'decimal:2',
        'tax_rate' => 'decimal:4',
        'total_payment' => 'decimal:2',
        'last_appraisal' => 'date',
        'issue_date' => 'date',
        'validity_date' => 'date',
        'payment_date' => 'date',
        'bank_reference_json' => 'array',
    ];

    /**
     * Obtener todos los recibos de impuestos de esta propiedad
     */
    public function propertyTaxes(): HasMany
    {
        return $this->hasMany(CTOPropertyTax::class);
    }

    /**
     * Obtener los recibos pendientes de pago
     */
    public function pendingTaxes(): HasMany
    {
        return $this->hasMany(CTOPropertyTax::class)
            ->where('payment_status', 'pendiente');
    }

    /**
     * Obtener los recibos de un año específico
     */
    public function taxesByYear(int $year): HasMany
    {
        return $this->hasMany(CTOPropertyTax::class)
            ->where('tax_year', $year);
    }
}
