<?php

namespace App\Livewire\Benefits;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Purifier;

use App\Models\Benefit;
use App\Models\BenefitImage;

class Crud extends Component
{
    use WithFileUploads;

    public $entry;

    // 0: create  1: show  2: edit
    public $mode;

    public $title        = '';
    public $description  = '';
    public $content_1    = '';
    public $content_2    = '';
    public $hero_img     = null;
    public $published_at = '';

    public array $newPhotos = [];

    public function mount(): void
    {
        $this->published_at = Carbon::now()->format('Y-m-d');

        if ($this->entry !== null) {
            $this->fetchEntryData();
        }
    }

    public function fetchEntryData(): void
    {
        $this->title        = $this->entry->title;
        $this->description  = $this->entry->description;
        $this->content_1    = $this->entry->content_1;
        $this->content_2    = $this->entry->content_2;
        $this->hero_img     = $this->entry->hero_img;
        $this->published_at = $this->entry->published_at?->format('Y-m-d');
    }

    #[On('updateBenefitContent1')]
    public function updateContent1($payload): void
    {
        $this->content_1 = $payload;
    }

    #[On('updateBenefitContent2')]
    public function updateContent2($payload): void
    {
        $this->content_2 = $payload;
    }

    public function deletePhoto(int $photoId): void
    {
        $photo = BenefitImage::find($photoId);
        if (!$photo) {
            return;
        }

        $key = ltrim(parse_url($photo->image_path, PHP_URL_PATH) ?? '', '/');
        if ($key !== '') {
            Storage::disk('s3')->delete($key);
        }

        $photo->delete();
    }

    public function uploadPhotos(): void
    {
        $this->validate(['newPhotos.*' => 'image|max:15360']);

        foreach ($this->newPhotos as $photo) {
            BenefitImage::create([
                'benefit_id' => $this->entry->id,
                'image_path' => $this->handleUpload($photo),
            ]);
        }

        $this->newPhotos = [];
    }

    public function save()
    {
        $this->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'content_1'    => 'nullable',
            'content_2'    => 'nullable',
            'published_at' => 'nullable|date',
            'newPhotos.*'  => 'image|max:15360',
        ]);

        // Sanitizar HTML del editor antes de persistir
        $this->content_1 = $this->content_1 ? Purifier::clean($this->content_1) : $this->content_1;
        $this->content_2 = $this->content_2 ? Purifier::clean($this->content_2) : $this->content_2;

        if ($this->entry !== null) {
            if ($this->hero_img instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                if ($this->entry->hero_img) {
                    Storage::disk('s3')->delete(
                        ltrim(parse_url($this->entry->hero_img, PHP_URL_PATH) ?? '', '/')
                    );
                }
                $heroUrl = $this->handleUpload($this->hero_img);
            } else {
                $heroUrl = $this->entry->hero_img;
            }

            $this->entry->update([
                'title'        => $this->title,
                'description'  => $this->description,
                'content_1'    => $this->content_1,
                'content_2'    => $this->content_2,
                'hero_img'     => $heroUrl,
                'published_at' => $this->published_at ?: null,
            ]);

            return redirect()->route('benefits.admin.index');
        }

        $heroUrl = null;
        if ($this->hero_img instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $heroUrl = $this->handleUpload($this->hero_img);
        }

        $slug = Str::slug($this->title);
        if (Benefit::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        $newEntry = Benefit::create([
            'title'        => $this->title,
            'slug'         => $slug,
            'description'  => $this->description,
            'content_1'    => $this->content_1,
            'content_2'    => $this->content_2,
            'hero_img'     => $heroUrl,
            'published_at' => $this->published_at ?: null,
        ]);

        foreach ($this->newPhotos as $photo) {
            BenefitImage::create([
                'benefit_id' => $newEntry->id,
                'image_path' => $this->handleUpload($photo),
            ]);
        }

        return redirect()->route('benefits.admin.index');
    }

    protected function handleUpload($document): string
    {
        $extension = $document->getClientOriginalExtension();
        $filename  = 'benefit_' . time() . '_' . Str::random(10) . '.' . $extension;
        $filepath  = 'benefits/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        $existingPhotos = $this->entry ? $this->entry->fresh()->images : collect();

        return view('benefits.utilities.crud', compact('existingPhotos'));
    }
}
