<?php

namespace App\Livewire\Implan\Blog;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Intervention\Image\Facades\Image as Image;
use Livewire\WithFileUploads;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\ImplanBlog;
use Livewire\Component;

class Crud extends Component
{
    use WithFileUploads;

    public $blog;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $title = '';
    public $slug = '';
    public $image;
    public $type = '';
    public $published_at;

    public function mount()
    {
        if ($this->blog != null) {
            $this->fetchBlogData();
        }
    }

    public function fetchBlogData()
    {
        $this->title = $this->blog->title;
        $this->slug = $this->blog->slug;
        $this->type = $this->blog->type;
        $this->published_at = $this->blog->published_at ? Carbon::parse($this->blog->published_at)->format('Y-m-d') : null;
    }

    public function save()
    {
        if ($this->blog != null) {

            $this->blog->update([
                'title' => $this->title,
                'slug' => $this->slug,
                'type' => $this->type,
                'published_at' => $this->published_at,
            ]);
        } else {
            ImplanBlog::create([
                'title' => $this->title,
                'slug' => $this->slug,
                'type' => $this->type,
                'published_at' => $this->published_at,
            ]);
        }
    }

    public function render()
    {
        return view('implan.blog.utilities.crud');
    }
}
