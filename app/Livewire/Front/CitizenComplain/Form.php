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
use ZipArchive;

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
    public $captchaHtml;

    public $notification_email = '';
    public $notification_home = '';

    //Paso 3
    public $complain = '';

    #[Validate('required')]
    public $captcha = null;

    public $files = [];

    public $state;
    public $folio;

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files); // reindexa correctamente
    }

    public function nextStep()
    {
        try {
            $this->validate($this->rulesForStep());
        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->dispatch('issue', message: 'Completa los campos requeridos antes de continuar.');

            throw $e;
        }

        $this->step++;
    }

    public function mount()
    {
        $this->captchaHtml = captcha_img('flat');
    }

    public function reloadCaptcha()
    {
        $this->captchaHtml = captcha_img('flat');
    }

    public function updatedCaptcha($token)
    {
        $response = Http::post(
            'https://www.google.com/recaptcha/api/siteverify?secret=' .
                config('services.recaptcha.secret_key') .
                '&response=' . $token
        );

        $success = $response->json()['success'];

        if (! $success) {
            throw ValidationException::withMessages([
                'captcha' => __('Refresca la pantalla e intenta de nuevo!'),
            ]);
        } else {
            $this->captcha = true;
        }
    }


    public function save()
    {
        // Validar captcha
        $this->validate([
            'captcha' => 'required|captcha',
            'complain' => 'required|string|min:10',
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

        // Imagen responsiva en Banner
        $ineFilename = null;

        if ($this->ine) {
            $image = $this->ine;

            // Nombre del archivo
            $ineFilename = 'ine_' . time() . '.' . $image->getClientOriginalExtension();

            // Ruta en public/
            $location = public_path('ine/' . $ineFilename);

            // Redimensionar y guardar (opcional)
            Image::make($image)
                ->resize(1280, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($location);
        }

        $complain = new CitizenComplain;

        // Paso 1
        $complain->is_agree = $this->is_agree;
        $complain->is_aware = $this->is_aware;
        $complain->subject = $this->subject;

        // Paso 2
        $complain->ine = $this->ine
            ? $this->handleUpload($this->ine)
            : $complain->ine;
        $complain->anonymus = $this->anonymus;
        $complain->name = $this->name;
        $complain->address = $this->address;
        $complain->suburb = $this->suburb;
        $complain->town = $this->town;
        $complain->email = $this->email;
        $complain->phone = $this->phone;

        // Notificaciones
        $complain->notification_email = $this->notification_email;
        $complain->notification_home = $this->notification_home;

        //Mensaje
        $complain->message = $this->complain;

        $complain->save();

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

    public function rulesForStep()
    {
        switch ($this->step) {

            case 1:
                return [
                    'is_agree' => 'required|accepted',
                    'is_aware' => 'required|accepted',
                    'subject'  => 'required|string|min:5',
                ];

            case 2:
                return [
                    'name'    => 'required|string|min:3',
                    'email'   => 'required|email',
                    'phone'   => 'required|string|min:10',

                    // Campos que también pides en Step 2
                    'address' => 'required|string',
                    'suburb'  => 'required|string',
                    'town'    => 'required|string',

                    'ine'     => 'required',
                ];

            case 3:
                return [
                    'complain' => 'required|string|min:10',
                ];

            default:
                return [];
        }
    }

    public function back()
    {
        $this->step = $this->step - 1;
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
        return view('front.citizen_complain.utilities.form');
    }
}
