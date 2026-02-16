<?php

namespace App\Livewire\Tourism\ThirdPartyRequest;

use Livewire\Component;

use App\Models\TourismThirdPartyRequest;

class DetailView extends Component
{
    public $request;
    public $status;

    public function mount(TourismThirdPartyRequest $request)
    {
        $this->request = $request;
        $this->status = $request->status;
    }

    public function updateStatus()
    {
        $this->request->update([
            'status' => $this->status,
        ]);

        $this->request->refresh();

        session()->flash('status_updated', 'Estatus actualizado correctamente.');
    }

    public function render()
    {
        return view('tourism.third_party_requests.utilities.detail-view');
    }
}
