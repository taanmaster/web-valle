<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\AppointmentSchedule;
use App\Models\BackofficeDependency;
use Livewire\Component;

class Crud extends Component
{
    // Modo: 0 = create, 1 = show, 2 = edit
    public $mode = 0;
    public $appointmentId = null;

    // Campos del trámite
    public $name = '';
    public $backoffice_dependency_id = '';
    public $description = '';
    public $slot_duration = 30;
    public $status = true;

    // Horarios
    public $schedules = [];
    public $newScheduleDay = 1;
    public $newScheduleStart = '08:00';
    public $newScheduleEnd = '14:00';

    protected $rules = [
        'name' => 'required|string|max:255',
        'backoffice_dependency_id' => 'required|exists:backoffice_dependencies,id',
        'description' => 'nullable|string',
        'slot_duration' => 'required|integer|min:5|max:480',
        'status' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'El nombre del trámite es obligatorio.',
        'backoffice_dependency_id.required' => 'Debes seleccionar una dependencia.',
        'backoffice_dependency_id.exists' => 'La dependencia seleccionada no es válida.',
        'slot_duration.required' => 'La duración del slot es obligatoria.',
        'slot_duration.min' => 'La duración mínima es 5 minutos.',
    ];

    public function mount($appointment = null, $mode = 0)
    {
        $this->mode = $mode;

        if ($appointment) {
            $this->appointmentId = $appointment->id;
            $this->name = $appointment->name;
            $this->backoffice_dependency_id = $appointment->backoffice_dependency_id;
            $this->description = $appointment->description ?? '';
            $this->slot_duration = $appointment->slot_duration;
            $this->status = $appointment->status;

            // Cargar horarios existentes
            $this->schedules = $appointment->schedules->map(function ($s) {
                return [
                    'id' => $s->id,
                    'day_of_week' => $s->day_of_week,
                    'start_time' => \Carbon\Carbon::parse($s->start_time)->format('H:i'),
                    'end_time' => \Carbon\Carbon::parse($s->end_time)->format('H:i'),
                ];
            })->toArray();
        }
    }

    public function addSchedule()
    {
        // Validar que no haya traslape
        if ($this->newScheduleStart >= $this->newScheduleEnd) {
            session()->flash('schedule_error', 'La hora de inicio debe ser menor a la hora de fin.');
            return;
        }

        $this->schedules[] = [
            'id' => null,
            'day_of_week' => (int) $this->newScheduleDay,
            'start_time' => $this->newScheduleStart,
            'end_time' => $this->newScheduleEnd,
        ];

        $this->newScheduleDay = 1;
        $this->newScheduleStart = '08:00';
        $this->newScheduleEnd = '14:00';
    }

    public function removeSchedule($index)
    {
        if (isset($this->schedules[$index])) {
            $scheduleId = $this->schedules[$index]['id'] ?? null;

            // Eliminar de BD si tiene ID
            if ($scheduleId) {
                AppointmentSchedule::find($scheduleId)?->delete();
            }

            unset($this->schedules[$index]);
            $this->schedules = array_values($this->schedules);
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->mode === 0) {
            // Crear
            $appointment = Appointment::create([
                'name' => $this->name,
                'slug' => Appointment::generateSlug($this->name),
                'backoffice_dependency_id' => $this->backoffice_dependency_id,
                'description' => $this->description ?: null,
                'slot_duration' => $this->slot_duration,
                'status' => $this->status,
            ]);
        } else {
            // Actualizar
            $appointment = Appointment::findOrFail($this->appointmentId);
            $appointment->update([
                'name' => $this->name,
                'backoffice_dependency_id' => $this->backoffice_dependency_id,
                'description' => $this->description ?: null,
                'slot_duration' => $this->slot_duration,
                'status' => $this->status,
            ]);

            // Eliminar schedules existentes que ya no están
            $existingIds = collect($this->schedules)->pluck('id')->filter()->toArray();
            $appointment->schedules()->whereNotIn('id', $existingIds)->delete();
        }

        // Guardar/actualizar horarios
        foreach ($this->schedules as $schedule) {
            if (isset($schedule['id']) && $schedule['id']) {
                AppointmentSchedule::find($schedule['id'])->update([
                    'day_of_week' => $schedule['day_of_week'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                ]);
            } else {
                $appointment->schedules()->create([
                    'day_of_week' => $schedule['day_of_week'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                ]);
            }
        }

        session()->flash('success', $this->mode === 0 ? 'Trámite creado correctamente.' : 'Trámite actualizado correctamente.');
        return redirect()->route('appointments.index');
    }

    public function render()
    {
        $dependencies = BackofficeDependency::orderBy('name')->get();
        $dayNames = AppointmentSchedule::DAY_NAMES;

        return view('livewire.appointments.crud', [
            'dependencies' => $dependencies,
            'dayNames' => $dayNames,
        ]);
    }
}
