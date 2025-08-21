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

use App\Models\MunicipalRegulationLog;

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

            // --- Subida de archivos si hay nuevos ---
            $file_url = $this->file ? $this->handleUpload($this->file) : $this->regulation->file;
            $pdf_file_url = $this->pdf_file ? $this->handleUpload($this->pdf_file) : $this->regulation->pdf_file;
            $word_file_url = $this->word_file ? $this->handleUpload($this->word_file) : $this->regulation->word_file;

            // --- Llenar sin guardar aún ---
            $this->regulation->fill([
                'title'             => $this->title,
                'regulation_type'   => $this->regulation_type,
                'publication_type'  => $this->publication_type,
                'publication_date'  => $this->publication_date,
                'file'              => $file_url,
                'pdf_file'          => $pdf_file_url,
                'word_file'         => $word_file_url,
            ]);

            // Detectar cambios
            $changes = $this->regulation->getDirty();

            // Guardar cambios
            $this->regulation->save();

            // Registrar log si hubo cambios
            if (!empty($changes)) {
                $logMessageParts = [];

                // Mapeo de nombres de campos a español
                $fieldNames = [
                    'title'             => 'Título',
                    'regulation_type'   => 'Tipo de regulación',
                    'publication_type'  => 'Tipo de publicación',
                    'publication_date'  => 'Fecha de publicación',
                    'file'              => 'Archivo',
                    'pdf_file'          => 'Archivo PDF',
                    'word_file'         => 'Archivo Word',
                ];

                foreach ($changes as $field => $newValue) {
                    $oldValue = $this->regulation->getOriginal($field);

                    // Convertir null a texto legible
                    $oldValue = $oldValue ?? 'Vacío';
                    $newValue = $newValue ?? 'Vacío';

                    $label = $fieldNames[$field] ?? ucfirst($field);
                    $logMessageParts[] = "$label: \"$oldValue\" → \"$newValue\"";
                }

                $logMessage = implode(', ', $logMessageParts);

                MunicipalRegulationLog::create([
                    'regulation_id' => $this->regulation->id,
                    'action'        => $logMessage,
                    'user_id'       => Auth::id(),
                ]);
            }

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
        return view('municipal_regulations.utilities.crud');
    }
}
