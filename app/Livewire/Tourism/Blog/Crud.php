<?php

namespace App\Livewire\Tourism\Blog;

use Livewire\Component;

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

use App\Models\TourismBlog;

class Crud extends Component
{
    use WithFileUploads;

    public $blog;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

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

    public array $photos = [];

    public function mount()
    {
        if ($this->blog != null) {
            $this->fetchBlogData();
        }

        $this->published_at = Carbon::now()->format('Y-m-d');
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

    #[On('updateContent1')]
    public function updateContent1($payload)
    {
        $this->content_1 = $payload;
    }

    #[On('updateContent2')]
    public function updateContent2($payload)
    {
        $this->content_2 = $payload;
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

        if ($this->blog != null) {
            if ($this->hero_img != $this->blog->hero_img) {
                $imageCoverPath = $this->hero_img;
                $imageCoverName = Str::random(8) . '_cover' . '.' . $imageCoverPath->getClientOriginalExtension();
                $imageCoverDir = public_path('images/tourism/blog/');
                if (!file_exists($imageCoverDir)) {
                    mkdir($imageCoverDir, 0755, true);
                }
                $imageCoverLocation = $imageCoverDir . $imageCoverName;
                Image::make($imageCoverPath->getRealPath())->resize(960, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imageCoverLocation);

                if ($this->blog->hero_img) {
                    $oldPath = public_path('images/tourism/blog/' . $this->blog->hero_img);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
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

            return redirect()->route('tourism.blog.admin.index');
        } else {

            if ($this->hero_img != null) {
                $imageCoverPath = $this->hero_img;
                $imageCoverName = Str::random(8) . '_cover' . '.' . $imageCoverPath->getClientOriginalExtension();
                $imageCoverDir = public_path('images/tourism/blog/');
                if (!file_exists($imageCoverDir)) {
                    mkdir($imageCoverDir, 0755, true);
                }
                $imageCoverLocation = $imageCoverDir . $imageCoverName;
                Image::make($imageCoverPath->getRealPath())->resize(960, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imageCoverLocation);
            } else {
                $imageCoverName = 'empty-image.jpg';
            }

            TourismBlog::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'content_1' => $this->content_1,
                'content_2' => $this->content_2,
                'hero_img' => $imageCoverName,
                'category' => $this->category,
                'published_at' => $this->published_at,
                'writer' => $this->writer,
                'is_fav' => $this->is_fav,
            ]);

            return redirect()->route('tourism.blog.admin.index');
        }
    }

    public function render()
    {
        return view('tourism.blog.utilities.crud');
    }
}
