<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'person_type',
        'registration_number',

        // Campos compartidos
        'rfc',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'fax',
        'mobile_phone',
        'nextel_phone',

        // Persona Física
        'owner_name',
        'business_name',
        'activities_start_date',
        'equity_capital',
        'curp',
        'chamber_registration',
        'business_line',

        // Persona Moral
        'legal_name',
        'partners_names',
        'incorporation_date',
        'share_capital',
        'legal_representative',
        'legal_representative_curp',
        'shareholders_curp',
        'deed_number',
        'notary_name',
        'predominant_activity',

        // Estado
        'status',
        'notes',
    ];

    protected $casts = [
        'activities_start_date' => 'date',
        'incorporation_date' => 'date',
        'equity_capital' => 'decimal:2',
        'share_capital' => 'decimal:2',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los archivos
     */
    public function files()
    {
        return $this->hasMany(SupplierFile::class);
    }

    /**
     * Relación con los refrendos
     */
    public function endorsements()
    {
        return $this->hasMany(SupplierEndorsement::class);
    }

    /**
     * Relación con la aprobación
     */
    public function approval()
    {
        return $this->hasOne(SupplierApproval::class);
    }

    /**
     * Genera un número de alta automático
     */
    public static function generateRegistrationNumber()
    {
        $year = date('Y');
        $lastSupplier = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSupplier && $lastSupplier->registration_number) {
            preg_match('/\d+$/', $lastSupplier->registration_number, $matches);
            $sequence = isset($matches[0]) ? intval($matches[0]) + 1 : 1;
        } else {
            $sequence = 1;
        }

        return 'PROV-' . $year . '-' . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Obtiene el nombre principal del proveedor según el tipo
     */
    public function getDisplayNameAttribute()
    {
        if ($this->person_type === 'moral') {
            return $this->legal_name ?? 'Sin nombre';
        }

        return $this->owner_name ?? $this->business_name ?? 'Sin nombre';
    }

    /**
     * Verifica si el proveedor es persona física
     */
    public function isPersonaFisica()
    {
        return $this->person_type === 'fisica';
    }

    /**
     * Verifica si el proveedor es persona moral
     */
    public function isPersonaMoral()
    {
        return $this->person_type === 'moral';
    }

    /**
     * Obtiene el badge de estado
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'solicitud' => '<span class="badge bg-secondary">Solicitud</span>',
            'validacion' => '<span class="badge bg-info">Validación</span>',
            'aprobacion' => '<span class="badge bg-warning">Aprobación</span>',
            'pago_pendiente' => '<span class="badge bg-primary">Pago Pendiente</span>',
            'padron_activo' => '<span class="badge bg-success">Padrón Activo</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Desconocido</span>';
    }

    /**
     * Obtiene el tipo de persona formateado
     */
    public function getPersonTypeFormattedAttribute()
    {
        return $this->person_type === 'fisica' ? 'Persona Física' : 'Persona Moral';
    }

    /**
     * Calcula el progreso de documentos requeridos
     */
    public function getProgressPercentageAttribute()
    {
        $requiredDocuments = $this->getRequiredDocuments();
        $totalRequired = count($requiredDocuments);

        if ($totalRequired === 0) {
            return 0;
        }

        $uploadedTypes = $this->files->pluck('file_type')->unique()->toArray();
        $uploadedCount = 0;

        foreach ($requiredDocuments as $doc) {
            if (in_array($doc['slug'], $uploadedTypes)) {
                $uploadedCount++;
            }
        }

        return round(($uploadedCount / $totalRequired) * 100);
    }

    /**
     * Obtiene la lista de documentos requeridos según el tipo de persona
     */
    public function getRequiredDocuments()
    {
        $commonDocs = [
            [
                'name' => 'Formato de Alta',
                'slug' => 'formato-de-alta',
                'has_resource' => true,
                'resource_file' => 'formato_alta.docx'
            ],
            [
                'name' => 'Formato de Datos Fiscales',
                'slug' => 'formato-de-datos-fiscales',
                'has_resource' => true,
                'resource_file' => 'formato_datos_fiscales.docx'
            ],
            ['name' => 'Constancia de Situación Fiscal', 'slug' => 'constancia-de-situacion-fiscal'],
            ['name' => 'Catálogo de Bienes y Servicios', 'slug' => 'catalogo-de-bienes-y-servicios'],
            ['name' => 'Comprobante de Domicilio', 'slug' => 'comprobante-de-domicilio'],
            ['name' => 'CURP', 'slug' => 'curp'],
            ['name' => 'Opinión de Cumplimiento', 'slug' => 'opinion-de-cumplimiento'],
        ];

        if ($this->person_type === 'fisica') {
            return array_merge($commonDocs, [
                ['name' => 'Copia Certificada de Identificación Oficial del Solicitante', 'slug' => 'copia-certificada-de-identificacion-oficial-del-solicitante'],
            ]);
        } else {
            return array_merge($commonDocs, [
                ['name' => 'Copia Certificada de Identificación Oficial del Representante Legal', 'slug' => 'copia-certificada-de-identificacion-oficial-del-representante-legal'],
                ['name' => 'Acta Constitutiva', 'slug' => 'acta-constitutiva'],
                ['name' => 'Poder Notarial', 'slug' => 'poder-notarial'],
            ]);
        }
    }

    /**
     * Scope para filtrar por tipo de persona
     */
    public function scopePersonaFisica($query)
    {
        return $query->where('person_type', 'fisica');
    }

    /**
     * Scope para filtrar por persona moral
     */
    public function scopePersonaMoral($query)
    {
        return $query->where('person_type', 'moral');
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            if (!$supplier->registration_number) {
                $supplier->registration_number = self::generateRegistrationNumber();
            }
        });
    }

    /*Licitaciones*/
    public function proposals()
    {
        return $this->hasMany(BiddingProposal::class, 'supplier_id');
    }
}
