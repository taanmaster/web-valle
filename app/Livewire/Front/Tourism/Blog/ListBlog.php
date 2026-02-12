<?php

namespace App\Livewire\Front\Tourism\Blog;

use Livewire\Component;

use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

use App\Models\TourismBlog;

class ListBlog extends Component
{
    use WithPagination;

    // Mode 0 = index, 1 = full;
    public $mode = '';

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

        if ($this->mode == 0) {
            $blogs = $query->latest()->get()->take(3);
        } else {
            $blogs = $query->latest()->paginate(8);
        }

        return view('front.tourism.blog.utilities.list-blog', [
            'blogs' => $blogs,
        ]);
    }
}
