<?php

namespace App\Livewire\UrbanDev\Requests;

use App\Models\UrbanDevRequest;
use App\Models\UrbanDevRequestReview;
use Auth;
use Livewire\Component;

class DependencyDictamenes extends Component
{
    public UrbanDevRequest $urbanDevRequest;

    public bool $showPcForm = false;

    public bool $showMaForm = false;

    // Formulario Protección Civil
    public $pc_responsible_name = '';

    public $pc_construction_type = '';

    public $pc_property_address = '';

    // Formulario Medio Ambiente
    public $ma_format = '';

    public $ma_responsible_name = '';

    public $ma_technical_responsible = '';

    public $ma_establishment_name = '';

    public $ma_property_address = '';

    public $ma_latitude = '';

    public $ma_longitude = '';

    public function mount(UrbanDevRequest $urbanDevRequest)
    {
        $this->urbanDevRequest = $urbanDevRequest;

        $defaultAddress = $urbanDevRequest->castro->domicilio_predio ?? '';
        $defaultResponsible = $urbanDevRequest->user->name ?? '';

        $this->pc_responsible_name = $defaultResponsible;
        $this->pc_property_address = $defaultAddress;

        $this->ma_responsible_name = $defaultResponsible;
        $this->ma_property_address = $defaultAddress;
    }

    public function openPcForm()
    {
        $this->showPcForm = true;
    }

    public function cancelPcForm()
    {
        $this->showPcForm = false;
    }

    public function openMaForm()
    {
        $this->showMaForm = true;
    }

    public function cancelMaForm()
    {
        $this->showMaForm = false;
    }

    /**
     * Envía la solicitud a Protección Civil para su Opinión Técnica de Factibilidad.
     */
    public function sendToProteccionCivil()
    {
        $this->validate([
            'pc_responsible_name' => 'required|string|max:255',
            'pc_construction_type' => 'required|string|max:255',
            'pc_property_address' => 'nullable|string|max:255',
        ], [], [
            'pc_responsible_name' => 'responsable o representante legal',
            'pc_construction_type' => 'tipo de construcción / uso de suelo',
        ]);

        UrbanDevRequestReview::updateOrCreate(
            ['urban_dev_request_id' => $this->urbanDevRequest->id, 'dependency' => 'proteccion_civil'],
            [
                'status' => 'recibida',
                'sent_at' => now(),
                'sent_by' => Auth::id(),
                'responsible_name' => $this->pc_responsible_name,
                'construction_type' => $this->pc_construction_type,
                'property_address' => $this->pc_property_address ?: null,
            ]
        );

        $this->markAsInspection();

        $this->showPcForm = false;

        session()->flash('success', 'Solicitud enviada a Protección Civil correctamente.');
    }

    /**
     * Envía la solicitud a la Dirección de Medio Ambiente para su Visto Bueno Ambiental.
     */
    public function sendToMedioAmbiente()
    {
        $this->validate([
            'ma_format' => 'required|in:alto_impacto,licencia_ambiental_funcionamiento,manejo_de_residuos',
            'ma_responsible_name' => 'required|string|max:255',
            'ma_technical_responsible' => 'nullable|string|max:255',
            'ma_establishment_name' => 'required|string|max:255',
            'ma_property_address' => 'nullable|string|max:255',
            'ma_latitude' => 'nullable|string|max:255',
            'ma_longitude' => 'nullable|string|max:255',
        ], [], [
            'ma_format' => 'formato a enviar',
            'ma_responsible_name' => 'ciudadano o representante legal',
            'ma_establishment_name' => 'giro o denominación del establecimiento',
        ]);

        UrbanDevRequestReview::updateOrCreate(
            ['urban_dev_request_id' => $this->urbanDevRequest->id, 'dependency' => 'medio_ambiente'],
            [
                'format' => $this->ma_format,
                'status' => 'recibida',
                'sent_at' => now(),
                'sent_by' => Auth::id(),
                'responsible_name' => $this->ma_responsible_name,
                'technical_responsible' => $this->ma_technical_responsible ?: null,
                'establishment_name' => $this->ma_establishment_name,
                'property_address' => $this->ma_property_address ?: null,
                'latitude' => $this->ma_format === 'alto_impacto' ? ($this->ma_latitude ?: null) : null,
                'longitude' => $this->ma_format === 'alto_impacto' ? ($this->ma_longitude ?: null) : null,
            ]
        );

        $this->markAsInspection();

        $this->showMaForm = false;

        session()->flash('success', 'Solicitud enviada a la Dirección de Medio Ambiente correctamente.');
    }

    /**
     * Cuando se manda a Medio Ambiente o Protección Civil el estatus de la solicitud es Inspección.
     */
    private function markAsInspection(): void
    {
        if ($this->urbanDevRequest->status !== 'resolved') {
            $this->urbanDevRequest->update(['status' => 'inspection']);
        }
    }

    public function render()
    {
        $this->urbanDevRequest->refresh();

        $pcReview = $this->urbanDevRequest->reviews()->where('dependency', 'proteccion_civil')->first();
        $maReview = $this->urbanDevRequest->reviews()->where('dependency', 'medio_ambiente')->first();

        return view('livewire.urban-dev.requests.dependency-dictamenes', [
            'pcReview' => $pcReview,
            'maReview' => $maReview,
        ]);
    }
}
