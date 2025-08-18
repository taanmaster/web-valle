<?php

namespace App\Livewire\MunicipalRegulations;

// Ayudantes
use Str;
use Auth;
use Session;
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

            if ($this->file) {
                $document = $this->file;

                $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $document->getClientOriginalExtension();

                // Reemplazar espacios y caracteres no válidos
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                $filename_one = $cleanName . '.' . $extension;

                // Guardar en storage/app/public/requests/
                $path = $document->storeAs('regulations', $filename_one, 'public');
            }

            if ($this->pdf_file) {
                $document = $this->pdf_file;

                $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $document->getClientOriginalExtension();

                // Reemplazar espacios y caracteres no válidos
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                $filename_two = $cleanName . '.' . $extension;

                // Guardar en storage/app/public/regulations/
                $path = $document->storeAs('regulations', $filename_two, 'public');
            }

            if ($this->word_file) {
                $document = $this->word_file;

                $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $document->getClientOriginalExtension();

                // Reemplazar espacios y caracteres no válidos
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                $filename_three = $cleanName . '.' . $extension;

                // Guardar en storage/app/public/regulations/
                $path = $document->storeAs('regulations', $filename_three, 'public');
            }

            $this->regulation = MunicipalRegulation::create([
                'title' => $this->title,
                'regulation_type' => $this->regulation_type,
                'publication_type' => $this->publication_type,
                'publication_date' => $this->publication_date,
                'file' => $filename_one,
                'pdf_file' => $filename_two,
                'word_file' => $filename_three,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Dependencia creada correctamente.');

            // Mensaje de sesión
            return redirect()->route('institucional_development.regulations.show', $this->regulation->id);
        }
    }

    public function render()
    {
        return view('municipal-regulations.utilities.crud');
    }
}
