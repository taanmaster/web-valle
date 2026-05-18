<?php

namespace App\Livewire\GeneralBlog;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\GeneralBlog;

class EntriesTable extends Component
{
    use WithPagination;

    // welfare | training | events
    public string $type;

    public $published_date = '';

    public function resetFilters()
    {
        $this->published_date = '';
    }

    public function render()
    {
        $query = GeneralBlog::where('type', $this->type);

        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }

        $routePrefix = $this->type . '_blog';

        return view('general-blog.utilities.entries-table', [
            'entries'     => $query->latest()->paginate(8),
            'routePrefix' => $routePrefix,
        ]);
    }
}
