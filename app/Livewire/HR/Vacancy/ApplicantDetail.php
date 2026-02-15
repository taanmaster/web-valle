<?php

namespace App\Livewire\HR\Vacancy;

use Livewire\Component;

use App\Models\HRApplication;

class ApplicantDetail extends Component
{
    public $application;
    public $observations = '';

    public function mount()
    {
        if ($this->application) {
            $this->observations = $this->application->observations ?? '';
        }
    }

    public function saveObservations()
    {
        $this->application->update([
            'observations' => $this->observations,
        ]);

        session()->flash('observation_saved', 'Observaciones guardadas correctamente.');
    }

    public function render()
    {
        return view('hr.vacancies.utilities.applicant-detail');
    }
}
