<?php

namespace App\Livewire\WelfareBlog;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\WelfareBlog;

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
        $query = WelfareBlog::query();

        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }

        return view('welfare-blog.utilities.entries-table', [
            'entries' => $query->latest()->paginate(8),
        ]);
    }
}
