<?php

namespace App\Livewire\UrbanDev\Castro;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\UrbanDevCastroRequest;

class Crud extends Component
{
    public UrbanDevCastroRequest $castro;

    // Modos: 0 = capturar, 1 = ver y editar
    public $mode = 0;

    // Fechas y cuenta predial
    #[Validate('required|date')]
    public $fecha_solicitud = '';

    #[Validate('required|date')]
    public $fecha_entrega_documentos = '';

    #[Validate('required|string|max:255')]
    public $cuenta_predial = '';

    // Contribuyente y predio
    #[Validate('required|string|max:255')]
    public $nombre_contribuyente = '';

    #[Validate('required|string|max:255')]
    public $tipo_predio = '';

    #[Validate('required|string|max:255')]
    public $domicilio_predio = '';

    // Ubicación y detalles (opcionales)
    #[Validate('required|string|max:255')]
    public $localidad_colonia_ejido = '';

    #[Validate('required|string|max:255')]
    public $manzana_lote = '';

    #[Validate('required|numeric|min:0')]
    public $superficie = '';

    #[Validate('required|string|max:255')]
    public $uso_tramite = '';

    #[Validate(['nullable', 'url', 'max:255', 'regex:/^https?:\/\//i'])]
    public $url_expediente = '';

    public function mount()
    {
        // Prellenar campos existentes
        $this->fecha_solicitud = optional($this->castro->fecha_solicitud)->format('Y-m-d')
            ?? optional($this->castro->urbanDevRequest?->created_at)->format('Y-m-d')
            ?? '';
        $this->fecha_entrega_documentos = optional($this->castro->fecha_entrega_documentos)->format('Y-m-d') ?? '';
        $this->cuenta_predial = $this->castro->cuenta_predial ?? '';
        $this->nombre_contribuyente = $this->castro->nombre_contribuyente ?? '';
        $this->tipo_predio = $this->castro->tipo_predio ?? '';
        $this->domicilio_predio = $this->castro->domicilio_predio ?? '';
        $this->localidad_colonia_ejido = $this->castro->localidad_colonia_ejido ?? '';
        $this->manzana_lote = $this->castro->manzana_lote ?? '';
        $this->superficie = $this->castro->superficie ?? '';
        $this->uso_tramite = $this->castro->uso_tramite ?? '';
        $this->url_expediente = $this->castro->url_expediente ?? '';
    }

    /**
     * Campos obligatorios que definen si la captura está completa.
     */
    private function requiredFields(): array
    {
        return [
            $this->fecha_solicitud,
            $this->fecha_entrega_documentos,
            $this->cuenta_predial,
            $this->nombre_contribuyente,
            $this->tipo_predio,
            $this->domicilio_predio,
        ];
    }

    /**
     * Deriva el estado a partir de la información realmente capturada:
     *   pendiente  → no hay nada llenado
     *   en_captura → hay algo pero faltan campos obligatorios
     *   completado → todos los campos obligatorios están llenos
     */
    private function computeStatus(): string
    {
        $all = array_merge($this->requiredFields(), [
            $this->localidad_colonia_ejido,
            $this->manzana_lote,
            $this->superficie,
            $this->uso_tramite,
            $this->url_expediente,
        ]);

        $anyFilled = collect($all)->contains(fn ($v) => filled($v));
        if (!$anyFilled) {
            return 'pendiente';
        }

        $allRequiredFilled = collect($this->requiredFields())->every(fn ($v) => filled($v));

        return $allRequiredFilled ? 'completado' : 'en_captura';
    }

    /**
     * Persiste los valores actuales del formulario y actualiza el estado.
     */
    private function persist(): void
    {
        $status = $this->computeStatus();

        $this->castro->update([
            'fecha_solicitud'          => $this->fecha_solicitud ?: null,
            'fecha_entrega_documentos' => $this->fecha_entrega_documentos ?: null,
            'cuenta_predial'           => $this->cuenta_predial ?: null,
            'nombre_contribuyente'     => $this->nombre_contribuyente ?: null,
            'tipo_predio'              => $this->tipo_predio ?: null,
            'domicilio_predio'         => $this->domicilio_predio ?: null,
            'localidad_colonia_ejido'  => $this->localidad_colonia_ejido ?: null,
            'manzana_lote'             => $this->manzana_lote ?: null,
            'superficie'               => $this->superficie !== '' ? $this->superficie : null,
            'uso_tramite'              => $this->uso_tramite ?: null,
            'url_expediente'           => $this->url_expediente ?: null,
            'status'                   => $status,
        ]);

        // Reflejar la cuenta predial en la solicitud de Desarrollo Urbano
        if ($this->castro->urbanDevRequest) {
            $this->castro->urbanDevRequest->update(['cuenta_predial' => $this->cuenta_predial ?: null]);
        }
    }

    /**
     * Guardar borrador: no exige los campos obligatorios, solo valida el
     * formato de lo que sí se haya escrito. El estado queda en "en captura"
     * (o "completado" si por casualidad ya está todo).
     */
    public function saveDraft()
    {
        // Solo se valida el formato de los campos opcionales que sí traen valor.
        $this->validate([
            'superficie'     => 'nullable|numeric|min:0',
            'url_expediente' => ['nullable', 'url', 'max:255', 'regex:/^https?:\/\//i'],
        ]);

        $this->persist();

        session()->flash('success', 'Borrador guardado correctamente.');

        return redirect()->route('urban_dev.catastro.index');
    }

    /**
     * Finalizar captura: exige todos los campos obligatorios.
     */
    public function save()
    {
        $this->validate();

        $this->persist();

        session()->flash('success', 'Información del predio guardada correctamente.');

        return redirect()->route('urban_dev.catastro.index');
    }

    public function render()
    {
        return view('urban_dev.catastro.utilities.crud');
    }
}
