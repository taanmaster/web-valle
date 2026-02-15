<?php

namespace App\Livewire\HR\Vacancy;

use Livewire\Component;

use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\On;

use App\Models\HRVacancy;

class Crud extends Component
{
    public $vacancy;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    // Campos
    public $position_name = '';
    public $dependency = '';
    public $employment_type = '';
    public $work_schedule = '';
    public $location = '';
    public $description = '';
    public $requirements = '';
    public $published_at = '';
    public $closing_date = '';
    public $status = '';

    public function mount()
    {
        if ($this->vacancy != null) {
            $this->fetchVacancyData();
        }

        if ($this->mode == 0) {
            $this->published_at = Carbon::now()->format('Y-m-d\TH:i');
        }
    }

    public function fetchVacancyData()
    {
        $this->position_name = $this->vacancy->position_name;
        $this->dependency = $this->vacancy->dependency;
        $this->employment_type = $this->vacancy->employment_type;
        $this->work_schedule = $this->vacancy->work_schedule;
        $this->location = $this->vacancy->location;
        $this->description = $this->vacancy->description;
        $this->requirements = $this->vacancy->requirements;
        $this->status = $this->vacancy->status;
        $this->published_at = $this->vacancy->published_at ? $this->vacancy->published_at->format('Y-m-d\TH:i') : '';
        $this->closing_date = $this->vacancy->closing_date ? $this->vacancy->closing_date->format('Y-m-d\TH:i') : '';
    }

    #[On('updateDescription')]
    public function updateDescription($payload)
    {
        $this->description = $payload;
    }

    #[On('updateRequirements')]
    public function updateRequirements($payload)
    {
        $this->requirements = $payload;
    }

    public function save()
    {
        $this->validate([
            'position_name' => 'required|string|max:255',
            'dependency' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'work_schedule' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable',
            'requirements' => 'nullable',
            'published_at' => 'nullable|date',
            'closing_date' => 'nullable|date',
            'status' => 'required|string|max:255',
        ]);

        if ($this->vacancy != null) {
            $this->vacancy->update([
                'position_name' => $this->position_name,
                'dependency' => $this->dependency,
                'employment_type' => $this->employment_type,
                'work_schedule' => $this->work_schedule,
                'location' => $this->location,
                'description' => $this->description,
                'requirements' => $this->requirements,
                'published_at' => $this->published_at,
                'closing_date' => $this->closing_date,
                'status' => $this->status,
            ]);
        } else {
            HRVacancy::create([
                'position_name' => $this->position_name,
                'dependency' => $this->dependency,
                'employment_type' => $this->employment_type,
                'work_schedule' => $this->work_schedule,
                'location' => $this->location,
                'description' => $this->description,
                'requirements' => $this->requirements,
                'published_at' => $this->published_at,
                'closing_date' => $this->closing_date,
            ]);
        }

        Session::flash('success', 'Vacante guardada exitosamente.');

        return redirect()->route('hr.vacancies.admin.index');
    }

    public function render()
    {
        return view('hr.vacancies.utilities.crud');
    }
}
