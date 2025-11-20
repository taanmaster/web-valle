<?php

namespace App\Livewire\Bidding;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

//Modelo
use App\Models\Bidding;
use App\Models\BiddingFile;
use App\Models\TransparencyDependency;
use App\Models\RegulatoryAgendaDependency;

class Create extends Component
{
    use WithFileUploads;

    //Mode: 0 Create, 2 Edit
    public $mode = 0;

    public $bidding;

    public $fileUpload = false;

    //Campos
    public $folio = '';
    public $title = '';
    public $status = '';
    public $dependency_name = '';
    public $ammount = '';
    public $service = '';
    public $justification = '';
    public $requirement_file = '';
    public $request_file = '';
    public $bidding_type = '';

    public $file_name = '';
    public $file = '';

    public $statusUp = '';

    public $dependencies = [];

    public function mount()
    {
        $this->dependencies = RegulatoryAgendaDependency::get();

        if ($this->mode == 0) {
            // Guardar datos en la base de datos
            $bidding = new Bidding;
            $bidding->status = 'Nueva Licitación';
            $bidding->save();

            $this->bidding = $bidding;
        }

        $this->fetchBidding();
    }

    public function fetchBidding()
    {
        $this->folio = $this->bidding->id;
        $this->title = $this->bidding->title;
        $this->status = $this->bidding->status;
        $this->dependency_name = $this->bidding->dependency_name;
        $this->ammount = $this->bidding->ammount;
        $this->service = $this->bidding->service;
        $this->justification = $this->bidding->justification;
        $this->requirement_file = $this->bidding->requirement_file;
        $this->request_file = $this->bidding->request_file;
        $this->bidding_type = $this->bidding->bidding_type;
    }

    public function addFile()
    {
        $this->fileUpload = true;
    }

    public function saveFile()
    {
        $file = new BiddingFile;
        $file->bidding_id = $this->bidding->id;
        $file->file_name = $this->file_name;
        // --- Request File ---
        $file->file = $this->file
            ? $this->handleUpload($this->file)
            : $file->file;
        $file->save();

        $this->fileUpload = false;

        $this->file_name = '';
        $this->file = '';
    }

    public function deleteFile($id)
    {
        $file = BiddingFile::findOrFail($id);
        $file->delete();
    }

    public function clear()
    {
        // Eliminamos todos los archivos de una
        BiddingFile::where('bidding_id', $this->bidding->id)->delete();

        // Eliminamos la licitación (bidding)
        Bidding::where('id', $this->bidding->id)->delete();

        return redirect()->route('acquisitions.biddings.index');
    }

    public function return()
    {
        return redirect()->route('acquisitions.biddings.index');
    }

    public function save()
    {
        $bidding = Bidding::find($this->bidding->id);

        $bidding->title = $this->title;
        $bidding->dependency_name = $this->dependency_name;
        $bidding->ammount = $this->ammount;
        $bidding->service = $this->service;
        $bidding->justification = $this->justification;
        $bidding->bidding_type = $this->bidding_type;

        // --- Request File ---
        $bidding->request_file = $this->request_file
            ? $this->handleUpload($this->request_file)
            : $bidding->request_file;

        // --- Requirement File ---
        $bidding->requirement_file = $this->requirement_file
            ? $this->handleUpload($this->requirement_file)
            : $bidding->requirement_file;

        $bidding->save();

        return redirect()->route('acquisitions.biddings.show', $bidding->id);
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'acquisitions/biddings/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('livewire.bidding.create');
    }
}
