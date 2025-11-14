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

    //Pasos
    public $step = 1;

    //Paso 1
    public $is_agree;
    public $is_aware;
    public $subject = '';

    //Paso 2
    public $ine = '';
    public $anonymus = '';
    public $name = '';
    public $address = '';
    public $suburb = '';
    public $town = '';
    public $email = '';
    public $phone = '';

    public $notification_email = '';
    public $notification_home = '';

    //Paso 3
    public $complain = '';
    public $captcha = '';

    public $files = [];

    public $state;
    public $folio;

    public function removeFile($index)
    {
        unset($this->files[$index]);
    }

    public function nextStep()
    {
        $this->step = $this->step + 1;
    }

    public $captchaHtml;

    public function mount()
    {
        $this->captchaHtml = captcha_img('flat');
    }

    public function reloadCaptcha()
    {
        $this->captchaHtml = captcha_img('flat');
    }

    public function save()
    {
        // Validar captcha
        $this->validate([
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => 'El captcha es obligatorio.',
            'captcha.captcha' => 'El captcha es incorrecto. Por favor, inténtelo de nuevo.',
        ]);

        $savedFiles = collect($this->files)->map(function ($file) {
            $originalName = $file->getClientOriginalName();
            $cleanName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalName);
            $filename = time() . '_' . $cleanName;

            // Guarda en storage/app/public/complains
            $path = $file->storePubliclyAs('complains', $filename, 'public');

            // URL accesible vía navegador
            $url = Storage::url($path);

            return [
                'name' => $originalName,
                'path' => $url,
                'size' => $file->getSize(),
                'type' => $file->getClientMimeType(),
                'extension' => $file->getClientOriginalExtension(),
            ];
        });

        $complain = CitizenComplain::create([
            // Paso 1
            'is_agree' => $this->is_agree,
            'is_aware' => $this->is_aware,
            'subject' => $this->subject,

            // Paso 2
            'ine' => $this->ine,
            'anonymus' => $this->anonymus,
            'name' => $this->name,
            'address' => $this->address,
            'suburb' => $this->suburb,
            'town' => $this->town,
            'email' => $this->email,
            'phone' => $this->phone,

            // Notificaciones
            'notification_email' => $this->notification_email,
            'notification_home' => $this->notification_home,

            // Mensaje
            'message' => $this->complain,
        ]);

        foreach ($savedFiles as $file) {
            CitizenComplainFile::create([
                'complain_id' => $complain->id,
                'name' => $file['name'],
                'filename' => $file['path'],
                'file_extension' => $file['extension'],
            ]);
        }

        $this->state = 'completed';
        $this->folio = CitizenComplain::latest()->first()->id;

        // Limpiar captcha después de envío exitoso
        $this->captcha = '';

        session()->flash('message', 'Su queja ha sido registrada con éxito. Gracias por su colaboración.');
    }

    public function getStep2CompleteProperty()
    {
        return
            !empty($this->ine) &&
            !empty($this->name) &&
            !empty($this->address) &&
            !empty($this->suburb) &&
            !empty($this->town) &&
            !empty($this->email) &&
            !empty($this->phone);
    }

    public function clean()
    {
        // Paso 1
        $this->is_agree = '';
        $this->is_aware = '';
        $this->subject = '';

        // Paso 2
        $this->ine = '';
        $this->anonymus = '';
        $this->name = '';
        $this->address = '';
        $this->suburb = '';
        $this->town = '';
        $this->email = '';
        $this->phone = '';

        // Notificaciones
        $this->notification_email = '';
        $this->notification_home = '';

        // Mensaje
        $this->complain = '';

        $this->captcha = '';
        $this->files = [];
        $this->state = '';
        $this->folio = '';
    }

    public function render()
    {
        return view('front.citizen_complain.utilities.form');
    }
}
