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
        $this->image = $this->blog->image;
        $this->type = $this->blog->type;
        $this->published_at = $this->blog->published_at ? Carbon::parse($this->blog->published_at)->format('Y-m-d') : null;
    }

    public function save()
    {
        if ($this->blog != null) {
            // --- Subida de archivos si hay nuevos ---
            $file_url = $this->image ? $this->handleUpload($this->image) : $this->blog->image;

            $record = ImplanBlog::find($this->blog->id);

            $record->title = $this->title;
            $record->published_at = $this->published_at;
            $record->type = $this->type;

            $record->image = $file_url;

            $record->save();
        } else {

            $file_url = null;

            if ($this->image) {
                $document = $this->image;

                $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $document->getClientOriginalExtension();

                // Reemplazar espacios y caracteres no válidos
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $filename = $cleanName . '.' . $extension;

                // Crear ruta S3 bajo institutional_development
                $filepath = 'institutional_development/regulations/' . $filename;

                // Usar streaming para subir a S3
                $stream = fopen($document->getRealPath(), 'r+');
                Storage::disk('s3')->put($filepath, $stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }

                $file_url = Storage::disk('s3')->url($filepath);
            }

            $slug = Str::slug($this->title);

            $record = new ImplanBlog;
            $record->title = $this->title;
            $record->slug = $slug;
            $record->published_at = $this->published_at;
            $record->type = $this->type;

            $record->image = $file_url;

            $record->save();
        }

        return redirect()->route('implan.blog.show', $record->id);
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'institutional_development/regulations/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('implan.blog.utilities.crud');
    }
}
