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
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
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
    public $anonymus = false;
    public $name = '';
    public $address = '';
    public $suburb = '';
    public $town = '';
    public $email = '';
    public $phone = '';
    public $captchaHtml;

    public $notification_email = false;
    public $notification_home = false;

    //Paso 3
    public $complain = '';

    #[Validate('required')]
    public $captcha = null;

    public $files = [];

    // Tipos de archivo permitidos
    const INE_MIMES   = 'jpg,jpeg,png,pdf';
    const FILE_MIMES  = 'jpg,jpeg,png,pdf,doc,docx';
    const MAX_KB      = 10240; // 10 MB por archivo

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
            $this->validate($this->rulesForStep(), $this->messagesForStep());
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

    /**
     * Verifica el token de reCAPTCHA contra Google.
     * Se hace al momento del envío para evitar estados intermedios
     * en los que el formulario "a veces" no permite finalizar.
     */
    protected function verifyCaptcha(): bool
    {
        if (empty($this->captcha) || $this->captcha === true) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => config('services.recaptcha.secret_key'),
                'response' => $this->captcha,
            ]);

            return (bool) ($response->json('success') ?? false);
        } catch (\Throwable $e) {
            return false;
        }
    }


    public function save()
    {
        // Verificar el captcha en el momento del envío
        if (! $this->verifyCaptcha()) {
            $this->captcha = null;
            $this->dispatch('reset-captcha');

            throw ValidationException::withMessages([
                'captcha' => 'No pudimos validar el captcha. Vuelve a marcarlo e intenta de nuevo.',
            ]);
        }

        $this->validate([
            'complain' => 'required|string|min:10',
            'files'    => 'nullable|array|max:5',
            'files.*'  => 'file|mimes:' . self::FILE_MIMES . '|max:' . self::MAX_KB,
        ], [
            'complain.required' => 'La descripción es obligatoria.',
            'complain.min'      => 'La descripción debe tener al menos 10 caracteres.',
            'files.max'         => 'Puedes adjuntar como máximo 5 archivos.',
            'files.*.mimes'     => 'Solo se permiten archivos JPG, PNG, PDF, DOC o DOCX.',
            'files.*.max'       => 'Cada archivo no debe superar los 10 MB.',
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

        // El PDF se guarda tal cual (vía handleUpload más abajo); solo las
        // imágenes se redimensionan con GD.
        if ($this->ine && str_starts_with((string) $this->ine->getClientMimeType(), 'image/')) {
            $image = $this->ine;

            // Nombre del archivo
            $ineFilename = 'ine_' . time() . '.' . $image->getClientOriginalExtension();

            // Ruta en public/
            $location = public_path('ine/' . $ineFilename);

            // Redimensionar y guardar (opcional). Se protege con try/catch
            // para que un archivo no soportado nunca aborte el envío completo.
            try {
                Image::make($image)
                    ->resize(1280, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($location);
            } catch (\Throwable $e) {
                throw ValidationException::withMessages([
                    'ine' => 'No pudimos procesar la imagen del INE. Asegúrate de subir una imagen JPG o PNG, o un PDF.',
                ]);
            }
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
                    'phone'   => ['required', 'regex:/^[0-9]{10}$/'],

                    // Campos que también pides en Step 2
                    'address' => 'required|string',
                    'suburb'  => 'required|string',
                    'town'    => 'required|string',

                    // El INE acepta imagen (JPG/PNG) o PDF. Las imágenes se
                    // redimensionan con GD; el PDF se guarda tal cual.
                    'ine'     => 'required|mimes:' . self::INE_MIMES . '|max:' . self::MAX_KB,
                ];

            case 3:
                return [
                    'complain' => 'required|string|min:10',
                ];

            default:
                return [];
        }
    }

    public function messagesForStep()
    {
        switch ($this->step) {

            case 1:
                return [
                    'is_agree.required' => 'Debes aceptar el manejo de tus datos personales.',
                    'is_agree.accepted' => 'Debes aceptar el manejo de tus datos personales.',
                    'is_aware.required' => 'Debes confirmar que conoces el uso de esta plataforma.',
                    'is_aware.accepted' => 'Debes confirmar que conoces el uso de esta plataforma.',
                    'subject.required'  => 'Selecciona el tipo de trámite que presentas.',
                    'subject.min'       => 'Selecciona una opción válida.',
                ];

            case 2:
                return [
                    'name.required'    => 'El nombre es obligatorio.',
                    'email.required'   => 'El correo electrónico es obligatorio.',
                    'email.email'      => 'Ingresa un correo electrónico válido.',
                    'phone.required'   => 'El teléfono es obligatorio.',
                    'phone.regex'      => 'El teléfono debe contener exactamente 10 dígitos (solo números).',
                    'address.required' => 'La calle y número son obligatorios.',
                    'suburb.required'  => 'La colonia es obligatoria.',
                    'town.required'    => 'El municipio es obligatorio.',
                    'ine.required'     => 'Debes adjuntar una copia de tu INE.',
                    'ine.mimes'        => 'El INE debe ser una imagen JPG o PNG, o un archivo PDF.',
                    'ine.max'          => 'El archivo del INE no debe superar los 10 MB.',
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
        $this->anonymus = false;
        $this->name = '';
        $this->address = '';
        $this->suburb = '';
        $this->town = '';
        $this->email = '';
        $this->phone = '';

        // Notificaciones
        $this->notification_email = false;
        $this->notification_home = false;

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
