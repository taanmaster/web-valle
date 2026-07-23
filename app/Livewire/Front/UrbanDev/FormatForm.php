<?php

namespace App\Livewire\Front\UrbanDev;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\UrbanDevRequest;
use App\Models\UrbanDevFormat;

class FormatForm extends Component
{
    use WithFileUploads;

    public UrbanDevRequest $request;
    public string $formatType = '';

    /** Todos los campos de texto del formato. */
    public array $data = [];

    /** Croquis (archivo temporal de Livewire). */
    public $croquis = null;

    /** Firmas como data URL (base64 PNG) generadas por el signature pad. */
    public string $signatureApplicant = '';
    public string $signaturePerito = '';

    public bool $saved = false;
    public bool $editing = false;

    public function mount(UrbanDevRequest $request): void
    {
        // La solicitud debe pertenecer al usuario autenticado (evita IDOR)
        if ($request->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        $this->request = $request;
        $this->formatType = $request->request_type;

        $this->data = $this->defaultData();

        $existing = $request->format;
        if ($existing) {
            $this->data = array_merge($this->data, $existing->data ?? []);
            $this->saved = true;
            $this->editing = false;
        } else {
            $this->editing = true;
        }
    }

    private function defaultData(): array
    {
        return [
            // Tipo de trámite (solo uso de suelo) - selección única
            'tipo_tramite' => '',

            // 1. Datos generales del solicitante
            'tipo_persona' => '',
            'condicion' => '',
            'pf_primer_apellido' => '',
            'pf_segundo_apellido' => '',
            'pf_nombres' => '',
            'pf_curp' => '',
            'pf_correo' => '',
            'pf_telefono' => '',
            'pm_razon_social' => '',
            'pm_rfc' => '',
            'rl_primer_apellido' => '',
            'rl_segundo_apellido' => '',
            'rl_nombres' => '',
            'rl_rfc' => '',
            'rl_correo' => '',
            'rl_telefono' => '',

            // 2. Domicilio para recibir notificaciones
            'dom_calle' => '',
            'dom_num_ext' => '',
            'dom_num_int' => '',
            'dom_colonia' => '',
            'dom_cp' => '',
            'dom_ciudad' => '',
            'dom_estado' => '',

            // 3. Datos del propietario del predio
            'prop_tipo' => '',
            'prop_pf_primer_apellido' => '',
            'prop_pf_segundo_apellido' => '',
            'prop_pf_nombres' => '',
            'prop_pm_razon_social' => '',

            // 4. Datos del predio
            'predio_cuenta_predial' => '',
            'predio_calle' => '',
            'predio_num_ext' => '',
            'predio_num_int' => '',
            'predio_colonia' => '',
            'predio_cp' => '',
            'predio_superficie' => '',

            // 5a. Datos del giro solicitado (uso de suelo)
            'giro_solicitado' => '',
            'giro_superficie_ocupar' => '',
            'giro_denominacion_comercial' => '',

            // 5b. Datos de la construcción (licencia de construcción)
            'construccion_tipo' => '',
            'construccion_m2' => '',
            'construccion_ml' => '',
            'perito_primer_apellido' => '',
            'perito_segundo_apellido' => '',
            'perito_nombres' => '',
            'perito_registro_padron' => '',
            'perito_correo' => '',
            'perito_telefono' => '',
        ];
    }

    public function startEditing(): void
    {
        $this->editing = true;
    }

    /**
     * Reglas de validación dinámicas: todo el formato debe llenarse.
     */
    protected function buildRules(): array
    {
        $rules = [
            'data.tipo_persona' => 'required|in:fisica,moral',
            'data.condicion' => 'required|in:solicitante,tercero',

            // Domicilio
            'data.dom_calle' => 'required|string|max:255',
            'data.dom_num_ext' => 'required|string|max:50',
            'data.dom_num_int' => 'nullable|string|max:50',
            'data.dom_colonia' => 'required|string|max:255',
            'data.dom_cp' => 'required|string|max:10',
            'data.dom_ciudad' => 'required|string|max:255',
            'data.dom_estado' => 'required|string|max:255',

            // Propietario
            'data.prop_tipo' => 'required|in:fisica,moral',

            // Predio
            'data.predio_cuenta_predial' => 'required|string|max:100',
            'data.predio_calle' => 'required|string|max:255',
            'data.predio_num_ext' => 'required|string|max:50',
            'data.predio_num_int' => 'nullable|string|max:50',
            'data.predio_colonia' => 'required|string|max:255',
            'data.predio_cp' => 'required|string|max:10',
            'data.predio_superficie' => 'required|string|max:100',
        ];

        // Solicitante: Persona Física vs Moral
        if (($this->data['tipo_persona'] ?? '') === 'fisica') {
            $rules['data.pf_primer_apellido'] = 'required|string|max:255';
            $rules['data.pf_segundo_apellido'] = 'nullable|string|max:255';
            $rules['data.pf_nombres'] = 'required|string|max:255';
            $rules['data.pf_correo'] = 'required|email|max:255';
            $rules['data.pf_telefono'] = 'required|string|max:30';
            if ($this->formatType === 'uso-de-suelo') {
                $rules['data.pf_curp'] = 'required|string|max:18';
            }
        } elseif (($this->data['tipo_persona'] ?? '') === 'moral') {
            $rules['data.pm_razon_social'] = 'required|string|max:255';
            $rules['data.pm_rfc'] = 'required|string|max:13';
            // El representante legal es obligatorio para persona moral
            $rules['data.rl_primer_apellido'] = 'required|string|max:255';
            $rules['data.rl_segundo_apellido'] = 'nullable|string|max:255';
            $rules['data.rl_nombres'] = 'required|string|max:255';
            $rules['data.rl_rfc'] = 'required|string|max:13';
            $rules['data.rl_correo'] = 'required|email|max:255';
            $rules['data.rl_telefono'] = 'required|string|max:30';
        }

        // Propietario del predio
        if (($this->data['prop_tipo'] ?? '') === 'fisica') {
            $rules['data.prop_pf_primer_apellido'] = 'required|string|max:255';
            $rules['data.prop_pf_segundo_apellido'] = 'nullable|string|max:255';
            $rules['data.prop_pf_nombres'] = 'required|string|max:255';
        } elseif (($this->data['prop_tipo'] ?? '') === 'moral') {
            $rules['data.prop_pm_razon_social'] = 'required|string|max:255';
        }

        // Específicas por tipo de formato
        if ($this->formatType === 'uso-de-suelo') {
            $rules['data.tipo_tramite'] = 'required|in:uso-suelo,num-oficial,alineamiento';
            $rules['data.giro_solicitado'] = 'required|string|max:255';
            $rules['data.giro_superficie_ocupar'] = 'required|string|max:100';
            $rules['data.giro_denominacion_comercial'] = 'required|string|max:255';
        } elseif ($this->formatType === 'licencia-de-construccion') {
            $rules['data.construccion_tipo'] = 'required|string|max:255';
            $rules['data.construccion_m2'] = 'nullable|string|max:100';
            $rules['data.construccion_ml'] = 'nullable|string|max:100';
            $rules['data.perito_primer_apellido'] = 'required|string|max:255';
            $rules['data.perito_segundo_apellido'] = 'nullable|string|max:255';
            $rules['data.perito_nombres'] = 'required|string|max:255';
            $rules['data.perito_registro_padron'] = 'required|string|max:100';
            $rules['data.perito_correo'] = 'required|email|max:255';
            $rules['data.perito_telefono'] = 'required|string|max:30';
        }

        // Croquis: obligatorio si aún no hay uno guardado.
        // Solo formatos seguros (se excluye SVG para evitar XSS almacenado).
        $croquisRule = 'mimes:jpg,jpeg,png,webp,pdf|max:10240';
        if (!$this->request->format || !$this->request->format->croquis_path) {
            $rules['croquis'] = 'required|' . $croquisRule;
        } else {
            $rules['croquis'] = 'nullable|' . $croquisRule;
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'data.*.required' => 'Este campo es obligatorio.',
            'data.*.email' => 'Ingresa un correo electrónico válido.',
            'croquis.required' => 'Debes adjuntar el croquis de localización.',
            'croquis.mimes' => 'El croquis debe ser un archivo JPG, PNG, WEBP o PDF.',
            'croquis.max' => 'El croquis no puede pesar más de 10 MB.',
        ];
    }

    public function save()
    {
        // Verificar propiedad de la solicitud
        if ($this->request->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        $this->validate($this->buildRules(), $this->messages());

        // Validaciones "al menos uno"
        if ($this->formatType === 'licencia-de-construccion') {
            $tieneMedida = trim((string) ($this->data['construccion_m2'] ?? '')) !== ''
                || trim((string) ($this->data['construccion_ml'] ?? '')) !== '';
            if (!$tieneMedida) {
                $this->addError('data.construccion_m2', 'Indica los metros cuadrados o lineales de construcción.');
                return;
            }
        }

        $existing = $this->request->format;

        // Firmas: obligatorias en el primer guardado
        if ((!$existing || !$existing->signature_applicant_path) && !$this->signatureApplicant) {
            $this->addError('signatureApplicant', 'La firma del solicitante es obligatoria.');
            return;
        }
        if ($this->formatType === 'licencia-de-construccion'
            && (!$existing || !$existing->signature_perito_path)
            && !$this->signaturePerito) {
            $this->addError('signaturePerito', 'La firma del perito es obligatoria.');
            return;
        }

        // Rutas de archivos (conservar las existentes si no se reemplazan)
        $croquisPath = $existing->croquis_path ?? null;
        $sigApplicantPath = $existing->signature_applicant_path ?? null;
        $sigPeritoPath = $existing->signature_perito_path ?? null;

        $baseDir = 'desarrollo_urbano/formatos/' . $this->request->id;

        if ($this->croquis) {
            // Extensión y content-type derivados del mime validado, no del nombre del cliente
            $ext = $this->croquis->extension() ?: 'png';
            $mime = $this->croquis->getMimeType() ?: 'image/png';
            $croquisPath = $baseDir . '/croquis_' . time() . '_' . Str::random(6) . '.' . $ext;
            Storage::disk('s3')->put(
                $croquisPath,
                file_get_contents($this->croquis->getRealPath()),
                [
                    'ContentType' => $mime,
                    'ContentDisposition' => 'attachment',
                ]
            );
        }

        if ($this->signatureApplicant) {
            $sigApplicantPath = $this->storeSignature($this->signatureApplicant, $baseDir, 'firma_solicitante');
        }

        if ($this->formatType === 'licencia-de-construccion' && $this->signaturePerito) {
            $sigPeritoPath = $this->storeSignature($this->signaturePerito, $baseDir, 'firma_perito');
        }

        UrbanDevFormat::updateOrCreate(
            ['urban_dev_request_id' => $this->request->id],
            [
                'format_type' => $this->formatType,
                'data' => $this->data,
                'croquis_path' => $croquisPath,
                'signature_applicant_path' => $sigApplicantPath,
                'signature_perito_path' => $sigPeritoPath,
            ]
        );

        $this->request->refresh();
        $this->croquis = null;
        $this->signatureApplicant = '';
        $this->signaturePerito = '';
        $this->saved = true;
        $this->editing = false;

        session()->flash('format_saved', 'El formato se guardó correctamente.');
    }

    /**
     * Decodifica una firma en data URL (base64 PNG) y la sube a S3.
     */
    private function storeSignature(string $dataUrl, string $dir, string $name): string
    {
        $encoded = preg_replace('#^data:image/\w+;base64,#i', '', $dataUrl);
        $binary = base64_decode($encoded);
        $path = $dir . '/' . $name . '_' . time() . '_' . Str::random(6) . '.png';
        Storage::disk('s3')->put($path, $binary, [
            'ContentType' => 'image/png',
            'ContentDisposition' => 'attachment',
        ]);
        return $path;
    }

    public function render()
    {
        return view('livewire.front.urban-dev.format-form');
    }
}
