<?php

namespace App\Livewire\Blog;

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

        $query = Blog::query();
        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }
        if ($this->category !== '') {
            $query->where('category', $this->category);
        }

        $blogs = $query->latest()->paginate(8);

        return view('blog.utilities.entries-table', [
            'blogs' => $blogs,
        ]);
    }
}
