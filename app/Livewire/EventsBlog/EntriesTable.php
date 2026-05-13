<?php

namespace App\Livewire\EventsBlog;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\EventsBlog;

class EntriesTable extends Component
{
    use WithPagination;

    public $published_date = '';

    public function resetFilters()
    {
        $this->published_date = '';
    }

    public function render()
    {
        $query = EventsBlog::query();

        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }

        $entries = $query->latest()->paginate(8);

        return view('events-blog.utilities.entries-table', [
            'entries' => $entries,
        ]);
    }
}
