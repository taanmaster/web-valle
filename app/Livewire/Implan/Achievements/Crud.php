<?php

namespace App\Livewire\Implan\Achievements;

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

use App\Models\ImplanAchievement;
use Livewire\Component;

class Crud extends Component
{
    use WithFileUploads;

    public $achievement;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $title = '';
    public $description = '';
    public $hex = '';
    public $image;
    public $file;
    public $published_at;
    public $is_active = true;

    public function mount()
    {
        if ($this->achievement != null) {
            $this->fetchAchievementData();
        }
    }

    public function fetchAchievementData()
    {
        $this->title = $this->achievement->title;
        $this->description = $this->achievement->description;
        $this->image = $this->achievement->image;
        $this->file = $this->achievement->file;
        $this->hex = $this->achievement->hex;
        $this->published_at = $this->achievement->published_at ? Carbon::parse($this->achievement->published_at)->format('Y-m-d') : null;
        $this->is_active = $this->achievement->is_active;
    }

    public function save()
    {
        if ($this->achievement != null) {
            // --- Subida de archivos si hay nuevos ---
            $file_url = $this->file ? $this->handleUpload($this->file) : $this->achievement->file;
            $image_url = $this->image ? $this->handleUpload($this->image) : $this->achievement->image;

            $record = ImplanAchievement::find($this->achievement->id);

            $record->title = $this->title;
            $record->description = $this->description;
            $record->hex = $this->hex;
            $record->published_at = $this->published_at;
            $record->is_active = $this->is_active;

            $record->file = $file_url;
            $record->image = $image_url;

            $record->save();
        } else {

            $file_url = null;
            $image_url = null;

            if ($this->file) {
                $document = $this->file;

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

                $image_url = Storage::disk('s3')->url($filepath);
            }

            $record = new ImplanAchievement;
            $record->title = $this->title;
            $record->description = $this->description;
            $record->hex = $this->hex;
            $record->published_at = $this->published_at;
            $record->is_active = $this->is_active;

            $record->file = $file_url;
            $record->image = $image_url;

            $record->save();
        }

        return redirect()->route('implan.achievements.show', $record->id);
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
        return view('implan.achievements.utilities.crud');
    }
}
