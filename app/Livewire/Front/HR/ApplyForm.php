<?php

namespace App\Livewire\Front\HR;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\HRApplication;
use App\Models\HRVacancy;

class ApplyForm extends Component
{
    use WithFileUploads;

    public $vacancy;

    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $cv;

    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->email = $user->email;
            $this->first_name = $user->name;
        }
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'cv' => 'required|file|mimes:pdf|max:5120',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'cv.required' => 'Debes subir tu CV.',
            'cv.mimes' => 'El CV debe ser un archivo PDF.',
            'cv.max' => 'El CV no puede superar los 5MB.',
        ]);

        // Check if already applied
        $existing = HRApplication::where('user_id', Auth::id())
            ->where('hr_vacancy_id', $this->vacancy->id)
            ->first();

        if ($existing) {
            session()->flash('error', 'Ya has aplicado a esta vacante.');
            return;
        }

        // Upload CV to S3
        $cv_path = null;
        if ($this->cv) {
            $originalName = pathinfo($this->cv->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $this->cv->getClientOriginalExtension();
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $filename = $cleanName . '_' . time() . '.' . $extension;
            $filepath = 'hr/applications/' . $filename;

            $stream = fopen($this->cv->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $cv_path = $filepath;
        }

        $application = HRApplication::create([
            'hr_vacancy_id' => $this->vacancy->id,
            'user_id' => Auth::id(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cv_path' => $cv_path,
        ]);

        // Variables para correos
        $folio      = 'RH-' . str_pad($application->id, 6, '0', STR_PAD_LEFT);
        $plazaArea  = $this->vacancy->position_name . ($this->vacancy->dependency ? ' — ' . $this->vacancy->dependency : '');
        $nombreCompleto = $this->first_name . ' ' . $this->last_name;
        $citizenEmail = $this->email;

        // Correo al ciudadano: postulación recibida
        Mail::send('_mail_notifications.citizen.hr_application_received', [
            'nombre_ciudadano' => $nombreCompleto,
            'folio'            => $folio,
            'plaza_area'       => $plazaArea,
            'fecha_recepcion'  => now()->format('d/m/Y'),
        ], function ($m) use ($citizenEmail, $folio) {
            $m->to($citizenEmail)
              ->subject('Recibimos tu solicitud de empleo — Folio ' . $folio);
        });

        // Correo al ciudadano: confirmación de envío exitoso
        Mail::send('_mail_notifications.citizen.hr_application_sent', [
            'nombre_ciudadano' => $nombreCompleto,
            'folio'            => $folio,
            'plaza_area'       => $plazaArea,
            'fecha_hora_envio' => now()->format('d/m/Y H:i'),
        ], function ($m) use ($citizenEmail, $folio) {
            $m->to($citizenEmail)
              ->subject('Tu postulación fue enviada correctamente — Folio ' . $folio);
        });

        // Correo al administrador: nueva postulación
        Mail::send('_mail_notifications.admin.hr_new_application', [
            'nombre_servidor'  => 'Equipo de Recursos Humanos',
            'folio'            => $folio,
            'nombre_ciudadano' => $nombreCompleto,
            'plaza_area'       => $plazaArea,
        ], function ($m) use ($folio) {
            $m->to('recursos.humanos@valledesantiago.gob.mx')
              ->subject('Nueva postulación recibida — Folio ' . $folio);
        });

        session()->flash('success', 'Tu aplicacion ha sido enviada correctamente.');

        return redirect()->route('citizen.profile.applications.show', $this->vacancy->id);
    }

    public function render()
    {
        return view('front.hr.utilities.apply-form');
    }
}
