<?php

namespace App\Livewire\MunicipalInspection;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use App\Models\MunicipalInspection;

class Crud extends Component
{
    use WithFileUploads;

    public $inspection;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $name = '';
    public $file = '';
    public $dependency = '';
    public $year = '';
    public $is_active = true;


    public $years = ['2028', '2027', '2026', '2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015'];
    public $dependencies = ['Fiscalización', 'SAPAM', 'Contraloría', 'Protección Civil', 'Bienestar', 'Seguridad Pública', 'Desarrollo Urbano', 'Medio Ambiente', 'Obras Públicas'];

    public function mount()
    {
        if ($this->inspection != null) {
            $this->fetchInspectionData();
        }
    }

    public function fetchInspectionData()
    {
        $this->name = $this->inspection->name;
        $this->file = $this->inspection->file;
        $this->dependency = $this->inspection->dependency;
        $this->year = $this->inspection->year;
        $this->is_active = $this->inspection->is_active;
    }

    public function save()
    {
        if ($this->inspection != null) {

            // --- Subida de archivos si hay nuevos ---
            $file_url = $this->file ? $this->handleUpload($this->file) : $this->inspection->file;

            $this->inspection->update([
                'name' => $this->name,
                'file' => $file_url,
                'dependency' => $this->dependency,
                'year' => $this->year,
                'is_active' => $this->is_active,
            ]);

            Session::flash('message', 'Inspección municipal actualizada correctamente.');
        } else {
            $file_url = null;

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

            MunicipalInspection::create([
                'name' => $this->name,
                'file' => $file_url,
                'dependency' => $this->dependency,
                'year' => $this->year,
                'is_active' => $this->is_active,
            ]);

            Session::flash('message', 'Inspección municipal creada correctamente.');
        }

        // Optionally, redirect or change mode after saving
        return redirect()->route('municipal_inspections.index');
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'municipal_inspections/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('municipal_inspections.utilities.crud');
    }
}
