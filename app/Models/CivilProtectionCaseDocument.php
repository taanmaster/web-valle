<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CivilProtectionCaseDocument extends Model
{
    use HasFactory;

    public const STATUSES = [
        'sin_entregar' => ['Sin entregar', 'secondary'],
        'por_revisar' => ['Por revisar', 'primary'],
        'aceptado' => ['Aceptado', 'success'],
        'rechazado' => ['Rechazado', 'danger'],
    ];

    protected $fillable = [
        'civil_protection_case_id',
        'civil_protection_procedure_requirement_id',
        'sort_order',
        'name',
        'instructions',
        'is_required',
        'formats',
        'requires_original',
        'status',
        'rejection_reason',
        'original_received',
        'added_after_start',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'formats' => 'array',
        'requires_original' => 'boolean',
        'original_received' => 'boolean',
        'added_after_start' => 'boolean',
    ];

    public static function attributesFromRequirement(CivilProtectionProcedureRequirement $requirement): array
    {
        return [
            'civil_protection_procedure_requirement_id' => $requirement->id,
            'sort_order' => $requirement->sort_order,
            'name' => $requirement->name,
            'instructions' => $requirement->instructions,
            'is_required' => $requirement->is_required,
            'formats' => $requirement->formats,
            'requires_original' => $requirement->requires_original,
        ];
    }

    public function case()
    {
        return $this->belongsTo(CivilProtectionCase::class, 'civil_protection_case_id');
    }

    public function versions()
    {
        return $this->hasMany(CivilProtectionCaseDocumentVersion::class)->orderByDesc('version');
    }

    public function latestVersion()
    {
        return $this->hasOne(CivilProtectionCaseDocumentVersion::class)->latestOfMany('version');
    }

    /**
     * Sube una nueva versión del documento a S3 y lo deja "Por revisar".
     * Si el expediente estaba en "Requiere corrección" y ya no quedan documentos rechazados,
     * regresa automáticamente a "En revisión documental".
     */
    public function addVersion(UploadedFile $file, ?int $userId, bool $byCitizen = false): CivilProtectionCaseDocumentVersion
    {
        $filepath = 'proteccion_civil/expedientes/'.$this->civil_protection_case_id.'/'
            .Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'_'.Str::random(8)
            .'.'.$file->getClientOriginalExtension();

        $stream = fopen($file->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $version = $this->versions()->create([
            'version' => ($this->versions()->max('version') ?? 0) + 1,
            'filename' => $file->getClientOriginalName(),
            'filesize' => $file->getSize(),
            's3_url' => Storage::disk('s3')->url($filepath),
            'uploaded_by' => $userId,
            'uploaded_by_citizen' => $byCitizen,
        ]);

        $this->update(['status' => 'por_revisar', 'rejection_reason' => null]);

        $case = $this->case;
        if ($case->status === 'requiere_correccion' && ! $case->documents()->where('status', 'rechazado')->exists()) {
            $case->update(['status' => 'en_revision']);
            $case->log('en_revision', 'Se recibieron las correcciones solicitadas.');
        }

        return $version;
    }

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status][0] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return self::STATUSES[$this->status][1] ?? 'secondary';
    }

    public function getFormatsLabelAttribute()
    {
        return strtoupper(implode(' / ', $this->formats ?? []));
    }

    public function getAcceptMimesAttribute()
    {
        return collect($this->formats)->map(fn ($f) => $f === 'jpg' ? 'jpg,jpeg' : $f)->implode(',');
    }
}
