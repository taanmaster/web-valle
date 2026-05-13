<?php

namespace App\Livewire\EventsBlog;

use Livewire\Component;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Intervention\Image\Facades\Image as Image;
use Livewire\WithFileUploads;

use App\Models\EventsBlog;

class Crud extends Component
{
    use WithFileUploads;

    public $entry;

    // Modes: 0: create, 1: show, 2: edit
    public $mode;

    public $title;
    public $slug         = '';
    public $description  = '';
    public $content_1    = '';
    public $content_2    = '';
    public $hero_img     = '';
    public $published_at = '';
    public array $photos = [];

    public function mount()
    {
        if ($this->entry !== null) {
            $this->fetchEntryData();
        }

        $this->published_at = Carbon::now()->format('Y-m-d');
    }

    public function fetchEntryData()
    {
        $this->title        = $this->entry->title;
        $this->slug         = $this->entry->slug;
        $this->description  = $this->entry->description;
        $this->content_1    = $this->entry->content_1;
        $this->content_2    = $this->entry->content_2;
        $this->hero_img     = $this->entry->hero_img;
        $this->published_at = $this->entry->published_at;
    }

    #[On('updateEventsContent1')]
    public function updateContent1($payload)
    {
        $this->content_1 = $payload;
    }

    #[On('updateEventsContent2')]
    public function updateContent2($payload)
    {
        $this->content_2 = $payload;
    }

    public function save()
    {
        $this->validate([
            'title'        => 'required',
            'description'  => 'nullable',
            'content_1'    => 'nullable',
            'content_2'    => 'nullable',
            'hero_img'     => 'nullable',
            'published_at' => 'nullable|date',
        ]);

        if ($this->entry !== null) {
            if ($this->hero_img !== $this->entry->hero_img) {
                $imageCoverPath = $this->hero_img;
                $imageCoverName = Str::random(8) . '_cover.' . $imageCoverPath->getClientOriginalExtension();
                $imageCoverLocation = public_path('images/events-blog/' . $imageCoverName);
                Image::make($imageCoverPath)->resize(960, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imageCoverLocation);

                if ($this->entry->hero_img && $this->entry->hero_img !== 'empty-image.jpg') {
                    $old = public_path('images/events-blog/' . $this->entry->hero_img);
                    if (file_exists($old)) {
                        unlink($old);
                    }
                }
            } else {
                $imageCoverName = $this->entry->hero_img;
            }

            $this->entry->update([
                'title'        => $this->title,
                'description'  => $this->description,
                'content_1'    => $this->content_1,
                'content_2'    => $this->content_2,
                'hero_img'     => $imageCoverName,
                'published_at' => $this->published_at,
            ]);

            return redirect()->route('events_blog.admin.index');
        }

        if ($this->hero_img !== null) {
            $imageCoverPath = $this->hero_img;
            $imageCoverName = Str::random(8) . '_cover.' . $imageCoverPath->getClientOriginalExtension();
            $imageCoverLocation = public_path('images/events-blog/' . $imageCoverName);
            Image::make($imageCoverPath)->resize(960, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($imageCoverLocation);
        } else {
            $imageCoverName = 'empty-image.jpg';
        }

        $newEntry = EventsBlog::create([
            'title'        => $this->title,
            'slug'         => Str::slug($this->title),
            'description'  => $this->description,
            'content_1'    => $this->content_1,
            'content_2'    => $this->content_2,
            'hero_img'     => $imageCoverName,
            'published_at' => $this->published_at,
        ]);

        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                $filename = Str::random(8) . '_image.' . $photo->getClientOriginalExtension();
                $location = public_path('images/events-blog/');
                $photo->move($location, $filename);

                \App\Models\EventsBlogImage::create([
                    'events_blog_id' => $newEntry->id,
                    'image_path'     => 'images/events-blog/' . $filename,
                ]);
            }
        }

        return redirect()->route('events_blog.admin.edit', $newEntry->id);
    }

    public function render()
    {
        return view('events-blog.utilities.crud');
    }
}
