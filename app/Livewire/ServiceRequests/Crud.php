<?php

namespace App\Livewire\ServiceRequests;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\ServiceRequest;
use App\Models\TransparencyDependency;


/* Este componente maneja la creación y edición de solicitudes de Desarrollo Institucional */
/* Consume datos de Dependencias de Transparencia */

class Crud extends Component
{
    use WithFileUploads;

    public $request;

    public $dependencies = [];

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $name = '';
    public $dependency_name = '';
    public $description = '';
    public $requirements = '';
    public $cost = '';
    public $steps_filename = '';
    public $procedure_filename = '';

    public function mount()
    {
        if ($this->request != null) {
            $this->fetchRequestData();
        }

        $this->fetchDependencies();
    }

    public function fetchRequestData()
    {
        $this->name = $this->request->name;
        $this->dependency_name = $this->request->dependency_name;
        $this->description = $this->request->description;
        $this->requirements = $this->request->requirements;
        $this->cost = $this->request->cost;
        $this->steps_filename = $this->request->steps_filename;
        $this->procedure_filename = $this->request->procedure_filename;
    }

    public function fetchDependencies()
    {
        $this->dependencies = TransparencyDependency::get();
    }

    public function save()
    {
        if ($this->request != null) {

            $this->request->name = $this->name;
            $this->request->dependency_name = $this->dependency_name;
            $this->request->description = $this->description;
            $this->request->requirements = $this->requirements;
            $this->request->cost = $this->cost;
            $this->request->steps_filename = $this->steps_filename;
            $this->request->procedure_filename = $this->procedure_filename;

            $this->request->save();

            // Mensaje de sesión
            Session::flash('success', 'Dependencia actualizada correctamente.');

            return redirect()->route('institucional_development.requests.show', $this->request->id);
        } else {

            $steps_filename_url = null;
            $procedure_filename_url = null;

            if ($this->steps_filename) {
                $document = $this->steps_filename;

                $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $document->getClientOriginalExtension();

                // Reemplazar espacios y caracteres no válidos
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $filename = $cleanName . '.' . $extension;

                // Crear ruta S3 bajo institutional_development/requests
                $filepath = 'institutional_development/requests/' . $filename;

                // Usar streaming para subir a S3
                $stream = fopen($document->getRealPath(), 'r+');
                Storage::disk('s3')->put($filepath, $stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }

                $steps_filename_url = Storage::disk('s3')->url($filepath);
            }

            if ($this->procedure_filename) {
                $document = $this->procedure_filename;

                $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $document->getClientOriginalExtension();

                // Reemplazar espacios y caracteres no válidos
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $filename = $cleanName . '.' . $extension;

                // Crear ruta S3 bajo institutional_development/requests
                $filepath = 'institutional_development/requests/' . $filename;

                // Usar streaming para subir a S3
                $stream = fopen($document->getRealPath(), 'r+');
                Storage::disk('s3')->put($filepath, $stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }

                $procedure_filename_url = Storage::disk('s3')->url($filepath);
            }

            $this->request = ServiceRequest::create([
                'name' => $this->name,
                'dependency_name' => $this->dependency_name,
                'description' => $this->description,
                'requirements' => $this->requirements,
                'cost' => $this->cost,
                'steps_filename' => $steps_filename_url,
                'procedure_filename' => $procedure_filename_url,
            ]);


            // Mensaje de sesión
            Session::flash('success', 'Registro de Trámite creada correctamente.');

            return redirect()->route('institucional_development.requests.show', $this->request->id);
        }
    }

    public function render()
    {
        return view('service_requests.utilities.crud');
    }
}
