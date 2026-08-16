<?php

namespace App\Livewire\EnvironmentRequests;

use App\Models\EnvironmentDeliveryVoucher;
use App\Models\EnvironmentRequest;
use App\Models\EnvironmentRequestFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Crud extends Component
{
    use WithFileUploads;

    public EnvironmentRequest $environmentRequest;

    // Gestión de Estatus
    public $status = '';

    // Supervisión de la solicitud (Poda y Tala)
    public $fecha_atencion = '';

    public $observaciones_inspeccion = '';

    public $inspector = '';

    public $persona_atendio = '';

    public $especie = '';

    public $cantidad = '';

    public $altura_arbol = '';

    public $coordenadas = '';

    // Vale de entrega de planta (Donación) — filas fijas del mockup
    public $voucher_lugar_plantacion = '';

    public $voucher_fecha_entrega = '';

    public array $voucherEspecies = [];

    public array $voucherCantidades = [];

    // Evidencia fotográfica (Poda y Tala)
    public $newEvidence;

    public function mount()
    {
        $this->status = $this->environmentRequest->status;
        $this->fecha_atencion = optional($this->environmentRequest->fecha_atencion)->format('Y-m-d') ?? '';
        $this->observaciones_inspeccion = $this->environmentRequest->observaciones_inspeccion ?? '';
        $this->inspector = $this->environmentRequest->inspector ?? '';
        $this->persona_atendio = $this->environmentRequest->persona_atendio ?? '';
        $this->especie = $this->environmentRequest->especie ?? '';
        $this->cantidad = $this->environmentRequest->cantidad ?? '';
        $this->altura_arbol = $this->environmentRequest->altura_arbol ?? '';
        $this->coordenadas = $this->environmentRequest->coordenadas ?? '';

        $voucher = $this->environmentRequest->voucher;
        $this->voucher_lugar_plantacion = $voucher?->lugar_plantacion ?? '';
        $this->voucher_fecha_entrega = optional($voucher?->fecha_entrega)->format('Y-m-d') ?? '';

        $items = $voucher?->items ?? collect();
        for ($i = 0; $i < EnvironmentDeliveryVoucher::ITEM_ROWS; $i++) {
            $this->voucherEspecies[$i] = $items->get($i)?->especie ?? '';
            $this->voucherCantidades[$i] = $items->get($i)?->cantidad ?? '';
        }
    }

    public function isPoda(): bool
    {
        return $this->environmentRequest->request_type === EnvironmentRequest::TYPE_PODA;
    }

    public function isTala(): bool
    {
        return $this->environmentRequest->request_type === EnvironmentRequest::TYPE_TALA;
    }

    public function isDonacion(): bool
    {
        return $this->environmentRequest->request_type === EnvironmentRequest::TYPE_DONACION;
    }

    public function updateStatus()
    {
        $this->validate([
            'status' => 'required|in:'.implode(',', array_keys($this->environmentRequest->availableStatuses())),
        ]);

        $this->environmentRequest->update(['status' => $this->status]);

        session()->flash('success', 'Estatus actualizado correctamente.');
    }

    public function saveSupervision()
    {
        $this->validate([
            'fecha_atencion' => 'nullable|date',
            'observaciones_inspeccion' => 'nullable|string|max:2000',
            'inspector' => 'nullable|string|max:255',
            'persona_atendio' => 'nullable|string|max:255',
            'especie' => 'nullable|string|max:255',
            'cantidad' => 'nullable|string|max:255',
            'altura_arbol' => 'nullable|string|max:255',
            'coordenadas' => 'nullable|string|max:255',
        ]);

        $this->environmentRequest->update([
            'fecha_atencion' => $this->fecha_atencion ?: null,
            'observaciones_inspeccion' => $this->observaciones_inspeccion ?: null,
            'inspector' => $this->inspector ?: null,
            'persona_atendio' => $this->persona_atendio ?: null,
            'especie' => $this->especie ?: null,
            'cantidad' => $this->cantidad ?: null,
            'altura_arbol' => $this->altura_arbol ?: null,
            'coordenadas' => $this->coordenadas ?: null,
        ]);

        session()->flash('success', 'Supervisión guardada correctamente.');
    }

    /**
     * Confirmar el cumplimiento de la compensación en árboles de Tala.
     * "Pago" aquí es la donación de 20 árboles endémicos, no dinero.
     */
    public function confirmCompensation()
    {
        if (! $this->isTala()) {
            return;
        }

        $this->environmentRequest->update([
            'status' => EnvironmentRequest::STATUS_PAGADA,
        ]);
        $this->environmentRequest->update([
            'compensacion_confirmada_at' => now(),
            'compensacion_confirmada_por' => Auth::id(),
        ]);
        $this->status = EnvironmentRequest::STATUS_PAGADA;

        session()->flash('success', 'Compensación confirmada.');
    }

    /**
     * Vale de entrega de planta. Registro interno: no genera PDF ni se
     * muestra al ciudadano.
     */
    public function saveVoucher()
    {
        if (! $this->isDonacion()) {
            return;
        }

        $this->validate([
            'voucher_lugar_plantacion' => 'nullable|string|max:255',
            'voucher_fecha_entrega' => 'nullable|date',
            'voucherEspecies.*' => 'nullable|string|max:255',
            'voucherCantidades.*' => 'nullable|string|max:255',
        ]);

        $voucher = $this->environmentRequest->voucher
            ?: EnvironmentDeliveryVoucher::create(['environment_request_id' => $this->environmentRequest->id]);

        $voucher->update([
            'lugar_plantacion' => $this->voucher_lugar_plantacion ?: null,
            'fecha_entrega' => $this->voucher_fecha_entrega ?: null,
        ]);

        $voucher->items()->delete();

        foreach ($this->voucherEspecies as $index => $especie) {
            $cantidad = $this->voucherCantidades[$index] ?? '';

            if (filled($especie) || filled($cantidad)) {
                $voucher->items()->create(['especie' => $especie ?: null, 'cantidad' => $cantidad ?: null]);
            }
        }

        $this->environmentRequest->refresh();

        session()->flash('success', 'Vale de entrega guardado correctamente.');
    }

    public function uploadEvidence()
    {
        $this->validate(['newEvidence' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png']);

        $extension = $this->newEvidence->getClientOriginalExtension();
        $fileName = 'medio_ambiente_'.time().'_'.Str::random(10).'.'.$extension;
        $filepath = 'medio_ambiente/'.$fileName;

        Storage::disk('s3')->put($filepath, file_get_contents($this->newEvidence->getRealPath()));
        $s3Url = Storage::disk('s3')->url($filepath);

        EnvironmentRequestFile::create([
            'user_id' => Auth::id(),
            'environment_request_id' => $this->environmentRequest->id,
            'document_type' => EnvironmentRequestFile::DOC_EVIDENCIA,
            'name' => 'Evidencia fotográfica',
            'filename' => $fileName,
            'file_extension' => $extension,
            'filesize' => $this->newEvidence->getSize(),
            's3_asset_url' => $s3Url,
        ]);

        $this->newEvidence = null;
        $this->environmentRequest->refresh();

        session()->flash('success', 'Evidencia subida correctamente.');
    }

    public function deleteEvidence($fileId)
    {
        $file = EnvironmentRequestFile::where('environment_request_id', $this->environmentRequest->id)->findOrFail($fileId);

        if ($file->s3_asset_url) {
            $key = ltrim(parse_url($file->s3_asset_url, PHP_URL_PATH), '/');
            Storage::disk('s3')->delete($key);
        }

        $file->delete();
        $this->environmentRequest->refresh();
    }

    public function render()
    {
        $this->environmentRequest->load(['files', 'voucher.items']);

        return view('environment.requests.utilities.crud');
    }
}
