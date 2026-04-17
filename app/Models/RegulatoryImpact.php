<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RegulatoryImpact extends Model
{
    use HasFactory;

    const TYPE_AIR      = 'air';
    const TYPE_EXENCION = 'exencion';

    const DICTAMEN_PENDIENTE = 'pendiente';
    const DICTAMEN_RECHAZADO = 'rechazado';
    const DICTAMEN_APROBADO  = 'aprobado';

    protected $fillable = [
        'folio',
        'type',
        'dependency_id',
        'user_id',
        'show_in_front',
        'dictamen_status',
        'dictamen_file',
        'dictamen_s3_url',
        'formato_solicitud',
        'formato_solicitud_s3_url',
        // AIR
        'nombre_propuesta',
        'fecha_vigencia',
        'autoridad_emisora',
        'objeto_programa',
        'tipo_ordenamiento',
        'materias_reguladas',
        'sectores_regulados',
        'sujetos_regulados',
        'indice_regulacion',
        'tramites_relacionados',
        // Exención
        'titulo_regulacion',
        'nombre_cargo',
        'fecha_envio',
    ];

    protected $casts = [
        'show_in_front' => 'boolean',
        'fecha_vigencia' => 'date',
        'fecha_envio'    => 'date',
    ];

    // ---------- Relaciones ----------

    public function dependency()
    {
        return $this->belongsTo(BackofficeDependency::class, 'dependency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(RegulatoryImpactComment::class);
    }

    // ---------- Scopes ----------

    public function scopeAir($query)
    {
        return $query->where('type', self::TYPE_AIR);
    }

    public function scopeExencion($query)
    {
        return $query->where('type', self::TYPE_EXENCION);
    }

    public function scopeVisibleInFront($query)
    {
        return $query->where('show_in_front', true);
    }

    // ---------- Helpers ----------

    public function isAir(): bool
    {
        return $this->type === self::TYPE_AIR;
    }

    public function isExencion(): bool
    {
        return $this->type === self::TYPE_EXENCION;
    }

    public function getDictamenBadgeClassAttribute(): string
    {
        return match ($this->dictamen_status) {
            self::DICTAMEN_APROBADO  => 'success',
            self::DICTAMEN_RECHAZADO => 'danger',
            default                  => 'warning',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === self::TYPE_AIR
            ? 'Análisis de Impacto Regulatorio'
            : 'Solicitud de Exención';
    }

    /**
     * Genera folio único: AIR2026-0001 / EX2026-0001
     */
    public static function generateFolio(string $type): string
    {
        $year   = Carbon::now()->year;
        $prefix = $type === self::TYPE_AIR ? 'AIR' : 'EX';
        $like   = "{$prefix}{$year}-%";

        $last = self::where('type', $type)
            ->where('folio', 'like', $like)
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = $last ? (int) substr($last->folio, strrpos($last->folio, '-') + 1) : 0;
        $next       = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$year}-{$next}";
    }
}
