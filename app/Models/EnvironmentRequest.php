<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EnvironmentRequest extends Model
{
    use HasFactory;

    /**
     * Tipos de trámite de la Dirección de Medio Ambiente.
     */
    public const TYPE_PODA = 'poda';

    public const TYPE_TALA = 'tala';

    public const TYPE_DONACION = 'donacion';

    public const REQUEST_TYPES = [
        self::TYPE_PODA => 'Permiso de Poda',
        self::TYPE_TALA => 'Permiso de Tala',
        self::TYPE_DONACION => 'Solicitud de Donación',
    ];

    /**
     * Prefijo de folio por tipo de trámite: MA-P / MA-T / MA-D.
     */
    public const FOLIO_PREFIXES = [
        self::TYPE_PODA => 'MA-P-',
        self::TYPE_TALA => 'MA-T-',
        self::TYPE_DONACION => 'MA-D-',
    ];

    /**
     * Estatus del trámite. `pagada` sólo aplica a Tala: corresponde al
     * cumplimiento de la compensación en árboles endémicos, no a un cobro.
     */
    public const STATUS_NUEVA = 'nueva';

    public const STATUS_INSPECCION = 'inspeccion';

    public const STATUS_APROBADA = 'aprobada';

    public const STATUS_RECHAZADA = 'rechazada';

    public const STATUS_PAGADA = 'pagada';

    public const STATUSES = [
        self::STATUS_NUEVA => 'Nuevo',
        self::STATUS_INSPECCION => 'Inspección',
        self::STATUS_APROBADA => 'Aprobado',
        self::STATUS_RECHAZADA => 'Rechazado',
        self::STATUS_PAGADA => 'Pagado',
    ];

    protected $fillable = [
        'user_id',
        'folio',
        'request_type',
        'status',
        'fecha_solicitud',
        'nombre',
        'domicilio',
        'colonia',
        'motivo',
        'telefono_celular',
        'telefono_fijo',
        'fecha_atencion',
        'observaciones_inspeccion',
        'inspector',
        'persona_atendio',
        'especie',
        'cantidad',
        'altura_arbol',
        'coordenadas',
        'compensacion_confirmada_at',
        'compensacion_confirmada_por',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_atencion' => 'date',
        'compensacion_confirmada_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (EnvironmentRequest $request) {
            if (empty($request->folio)) {
                $request->folio = self::nextFolio($request->request_type);
            }

            if (empty($request->fecha_solicitud)) {
                $request->fecha_solicitud = now();
            }

            // El default vive en la migración, pero sin esto la instancia
            // recién creada devuelve null al leer $request->status.
            if (empty($request->status)) {
                $request->status = self::STATUS_NUEVA;
            }
        });
    }

    /**
     * Consecutivo independiente por tipo de trámite: MA-P-00001, MA-T-00001…
     *
     * El SELECT … FOR UPDATE dentro de la transacción evita que dos altas
     * simultáneas del mismo trámite calculen el mismo consecutivo y choquen
     * contra el índice único de `folio`.
     */
    public static function nextFolio(string $requestType): string
    {
        $prefix = self::FOLIO_PREFIXES[$requestType] ?? 'MA-X-';

        return DB::transaction(function () use ($requestType, $prefix) {
            $last = self::where('request_type', $requestType)
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $consecutive = $last
                ? ((int) substr($last->folio, strlen($prefix))) + 1
                : 1;

            return $prefix.str_pad((string) $consecutive, 5, '0', STR_PAD_LEFT);
        });
    }

    public function getRequestTypeLabelAttribute(): string
    {
        return self::REQUEST_TYPES[$this->request_type] ?? $this->request_type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Sólo Tala contempla el estatus "Pagado" (compensación cumplida).
     */
    public function availableStatuses(): array
    {
        $statuses = self::STATUSES;

        if ($this->request_type !== self::TYPE_TALA) {
            unset($statuses[self::STATUS_PAGADA]);
        }

        return $statuses;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(EnvironmentRequestFile::class);
    }

    public function notes()
    {
        return $this->hasMany(EnvironmentRequestNote::class);
    }

    public function voucher()
    {
        return $this->hasOne(EnvironmentDeliveryVoucher::class);
    }
}
