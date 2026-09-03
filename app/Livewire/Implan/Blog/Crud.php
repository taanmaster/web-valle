<?php

namespace App\Livewire\Implan\Blog;

// Ayudantes
use Str;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use App\Models\ImplanBlog;
use Livewire\Component;

class Crud extends Component
{
    use WithFileUploads;

    public $post;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $title = '';
    public $slug = '';
    public $image;
    public $type = '';
    public $published_at;

    public function mount()
    {
        if ($this->post != null) {
            $this->fetchBlogData();
        }
    }

    public function fetchBlogData()
    {
        $this->title = $this->post->title;
        $this->slug = $this->post->slug;
        $this->type = $this->post->type;
        $this->published_at = $this->post->published_at ? Carbon::parse($this->post->published_at)->format('Y-m-d') : null;

        if ($this->mode == 1) {
            $this->image = $this->post->image;
        } else {
            $this->image = null;
        }

    }

    public function save()
    {
        $this->validate($this->imageRules(), $this->imageMessages());

        if ($this->post != null) {
            // --- Subida de archivos si hay nuevos ---
            $file_url = $this->image ? $this->handleUpload($this->image) : $this->post->image;

            $slug = Str::slug($this->title);

            $record = ImplanBlog::find($this->post->id);

            $record->title = $this->title;
            $record->slug = $slug;
            $record->published_at = $this->published_at;
            $record->type = $this->type;

            $record->image = $file_url;

            $record->save();
        } else {

            $file_url = $this->image ? $this->handleUpload($this->image) : null;

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

    public function removeImage($id) {

        $record = ImplanBlog::find($id);
        $record->image = null;
        $record->save();
        $this->image = null;

    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = $document->storeAs('institutional_development/regulations', $filename, 's3');

        return Storage::disk('s3')->url($filepath);
    }

    protected function imageRules()
    {
        return [
            'image' => ['nullable', 'file', 'max:51200', 'mimes:jpg,jpeg,png,gif,webp,tiff,pdf,doc,docx,xls,xlsx,zip'],
        ];
    }

    protected function imageMessages()
    {
        return [
            'image.file' => 'El archivo seleccionado no es válido.',
            'image.max' => 'El archivo no debe superar los 50 MB.',
            'image.mimes' => 'El tipo de archivo no está permitido. Se aceptan: imágenes (JPG, PNG, GIF, WEBP, TIFF), PDF, Word, Excel y ZIP.',
            'image.uploaded' => 'No se pudo cargar el archivo. Verifique su conexión e inténtelo de nuevo.',
        ];
    }

    public function render()
    {
        return view('implan.blog.utilities.crud');
    }
}
