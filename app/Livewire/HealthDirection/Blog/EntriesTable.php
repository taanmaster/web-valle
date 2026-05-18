<?php

namespace App\Livewire\HealthDirection\Blog;

use Livewire\Component;

use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

use App\Models\HealthDirectionBlog;

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
        $query = HealthDirectionBlog::query();
        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }

        $blogs = $query->latest()->paginate(8);

        return view('health_direction.blog.utilities.entries-table', [
            'blogs' => $blogs,
        ]);
    }
}
