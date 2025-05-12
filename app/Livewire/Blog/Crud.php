<?php

namespace App\Livewire\Blog;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Intervention\Image\Facades\Image as Image;
use Livewire\WithFileUploads;


//Modelos
use App\Models\Blog;
use App\Models\BlogImage;
use App\Models\TransparencyDependency;

class Crud extends Component
{
    use WithFileUploads;

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

    public $categories = [];

    public function mount()
    {
        if ($this->blog != null) {
            $this->fetchBlogData();
        }

        $this->categories = TransparencyDependency::all();
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
            'description' => 'nullable',
            'content_1' => 'nullable',
            'content_2' => 'nullable',
            'hero_img' => 'nullable',
            'category' => 'nullable',
            'published_at' => 'nullable|date',
            'writer' => 'nullable',
        ]);

        if ($this->blog) {


            // Si se sube una nueva imagen
            if ($this->hero_img) {
                $imageCoverPath = $this->hero_img;
                $imageCoverName = Str::random(8) . '_cover' . '.' . $imageCoverPath->getClientOriginalExtension();
                $imageCoverLocation = public_path('images/blog/' . $imageCoverName);
                Image::make($imageCoverPath)->resize(960, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imageCoverLocation);

                // Eliminar la imagen anterior
                if ($this->blog->hero_img) {
                    unlink(public_path('images/blog/' . $this->blog->hero_img));
                }
            } else {
                $imageCoverName = $this->blog->hero_img;
            }

            $this->blog->update([
                'title' => $this->title,
                'description' => $this->description,
                'content_1' => $this->content_1,
                'content_2' => $this->content_2,
                'hero_img' => $imageCoverName,
                'category' => $this->category,
                'is_fav' => $this->is_fav,
                'published_at' => $this->published_at,
                'writer' => $this->writer,
            ]);


            return redirect()->route('blog.admin.index');
        } else {

            $imageCoverPath = $this->hero_img;
            $imageCoverName = Str::random(8) . '_cover' . '.' . $imageCoverPath->getClientOriginalExtension();
            $imageCoverLocation = public_path('images/blog/' . $imageCoverName);
            Image::make($imageCoverPath)->resize(960, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($imageCoverLocation);


            Blog::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'content_1' => $this->content_1,
                'content_2' => $this->content_2,
                'hero_img' => $imageCoverName,
                'category' => $this->category,
                'published_at' => $this->published_at,
                'writer' => $this->writer,
            ]);

            return redirect()->route('blog.admin.index');
        }
    }

    public function render()
    {
        return view('blog.utilities.crud');
    }
}
