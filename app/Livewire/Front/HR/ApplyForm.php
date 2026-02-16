<?php

namespace App\Livewire\Front\HR;

use Livewire\Component;
use Livewire\WithFileUploads;
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

        HRApplication::create([
            'hr_vacancy_id' => $this->vacancy->id,
            'user_id' => Auth::id(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cv_path' => $cv_path,
        ]);

        session()->flash('success', 'Tu aplicacion ha sido enviada correctamente.');

        return redirect()->route('citizen.profile.applications.show', $this->vacancy->id);
    }

    public function render()
    {
        return view('front.hr.utilities.apply-form');
    }
}
