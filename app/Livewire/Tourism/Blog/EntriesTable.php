<?php

namespace App\Livewire\Tourism\Blog;

use Livewire\Component;

use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

use App\Models\TourismBlog;

class EntriesTable extends Component
{
    use WithPagination;

    public $published_date = '';
    public $category = '';

    public function resetFilters()
    {
        $this->published_date = '';
        $this->category = '';
    }

    public function render()
    {
        $query = TourismBlog::query();
        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }

        $blogs = $query->latest()->paginate(8);

        return view('tourism.blog.utilities.entries-table', [
            'blogs' => $blogs,
        ]);
    }
}
