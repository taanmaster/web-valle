<?php

namespace App\Livewire\MunicipalRegulations;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

use App\Models\MunicipalRegulation;

use Livewire\WithFileUploads;

use Livewire\Component;

class Crud extends Component
{

    use WithFileUploads;

    public $regulation;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $title = '';
    public $regulation_type = '';
    public $publication_type = '';
    public $publication_date = '';
    public $file = '';
    public $pdf_file = '';
    public $word_file = '';

    public function mount()
    {
        if ($this->regulation != null) {
            $this->fetchRegulationData();
        }
    }

    public function fetchRegulationData()
    {
        $this->title = $this->regulation->title;
        $this->regulation_type = $this->regulation->regulation_type;
        $this->publication_type = $this->regulation->publication_type;
        $this->publication_date = $this->regulation->publication_date;
        $this->file = $this->regulation->file;
        $this->pdf_file = $this->regulation->pdf_file;
        $this->word_file = $this->regulation->word_file;
    }

    public function save()
    {
        if ($this->regulation != null) {

            $this->regulation->update([
                'title' => $this->title,
                'regulation_type' => $this->regulation_type,
                'publication_type' => $this->publication_type,
                'publication_date' => $this->publication_date,
                'file' => $this->file,
                'pdf_file' => $this->pdf_file,
                'word_file' => $this->word_file,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Dependencia actualizada correctamente.');

            return redirect()->route('institucional_development.regulations.show', $this->regulation->id);
        } else {

            $file_url = null;
            $pdf_file_url = null;
            $word_file_url = null;

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

            if ($this->pdf_file) {
                $document = $this->pdf_file;

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
                
                $pdf_file_url = Storage::disk('s3')->url($filepath);
            }

            if ($this->word_file) {
                $document = $this->word_file;

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
                
                $word_file_url = Storage::disk('s3')->url($filepath);
            }

            $this->regulation = MunicipalRegulation::create([
                'title' => $this->title,
                'regulation_type' => $this->regulation_type,
                'publication_type' => $this->publication_type,
                'publication_date' => $this->publication_date,
                'file' => $file_url,
                'pdf_file' => $pdf_file_url,
                'word_file' => $word_file_url,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Regulación creada correctamente.');

            // Mensaje de sesión
            return redirect()->route('institucional_development.regulations.show', $this->regulation->id);
        }
    }

    public function render()
    {
        return view('municipal-regulations.utilities.crud');
    }
}
