<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrbanDevRequest extends Model
{
    use HasFactory;

    /**
     * Tipos de trámite que generan un apartado de captura para Catastro.
     */
    public const CASTRO_REQUEST_TYPES = [
        'uso-de-suelo',
        'licencia-de-construccion',
    ];

    /**
     * Al crearse una solicitud de Permiso de Construcción o Permiso de Uso de
     * Suelo se genera automáticamente el apartado para que Catastro llene la
     * información del predio.
     */
    protected static function booted(): void
    {
        static::created(function (UrbanDevRequest $request) {
            // Generar folio alfanumérico a partir de fecha, hora e id.
            if (empty($request->folio)) {
                $request->folio = $request->buildFolio();
                $request->saveQuietly();
            }

            if (in_array($request->request_type, self::CASTRO_REQUEST_TYPES)) {
                $request->castro()->create([
                    'status'          => 'pendiente',
                    'fecha_solicitud' => $request->created_at,
                    'cuenta_predial'  => $request->cuenta_predial,
                ]);
            }
        });
    }

    /**
     * Construye el folio de la solicitud: UD-{AAMMDD}-{HHMMSS}-{ID}.
     * Alfanumérico y determinístico a partir de la fecha, hora e id.
     */
    public function buildFolio(): string
    {
        $fecha = ($this->created_at ?? now())->format('ymd-His');

        return 'UD-' . $fecha . '-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'user_id',
        'folio',
        'status',
        'mode',
        'cuenta_predial',
        'request_type',
        'description',
        'inspector_id',
        'inspection_start_date',
        'inspector_license_number',
        'building_type',
        'payment_date',
        'payment_ref_number_1',
        'payment_ref_number_2',
        'payment_amount',
        'urban_dev_cost_id',
        'inspection_validity_start',
        'inspection_validity_end',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'inspection_start_date' => 'date',
        'payment_date' => 'date',
        'inspection_validity_start' => 'date',
        'inspection_validity_end' => 'date',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Relación con archivos adjuntos
     */
    public function files()
    {
        return $this->hasMany(\App\Models\UrbanDevRequestFile::class);
    }

    /**
     * Formato único de solicitud (uno por solicitud).
     */
    public function format()
    {
        return $this->hasOne(\App\Models\UrbanDevFormat::class, 'urban_dev_request_id');
    }

    /**
     * Apartado de captura de predio de Catastro (uno por solicitud).
     * Solo existe para Permiso de Uso de Suelo y Permiso de Construcción.
     */
    public function castro()
    {
        return $this->hasOne(\App\Models\UrbanDevCastroRequest::class, 'urban_dev_request_id');
    }

    /**
     * Relación con el inspector
     */
    public function inspector()
    {
        return $this->belongsTo(\App\Models\User::class, 'inspector_id');
    }

    /**
     * Concepto de costo asignado (define el monto a pagar en línea).
     */
    public function cost()
    {
        return $this->belongsTo(\App\Models\UrbanDevCost::class, 'urban_dev_cost_id');
    }

    /**
     * Efecto al confirmarse el pago en línea del expediente.
     * Lo invoca Order::applyPaidSideEffects() cuando la orden vinculada queda "Pagado".
     * Registra la fecha de pago en el expediente (no hay estatus posterior a Resolución).
     */
    public function onOnlinePaymentCompleted(\App\Models\Order $order): void
    {
        if (empty($this->payment_date)) {
            $this->update([
                'payment_date'         => now(),
                'payment_ref_number_1' => $this->payment_ref_number_1 ?: $order->folio,
            ]);
        }
    }

    /**
     * Obtener el estado en formato legible
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'new' => 'Nuevo',
            'entry' => 'Ingreso',
            'validation' => 'Validación',
            'requires_correction' => 'Requiere Corrección',
            'inspection' => 'Inspección',
            'resolved' => 'Resolución'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Obtener el color del badge según el estado
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'new' => 'primary',
            'entry' => 'info',
            'validation' => 'warning',
            'requires_correction' => 'danger',
            'inspection' => 'secondary',
            'resolved' => 'success'
        ];

        return $colors[$this->status] ?? 'primary';
    }

    /**
     * Obtener el tipo de solicitud en formato legible
     */
    public function getRequestTypeLabelAttribute()
    {
        $types = [
            'uso-de-suelo' => 'Permiso de Uso de Suelo',
            'constancia-de-factibilidad' => 'Constancia de Factibilidad',
            'permiso-de-anuncios' => 'Permiso de Anuncios y Toldos',
            'certificacion-numero-oficial' => 'Certificación de Número Oficial',
            'permiso-de-division' => 'Permiso de División',
            'uso-de-via-publica' => 'Uso de Vía Pública',
            'licencia-de-construccion' => 'Permiso de Construcción',
            'permiso-construccion-panteones' => 'Permiso de Construcción en Panteones',
            // Valores legacy
            'uso_suelo' => 'Uso de Suelo',
            'constancia_factibilidad' => 'Constancia de Factibilidad',
            'permiso_anuncios' => 'Permiso de Anuncios',
            'certificacion_numero_oficial' => 'Certificación de Número Oficial',
            'permiso_division' => 'Permiso de División',
            'uso_via_publica' => 'Uso de Vía Pública',
            'licencia_construccion' => 'Permiso de Construcción',
            'permiso_construccion_panteones' => 'Permiso de Construcción en Panteones',
            'general' => 'General'
        ];

        return $types[$this->request_type] ?? $this->request_type;
    }

    /**
     * Obtener el tipo de edificación en formato legible
     */
    public function getBuildingTypeLabelAttribute()
    {
        $types = [
            'casa_habitacion' => 'Casa Habitación',
            'bodega' => 'Bodega',
            'local_comercial' => 'Local Comercial',
            'otro' => 'Otro'
        ];

        return $types[$this->building_type] ?? $this->building_type;
    }

    /**
     * Obtener el domicilio del ciudadano relacionado
     */
    public function getUserAddressAttribute()
    {
        $citizen = \App\Models\Citizen::where('email', $this->user->email)->first();

        if (!$citizen) {
            return 'No disponible';
        }

        $addressParts = [];

        if ($citizen->street) {
            $addressParts[] = $citizen->street;
        }

        if ($citizen->colony) {
            $addressParts[] = $citizen->colony;
        }

        if ($citizen->address && !in_array($citizen->address, $addressParts)) {
            $addressParts[] = $citizen->address;
        }

        return !empty($addressParts) ? implode(', ', $addressParts) : 'No disponible';
    }
}
