<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketTicket extends Model
{
    use HasFactory;

    /**
     * Folios por serie: al terminar una serie inicia la siguiente letra
     */
    public const FOLIOS_PER_SERIES = 1000;

    /**
     * Etapas de la boleta (se derivan de sus datos): clave => [etiqueta, color]
     */
    public const STAGES = [
        'por_cortar' => ['Pagada · por cortar', 'primary'],
        'en_tesoreria' => ['En Tesorería · sin recibo', 'warning'],
        'recibo_listo' => ['Recibo listo · por entregar', 'info'],
        'entregado' => ['Entregado', 'success'],
        'cancelada' => ['Cancelada', 'secondary'],
    ];

    protected $fillable = [
        'series', 'folio', 'market_stall_id', 'period', 'amount',
        'fiscal_year', 'article', 'subsection', 'fraction', 'issued_by',
        'cancelled_at', 'cancelled_by', 'cancel_reason',
        'market_cut_id',
        'receipt_name', 'receipt_s3_url', 'receipt_attached_at', 'receipt_attached_by',
        'delivered_at', 'delivered_to', 'delivery_proof_s3_url', 'delivery_notes', 'delivered_by',
    ];

    protected $casts = [
        'period' => 'date',
        'amount' => 'decimal:2',
        'cancelled_at' => 'datetime',
        'receipt_attached_at' => 'datetime',
        'delivered_at' => 'date',
    ];

    /**
     * Siguiente [serie, folio]: A-00001 … A-01000, luego B-00001
     */
    public static function nextFolio(): array
    {
        $last = static::orderByDesc('id')->first(['series', 'folio']);

        if (! $last) {
            return ['A', 1];
        }

        return $last->folio >= self::FOLIOS_PER_SERIES
            ? [chr(ord($last->series) + 1), 1]
            : [$last->series, $last->folio + 1];
    }

    public static function formatFolio(string $series, int $folio): string
    {
        return $series.'-'.str_pad($folio, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Importe con letra: CIENTO CINCUENTA Y UN PESOS 00/100 M.N.
     */
    public static function amountInWords($amount): string
    {
        $pesos = (int) floor($amount);
        $cents = (int) round(($amount - $pesos) * 100);

        if (! class_exists(\NumberFormatter::class)) {
            return number_format($amount, 2).' M.N.';
        }

        $words = (new \NumberFormatter('es', \NumberFormatter::SPELLOUT))->format($pesos);
        $words = preg_replace('/uno$/', 'un', $words);

        return mb_strtoupper($words).' '.($pesos === 1 ? 'PESO' : 'PESOS').' '.str_pad($cents, 2, '0', STR_PAD_LEFT).'/100 M.N.';
    }

    public function stall()
    {
        return $this->belongsTo(MarketStall::class, 'market_stall_id');
    }

    public function cut()
    {
        return $this->belongsTo(MarketCut::class, 'market_cut_id');
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function canceller()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function deliverer()
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('cancelled_at');
    }

    public function scopeStage($query, string $stage)
    {
        return match ($stage) {
            'cancelada' => $query->whereNotNull('cancelled_at'),
            'por_cortar' => $query->active()->whereNull('market_cut_id'),
            'en_tesoreria' => $query->active()->whereNotNull('market_cut_id')->whereNull('receipt_s3_url'),
            'recibo_listo' => $query->active()->whereNotNull('receipt_s3_url')->whereNull('delivered_at'),
            'entregado' => $query->active()->whereNotNull('delivered_at'),
            default => $query,
        };
    }

    public function getFolioLabelAttribute(): string
    {
        return self::formatFolio($this->series, $this->folio);
    }

    public function getStageAttribute(): string
    {
        return match (true) {
            (bool) $this->cancelled_at => 'cancelada',
            ! $this->market_cut_id => 'por_cortar',
            ! $this->receipt_s3_url => 'en_tesoreria',
            ! $this->delivered_at => 'recibo_listo',
            default => 'entregado',
        };
    }

    public function getStageLabelAttribute()
    {
        return self::STAGES[$this->stage][0];
    }

    public function getStageColorAttribute()
    {
        return self::STAGES[$this->stage][1];
    }

    public function getPeriodLabelAttribute(): string
    {
        return ucfirst($this->period->translatedFormat('F Y'));
    }

    /**
     * Sólo se cancela antes de entrar a un corte (después el dinero ya está en Tesorería)
     */
    public function getCanCancelAttribute(): bool
    {
        return ! $this->cancelled_at && ! $this->market_cut_id;
    }

    /**
     * Historial derivado de las fechas de la boleta, del más reciente al más antiguo
     */
    public function getHistoryAttribute(): array
    {
        $events = [['Boleta emitida e impresa (3 tantos)', $this->created_at, $this->issuer?->name]];

        if ($this->cancelled_at) {
            $events[] = ['Boleta cancelada · Motivo: '.$this->cancel_reason, $this->cancelled_at, $this->canceller?->name];
        }
        if ($this->cut) {
            $events[] = ['Incluida en el corte del '.$this->cut->cut_date->format('d/m/Y').' · entregado a Tesorería', $this->cut->created_at, $this->cut->creator?->name];
        }
        if ($this->receipt_attached_at) {
            $events[] = ['Recibo de Tesorería adjuntado · '.$this->receipt_name, $this->receipt_attached_at, null];
        }
        if ($this->delivered_at) {
            $events[] = ['Recibo entregado a '.$this->delivered_to, $this->delivered_at, $this->deliverer?->name];
        }

        return array_reverse($events);
    }
}
