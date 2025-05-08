<?php

namespace App\Livewire\Blog;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\Blog;
use App\Models\BlogImage;

class Crud extends Component
{

    public $blog;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    //Campos
    public $title;
    public $slug = '';
    public $description = '';
    public $content_1 = '';
    public $content_2 = '';
    public $hero_img = '';
    public $category = '';
    public $is_fav = '';
    public $published_at = '';
    public $writer = '';

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
        $this->description = $this->blog->description;
        $this->content_1 = $this->blog->content_1;
        $this->content_2 = $this->blog->content_2;
        $this->hero_img = $this->blog->hero_img;
        $this->category = $this->blog->category;
        $this->is_fav = $this->blog->is_fav;
        $this->published_at = $this->blog->published_at;
        $this->writer = $this->blog->writer;
    }

    public function save()
    {

        $this->validate([
            'title' => 'required',
            'slug' => 'required|unique:blogs,slug,' . $this->blog->id,
            'description' => 'nullable',
            'content_1' => 'nullable',
            'content_2' => 'nullable',
            'hero_img' => 'nullable',
            'category' => 'nullable',
            'is_fav' => 'boolean',
            'published_at' => 'nullable|date',
            'writer' => 'nullable',
        ]);

        if ($this->blog) {
            $this->blog->update([
                'title' => $this->title,
                'description' => $this->description,
                'content_1' => $this->content_1,
                'content_2' => $this->content_2,
                'hero_img' => $this->hero_img,
                'category' => $this->category,
                'is_fav' => $this->is_fav,
                'published_at' => $this->published_at,
                'writer' => $this->writer,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Entrada actualizada correctamente.');
        } else {
            Blog::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'content_1' => $this->content_1,
                'content_2' => $this->content_2,
                'hero_img' => $this->hero_img,
                'category' => $this->category,
                'is_fav' => $this->is_fav,
                'published_at' => $this->published_at,
                'writer' => $this->writer,
            ]);
        }
    }

    public function render()
    {
        return view('blog.utilities.crud');
    }
}
