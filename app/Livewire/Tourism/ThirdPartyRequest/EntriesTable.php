<?php

namespace App\Livewire\Tourism\ThirdPartyRequest;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\TourismThirdPartyRequest;

class EntriesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status_filter = '';
    public $date_filter = '';

    public function resetFilters()
    {
        $this->search = '';
        $this->status_filter = '';
        $this->date_filter = '';
    }

    public function render()
    {
        $query = TourismThirdPartyRequest::query();

        if ($this->search) {
            $query->where('full_name', 'like', '%' . $this->search . '%');
        }

        if ($this->status_filter) {
            $query->where('status', $this->status_filter);
        }

        if ($this->date_filter) {
            $query->whereDate('start_date', $this->date_filter);
        }

        $requests = $query->latest()->paginate(10);

        return view('tourism.third_party_requests.utilities.entries-table', [
            'requests' => $requests,
        ]);
    }
}
