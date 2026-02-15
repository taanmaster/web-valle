<?php

namespace App\Livewire\Tourism\ThirdPartyRequest;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\TourismThirdPartyRequest;
use App\Models\TourismThirdPartyObservation;

class ObservationsTab extends Component
{
    public $request;
    public $observation = '';

    public function mount(TourismThirdPartyRequest $request)
    {
        $this->request = $request;
    }

    public function saveObservation()
    {
        $this->validate([
            'observation' => 'required|min:5',
        ]);

        TourismThirdPartyObservation::create([
            'tourism_third_party_request_id' => $this->request->id,
            'user_id' => Auth::id(),
            'observation' => $this->observation,
        ]);

        $this->observation = '';
        $this->request->refresh();

        session()->flash('observation_saved', 'Observación agregada correctamente.');
    }

    public function render()
    {
        $observations = TourismThirdPartyObservation::where('tourism_third_party_request_id', $this->request->id)
            ->with('user')
            ->latest()
            ->get();

        return view('tourism.third_party_requests.utilities.observations-tab', [
            'observations' => $observations,
        ]);
    }
}
