<?php

namespace App\Livewire\Front\Tourism;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\TourismThirdPartyRequest;

class ThirdPartyWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 6;

    // Paso 1: Solicitante
    public $full_name = '';
    public $organization_name = '';
    public $applicant_type = 'persona_fisica';
    public $rfc_or_curp = '';
    public $fiscal_address = '';
    public $phone = '';
    public $email = '';

    // Paso 2: Evento
    public $event_name = '';
    public $event_type = '';
    public $event_objective = '';
    public $event_description = '';

    // Paso 3: Fecha y Lugar
    public $start_date = '';
    public $end_date = '';
    public $start_time = '';
    public $end_time = '';
    public $venue = '';
    public $event_access_type = 'Abierto';

    // Paso 4: Impacto
    public $expected_impact = '';
    public $estimated_attendees = '';
    public $promotes_identity = '';
    public $generates_economic_impact = '';

    // Paso 5: Apoyo
    public $support_type = '';
    public $support_description = '';

    // Paso 6: Firma
    public $signature;

    public function mount()
    {
        $user = Auth::user();
        $this->full_name = $user->name ?? '';
        $this->email = $user->email ?? '';
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'full_name' => 'required|string|max:255',
                    'applicant_type' => 'required|in:persona_fisica,persona_moral',
                    'rfc_or_curp' => 'required|string|max:18',
                    'fiscal_address' => 'required|string|max:255',
                    'phone' => 'required|string|max:20',
                    'email' => 'required|email|max:255',
                ]);
                break;
            case 2:
                $this->validate([
                    'event_name' => 'required|string|max:255',
                    'event_type' => 'required|string|max:255',
                    'event_objective' => 'required|string|min:10',
                    'event_description' => 'required|string|min:10',
                ]);
                break;
            case 3:
                $this->validate([
                    'start_date' => 'required|date|after_or_equal:today',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'venue' => 'required|string|max:255',
                    'event_access_type' => 'required|in:Abierto,Cerrado',
                ]);
                break;
            case 4:
                $this->validate([
                    'expected_impact' => 'required|string',
                    'estimated_attendees' => 'required|integer|min:1',
                    'promotes_identity' => 'required|string|min:10',
                    'generates_economic_impact' => 'required|string|min:10',
                ]);
                break;
            case 5:
                $this->validate([
                    'support_type' => 'required|string',
                    'support_description' => 'required|string|min:10',
                ]);
                break;
        }
    }

    public function save()
    {
        $this->validate([
            'signature' => 'nullable|image|max:2048',
        ]);

        $signaturePath = null;
        if ($this->signature) {
            $signaturePath = $this->signature->store('tourism/third_party_signatures', 's3');
        }

        $request = TourismThirdPartyRequest::create([
            'folio' => TourismThirdPartyRequest::generateFolio(),
            'user_id' => Auth::id(),
            'status' => 'Enviada',
            'full_name' => $this->full_name,
            'organization_name' => $this->organization_name ?: null,
            'applicant_type' => $this->applicant_type,
            'rfc_or_curp' => $this->rfc_or_curp,
            'fiscal_address' => $this->fiscal_address,
            'phone' => $this->phone,
            'email' => $this->email,
            'event_name' => $this->event_name,
            'event_type' => $this->event_type,
            'event_objective' => $this->event_objective,
            'event_description' => $this->event_description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'venue' => $this->venue,
            'event_access_type' => $this->event_access_type,
            'expected_impact' => $this->expected_impact,
            'estimated_attendees' => $this->estimated_attendees,
            'promotes_identity' => $this->promotes_identity,
            'generates_economic_impact' => $this->generates_economic_impact,
            'support_type' => $this->support_type,
            'support_description' => $this->support_description,
            'signature_path' => $signaturePath,
        ]);

        session()->flash('success', 'Tu solicitud de apoyo ha sido enviada correctamente. Folio: ' . $request->folio);

        return redirect()->route('citizen.third_party.index');
    }

    public function render()
    {
        return view('front.user_profiles.citizen.third_party_support.utilities.wizard');
    }
}
