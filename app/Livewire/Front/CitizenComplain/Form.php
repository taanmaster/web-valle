<?php

namespace App\Livewire\Front\CitizenComplain;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Intervention\Image\Facades\Image as Image;
use Livewire\WithFileUploads;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

//Modelos
use App\Models\CitizenComplain;
use App\Models\CitizenComplainFile;

class Form extends Component
{

    use WithFileUploads;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $complain = '';
    public $subject = '';

    public $files = [];

    public $state;
    public $folio;

    public function removeFile($index)
    {
        unset($this->files[$index]);
    }

    public function save()
    {
        CitizenComplain::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'complain' => $this->complain,
            'subject' => $this->subject,
        ]);

        $this->files = collect($this->files)->map(function ($file) {
            $path = $file->store('complains', 'public');
            $url = Storage::disk('public')->url($path);

            return [
                'name' => $file->getClientOriginalName(),
                'path' => $url,
                'size' => $file->getSize(),
                'type' => $file->getClientMimeType(),
                'extension' => $file->getClientOriginalExtension(),
            ];
        });
        foreach ($this->files as $file) {
            CitizenComplainFile::create([
                'complain_id' => CitizenComplain::latest()->first()->id,
                'name' => $file['name'],
                'filename' => $file['path'],
                'file_extension' => $file['extension'],
            ]);
        }

        $this->state = 'completed';
        $this->folio = CitizenComplain::latest()->first()->id;

        session()->flash('message', 'Su queja ha sido registrada con éxito. Gracias por su colaboración.');

        $this->clean();
    }

    public function clean()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->complain = '';
        $this->subject = '';

        $this->files = [];
        $this->state = '';
        $this->folio = '';
    }

    public function render()
    {
        return view('front.citizen_complain.utilities.form');
    }
}
