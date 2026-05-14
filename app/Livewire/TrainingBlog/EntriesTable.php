<?php

namespace App\Livewire\TrainingBlog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TrainingBlog;

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
        $query = TrainingBlog::query();

        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }

        return view('training-blog.utilities.entries-table', [
            'entries' => $query->latest()->paginate(8),
        ]);
    }
}
