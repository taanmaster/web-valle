<?php

namespace App\Livewire\Front\Blog;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

//Modelos
use App\Models\Blog;

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
        $query = Blog::query();
        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }
        if ($this->category !== '') {
            $query->where('category', $this->category);
        }

        if ($this->mode == 0) {
            $blogs = $query->get()->take(3);
        } else {
            $blogs = $query->latest()->paginate(8);
        }



        return view('front.blog.utilities.list-blog', [
            'blogs' => $blogs,
        ]);
    }
}
