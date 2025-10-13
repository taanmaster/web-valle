<?php

namespace App\Livewire\Summons;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use App\Models\Summon;

class Crud extends Component
{
    use WithFileUploads;

    public $summon;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $expiration_date = '';
    public $folio = '';
    public $number = '';


    public $searchCitizen = '';
    public $selectedCitizen = '';

    public $citizen_id = '';
    public $full_name = '';

    public $street = '';
    public $external_number = '';
    public $suburb = '';

    public $details = '';
    public $file = '';

    public $searchWorker = '';
    public $worker_id = '';
    public $worker_name = '';
    public $selectedWorker = '';


    public $followup_type = '';
    public $followup_comment = '';

    public function mount()
    {
        if ($this->summon != null) {
            $this->fetchSummonData();
        }
    }

    public function fetchSummonData()
    {
        $this->expiration_date = \Carbon\Carbon::parse($this->summon->expiration_date)->format('Y-m-d');

        $this->folio = $this->summon->folio;
        $this->number = $this->summon->number;

        $this->citizen_id = $this->summon->citizen_id;
        $this->full_name = $this->summon->full_name;

        $this->selectedCitizen = \App\Models\Citizen::find($this->citizen_id);

        $this->street = $this->summon->street;
        $this->external_number = $this->summon->external_number;
        $this->suburb = $this->summon->suburb;

        $this->details = $this->summon->details;
        $this->file = $this->summon->file;

        $this->worker_id = $this->summon->worker_id;
        $this->worker_name = $this->summon->worker ? $this->summon->worker->name . ' ' . $this->summon->worker->last_name : '';
        $this->selectedWorker = \App\Models\UrbanDevWorker::find($this->worker_id);
    }

    public function save()
    {
        // Validación de datos
        $this->validate([
            'expiration_date' => 'required|date',
            'folio' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'citizen_id' => 'nullable|integer',
            'full_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'external_number' => 'nullable|string|max:50',
            'suburb' => 'nullable|string|max:255',
            'details' => 'nullable|string|max:1000',
            'worker_id' => 'required|integer',
            'file' => $this->summon
                ? 'nullable|file|max:10240' // 10 MB
                : 'nullable|file|max:10240',
        ], [
            'expiration_date.required' => 'La fecha de vencimiento es obligatoria.',
            'expiration_date.after_or_equal' => 'La fecha de vencimiento no puede ser anterior a hoy.',
            'folio.required' => 'El folio es obligatorio.',
            'number.required' => 'El número de citatorio es obligatorio.',
            'full_name.required' => 'El nombre completo es obligatorio.',
            'street.required' => 'La calle es obligatoria.',
            'worker_id.required' => 'Debes seleccionar un trabajador.',
            'file.required' => 'Debes subir un archivo.',
            'file.max' => 'El archivo no puede superar los 10 MB.',
        ]);


        if ($this->summon != null) {

            // --- Subida de archivos si hay nuevos ---
            $file_url = $this->file ? $this->handleUpload($this->file) : $this->summon->file;

            $this->summon->update([
                'expiration_date' => $this->expiration_date,
                'folio' => $this->folio,
                'number' => $this->number,
                'citizen_id' => $this->citizen_id,
                'full_name' => $this->full_name,
                'street' => $this->street,
                'external_number' => $this->external_number,
                'suburb' => $this->suburb,
                'details' => $this->details,
                'file' => $file_url,
                'worker_id' => $this->worker_id,
            ]);

            Session::flash('message', 'Citación actualizada correctamente.');
        } else {

            $file_url = null;
            // --- Subida de archivos ---
            if ($this->file) {
                $file_url = $this->handleUpload($this->file);
            }

            Summon::create([
                'expiration_date' => $this->expiration_date,
                'folio' => $this->folio,
                'number' => $this->number,
                'citizen_id' => $this->citizen_id,
                'full_name' => $this->full_name,
                'street' => $this->street,
                'external_number' => $this->external_number,
                'suburb' => $this->suburb,
                'details' => $this->details,
                'file' => $file_url,
                'worker_id' => $this->worker_id,
            ]);

            Session::flash('message', 'Citación creada correctamente.');
        }

        return redirect()->route('summons.index');
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'summons/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function selectCitizen($citizen_id)
    {
        $this->citizen_id = $citizen_id;

        $citizen = \App\Models\Citizen::find($citizen_id);
        if ($citizen) {
            $this->full_name = $citizen->name . ' ' . $citizen->first_name . ' ' . $citizen->last_name;
        }

        $this->selectedCitizen = $citizen;

        $this->searchCitizen = '';
    }

    public function clearCitizen()
    {
        $this->full_name = '';
        $this->citizen_id = '';

        $this->selectedCitizen = null;
    }

    public function selectWorker($worker_id)
    {
        $this->worker_id = $worker_id;

        $worker = \App\Models\UrbanDevWorker::find($worker_id);
        if ($worker) {
            $this->worker_name = $worker->name . ' ' . $worker->last_name;
        }

        $this->selectedWorker = $worker;

        $this->searchWorker = '';
    }

    public function clearWorker()
    {
        $this->worker_id = '';
        $this->worker_name = '';
        $this->selectedWorker = null;

        $this->searchWorker = '';
    }

    public function saveFollowup()
    {
        $this->validate([
            'details' => 'required|string',
        ]);

        if ($this->summon) {
            $this->summon->followups()->create([
                'summon_id' => $this->summon->id,
                'followup_type' => $this->followup_type,
                'notes' => $this->followup_comment,
            ]);

            $this->followup_type = '';
            $this->followup_comment = '';

            Session::flash('message', 'Seguimiento creado correctamente.');

            $this->fetchSummonData();
        }
    }

    public function render()
    {
        return view('summons.utilities.crud');
    }
}
