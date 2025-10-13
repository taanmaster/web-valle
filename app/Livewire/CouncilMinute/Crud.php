<?php

namespace App\Livewire\CouncilMinute;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use App\Models\CouncilMinute;

class Crud extends Component
{
    use WithFileUploads;

    public $minute;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $name = '';
    public $file = '';
    public $year = '';
    public $session = '';

    public $years = ['2028', '2027', '2026', '2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015'];
    public $sessions = ['Acta 1ERA Sesión', 'Acta 2DA Sesión', 'Acta 3ERA Sesión', 'Acta 4TA Sesión'];

    public function mount()
    {
        if ($this->minute != null) {
            $this->fetchMinuteData();
        }
    }

    public function fetchMinuteData()
    {
        $this->name = $this->minute->name;
        $this->file = $this->minute->file;
        $this->year = $this->minute->year;
        $this->session = $this->minute->session;
    }

    public function save()
    {
        // Validación
        $this->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'session' => 'required|string|max:255',
            'file' => $this->minute ? 'nullable|file|mimes:pdf,doc,docx|max:5120' : 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año debe ser un número.',
            'file.required' => 'Debes subir un archivo.',
            'file.mimes' => 'El archivo debe ser PDF, DOC o DOCX.',
            'file.max' => 'El archivo no puede superar los 5MB.',
        ]);


        if ($this->minute != null) {

            // --- Subida de archivos si hay nuevos ---
            $file_url = $this->file ? $this->handleUpload($this->file) : $this->minute->file;

            $this->minute->update([
                'name' => $this->name,
                'file' => $file_url,
                'year' => $this->year,
                'session' => $this->session,
            ]);

            Session::flash('message', 'Minuta actualizada correctamente.');
        } else {

            $file_url = null;
            // --- Subida de archivos ---
            if ($this->file) {
                $file_url = $this->handleUpload($this->file);
            }

            CouncilMinute::create([
                'name' => $this->name,
                'file' => $file_url,
                'year' => $this->year,
                'session' => $this->session,
            ]);

            Session::flash('message', 'Minuta creada correctamente.');
        }

        return redirect()->route('council_minutes.index');
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'council_minutes/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('council_minutes.utilities.crud');
    }
}
