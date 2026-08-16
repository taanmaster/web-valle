<?php

namespace App\Livewire\GeneralBlog;

use App\Models\GeneralBlog;
use App\Models\GeneralBlogImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Crud extends Component
{
    use WithFileUploads;

    public $entry;

    // 0: create  1: show  2: edit
    public $mode;

    // welfare | training | events
    public $type;

    public $title;

    public $slug = '';

    public $description = '';

    public $content_1 = '';

    public $content_2 = '';

    public $hero_img = '';

    public $published_at = '';

    public $blog_category_id = '';

    public array $newPhotos = [];

    public function mount()
    {
        if ($this->entry !== null) {
            $this->fetchEntryData();
        }

        $this->published_at = Carbon::now()->format('Y-m-d');
    }

    public function fetchEntryData()
    {
        $this->title = $this->entry->title;
        $this->slug = $this->entry->slug;
        $this->description = $this->entry->description;
        $this->content_1 = $this->entry->content_1;
        $this->content_2 = $this->entry->content_2;
        $this->hero_img = $this->entry->hero_img;
        $this->published_at = $this->entry->published_at;
        $this->blog_category_id = $this->entry->blog_category_id;
    }

    /**
     * Slug único: Str::slug($title) por sí solo choca contra el índice
     * unique() de general_blogs.slug en cuanto se repite un título.
     */
    protected function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base ?: 'entrada';
        $i = 1;

        while (
            GeneralBlog::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }

    #[On('updateGeneralBlogContent1')]
    public function updateContent1($payload)
    {
        $this->content_1 = $payload;
    }

    #[On('updateGeneralBlogContent2')]
    public function updateContent2($payload)
    {
        $this->content_2 = $payload;
    }

    public function deletePhoto($photoId)
    {
        $photo = GeneralBlogImage::find($photoId);
        if (! $photo) {
            return;
        }

        $key = ltrim(parse_url($photo->image_path, PHP_URL_PATH), '/');
        Storage::disk('s3')->delete($key);
        $photo->delete();
    }

    public function uploadPhotos()
    {
        $this->validate(['newPhotos.*' => 'image|max:15360']);

        foreach ($this->newPhotos as $photo) {
            GeneralBlogImage::create([
                'general_blog_id' => $this->entry->id,
                'image_path' => $this->uploadAdditionalPhoto($photo),
            ]);
        }

        $this->newPhotos = [];
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'nullable',
            'content_1' => 'nullable',
            'content_2' => 'nullable',
            'hero_img' => 'nullable',
            'published_at' => 'nullable|date',
        ]);

        $routePrefix = $this->type.'_blog';

        if ($this->entry !== null) {
            if ($this->hero_img instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                if ($this->entry->hero_img) {
                    Storage::disk('s3')->delete(
                        ltrim(parse_url($this->entry->hero_img, PHP_URL_PATH), '/')
                    );
                }
                $heroUrl = $this->uploadHeroImage($this->hero_img);
            } else {
                $heroUrl = $this->entry->hero_img;
            }

            $this->entry->update([
                'title' => $this->title,
                'description' => $this->description,
                'content_1' => $this->content_1,
                'content_2' => $this->content_2,
                'hero_img' => $heroUrl,
                'published_at' => $this->published_at,
                'blog_category_id' => $this->blog_category_id ?: null,
            ]);

            return redirect()->route($routePrefix.'.admin.index');
        }

        $heroUrl = null;
        if ($this->hero_img instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $heroUrl = $this->uploadHeroImage($this->hero_img);
        }

        $newEntry = GeneralBlog::create([
            'type' => $this->type,
            'title' => $this->title,
            'slug' => $this->uniqueSlug(Str::slug($this->title)),
            'description' => $this->description,
            'content_1' => $this->content_1,
            'content_2' => $this->content_2,
            'hero_img' => $heroUrl,
            'published_at' => $this->published_at,
            'blog_category_id' => $this->blog_category_id ?: null,
        ]);

        if (! empty($this->newPhotos)) {
            foreach ($this->newPhotos as $photo) {
                GeneralBlogImage::create([
                    'general_blog_id' => $newEntry->id,
                    'image_path' => $this->uploadAdditionalPhoto($photo),
                ]);
            }
        }

        return redirect()->route($routePrefix.'.admin.edit', $newEntry->id);
    }

    protected function uploadHeroImage($file): string
    {
        $name = Str::random(8).'_cover.'.$file->getClientOriginalExtension();
        $filepath = 'general-blog/'.$name;

        $encoded = Image::make($file->getRealPath())
            ->resize(960, null, fn ($c) => $c->aspectRatio())
            ->encode($file->getClientOriginalExtension());

        Storage::disk('s3')->put($filepath, (string) $encoded);

        return Storage::disk('s3')->url($filepath);
    }

    protected function uploadAdditionalPhoto($file): string
    {
        $name = Str::random(8).'_image.'.$file->getClientOriginalExtension();
        $filepath = 'general-blog/'.$name;

        $stream = fopen($file->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        $routePrefix = $this->type.'_blog';
        $existingPhotos = $this->entry ? $this->entry->fresh()->images : collect();
        $categories = \App\Models\BlogCategory::where('is_active', true)->orderBy('name')->get();

        return view('general-blog.utilities.crud', compact('routePrefix', 'existingPhotos', 'categories'));
    }
}
