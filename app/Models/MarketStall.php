<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketStall extends Model
{
    use HasFactory;

    public const LOCATIONS = ['Interior', 'Norte', 'Sur', 'Oriente', 'Poniente', 'Altos Sur'];

    public const BUSINESSES = [
        'Abarrotes', 'Aguacates', 'Aguas frescas', 'Antojitos', 'Birriería', 'Bisutería', 'Bodega', 'Cacahuates',
        'Camote', 'Carbón', 'Carnicería', 'Carnitas', 'Casetes', 'Cerrajería', 'Cinturones', 'Comida', 'Dulcería',
        'Dulcería/Jugos', 'Estambres', 'Fantasía', 'Floreria', 'Fonda', 'Fruta preparada', 'Frutas/Verduras', 'Frutería',
        'Fuente de sodas', 'Gorditas de trigo', 'Herramientas', 'Hierba', 'Jarcieria', 'Juegos de video', 'Jugos/Licuados',
        'Juguetes', 'Mariscos', 'Menudo', 'Mercería', 'Nopales', 'Óptica', 'Panadería', 'Pañales', 'Perfumes', 'Pescadería',
        'Pescado', 'Plantas medicinales', 'Plásticos', 'Plásticos/Jarcieria', 'Plásticos/Peltre', 'Pollería',
        'Puesto de huaraches (zapatos)', 'Refrescos', 'Relojería', 'Relojes', 'Revistas', 'Ropa', 'Ropa/Blancos', 'Rosticería',
        'Semillas', 'Semillas/Cereales', 'Tamales', 'Taquería', 'Tortillería', 'Tostadas', 'Varios', 'Verduras', 'Vísceras',
        'Yogurt', 'Zapatería',
    ];

    /**
     * Estatus de pago: clave => [etiqueta, color]
     * Por vencer: debe sólo el mes actual · Vencido: 1 mes atrasado · Moroso: 2 meses atrasados o más
     */
    public const PAYMENT_STATUSES = [
        'al_corriente' => ['Al corriente', 'success'],
        'por_vencer' => ['Por vencer', 'warning'],
        'vencido' => ['Vencido', 'orange'],
        'moroso' => ['Moroso', 'danger'],
        'baja' => ['Baja', 'secondary'],
    ];

    protected $fillable = [
        'number',
        'tenant_name',
        'phone',
        'space_type',
        'space_number',
        'aisle',
        'location',
        'business',
        'market_rate_id',
        'registered_at',
        'billing_start',
        'status',
        'deactivated_at',
        'deactivated_by',
    ];

    protected $casts = [
        'registered_at' => 'date',
        'billing_start' => 'date',
        'deactivated_at' => 'datetime',
    ];

    public static function nextNumber(): string
    {
        $last = static::orderByDesc('id')->value('number');
        $next = $last ? ((int) preg_replace('/\D/', '', $last)) + 1 : 1;

        return 'P-'.str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    public function rate()
    {
        return $this->belongsTo(MarketRate::class, 'market_rate_id');
    }

    public function tickets()
    {
        return $this->hasMany(MarketTicket::class);
    }

    public function activeTickets()
    {
        return $this->hasMany(MarketTicket::class)->whereNull('cancelled_at');
    }

    public function collectionNotes()
    {
        return $this->hasMany(MarketCollectionNote::class)->latest('date')->latest('id');
    }

    public function getSpaceTypeLabelAttribute()
    {
        return MarketRate::SPACE_TYPES[$this->space_type] ?? $this->space_type;
    }

    public function getSpaceLabelAttribute()
    {
        return $this->space_type_label.' '.$this->space_number;
    }

    /**
     * Meses que debe: desde que inicia su cobro hasta el mes actual, sin boleta vigente.
     * Requiere la relación activeTickets cargada (o la carga).
     */
    public function getUnpaidPeriodsAttribute(): array
    {
        if ($this->status === 'baja') {
            return [];
        }

        $paid = $this->activeTickets->map(fn ($t) => $t->period->format('Y-m'))->flip();
        $periods = [];
        $month = $this->billing_start->copy()->startOfMonth();
        $current = now()->startOfMonth();

        while ($month->lte($current)) {
            if (! $paid->has($month->format('Y-m'))) {
                $periods[] = $month->copy();
            }
            $month->addMonth();
        }

        return $periods;
    }

    public function getMonthsOwedAttribute(): int
    {
        return count($this->unpaid_periods);
    }

    public function getDebtAttribute(): float
    {
        return $this->months_owed * (float) $this->rate->monthly_amount;
    }

    public function getPaymentStatusAttribute(): string
    {
        if ($this->status === 'baja') {
            return 'baja';
        }

        $owed = $this->months_owed;

        return match (true) {
            $owed === 0 => 'al_corriente',
            $owed === 1 && $this->unpaid_periods[0]->isSameMonth(now()) => 'por_vencer',
            $owed <= 2 => 'vencido',
            default => 'moroso',
        };
    }

    public function getPaymentStatusLabelAttribute()
    {
        return self::PAYMENT_STATUSES[$this->payment_status][0];
    }

    public function getPaymentStatusColorAttribute()
    {
        return self::PAYMENT_STATUSES[$this->payment_status][1];
    }

    /**
     * Último mes pagado (para cartera)
     */
    public function getLastPaidPeriodAttribute(): ?Carbon
    {
        return $this->activeTickets->max('period');
    }

    /**
     * Otros espacios de la misma persona (mismo teléfono)
     */
    public function siblings()
    {
        return static::where('phone', $this->phone)->where('id', '!=', $this->id)->get();
    }
}
