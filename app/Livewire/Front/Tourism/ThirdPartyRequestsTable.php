<?php

namespace App\Livewire\Front\Tourism;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

use App\Models\TourismThirdPartyRequest;

class ThirdPartyRequestsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $date_filter = '';
    public $event_type_filter = '';

    public function resetFilters()
    {
        $this->search = '';
        $this->date_filter = '';
        $this->event_type_filter = '';
    }

    public function render()
    {
        $query = TourismThirdPartyRequest::where('user_id', Auth::id());

        if ($this->search) {
            $query->where('event_name', 'like', '%' . $this->search . '%');
        }

        if ($this->date_filter) {
            $query->whereDate('created_at', $this->date_filter);
        }

        if ($this->event_type_filter) {
            $query->where('event_type', $this->event_type_filter);
        }

        $requests = $query->latest()->paginate(10);

        return view('front.user_profiles.citizen.third_party_support.utilities.requests-table', [
            'requests' => $requests,
        ]);
    }
}
