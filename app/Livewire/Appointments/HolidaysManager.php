<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\AppointmentHoliday;
use Livewire\Component;

class HolidaysManager extends Component
{
    public $appointmentId;
    public $appointmentName = '';
    public $hideBackButton = false;

    public $newDate = '';
    public $newReason = '';

    protected $rules = [
        'newDate' => 'required|date|after_or_equal:today',
        'newReason' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'newDate.required' => 'La fecha es obligatoria.',
        'newDate.after_or_equal' => 'La fecha debe ser hoy o posterior.',
    ];

    public function mount(Appointment $appointment)
    {
        $this->appointmentId = $appointment->id;
        $this->appointmentName = $appointment->name;
    }

    public function addHoliday()
    {
        $this->validate();

        // Verificar duplicado
        $exists = AppointmentHoliday::where('appointment_id', $this->appointmentId)
            ->where('date', $this->newDate)
            ->exists();

        if ($exists) {
            session()->flash('holiday_error', 'Esta fecha ya está registrada como día inhábil.');
            return;
        }

        AppointmentHoliday::create([
            'appointment_id' => $this->appointmentId,
            'date' => $this->newDate,
            'reason' => $this->newReason ?: null,
        ]);

        $this->newDate = '';
        $this->newReason = '';

        session()->flash('holiday_success', 'Día inhábil agregado correctamente.');
    }

    public function removeHoliday($id)
    {
        AppointmentHoliday::where('id', $id)
            ->where('appointment_id', $this->appointmentId)
            ->delete();

        session()->flash('holiday_success', 'Día inhábil eliminado correctamente.');
    }

    public function render()
    {
        $holidays = AppointmentHoliday::where('appointment_id', $this->appointmentId)
            ->orderBy('date')
            ->get();

        return view('livewire.appointments.holidays-manager', [
            'holidays' => $holidays,
        ]);
    }
}
