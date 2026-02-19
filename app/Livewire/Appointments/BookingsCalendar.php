<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\BackofficeDependency;
use Livewire\Component;

class BookingsCalendar extends Component
{
    public $selectedDependency = '';
    public $selectedAppointment = '';

    public $calendarYear;
    public $calendarMonth;
    public $availabilityData = [];

    public function mount()
    {
        $this->calendarYear = (int) now()->format('Y');
        $this->calendarMonth = (int) now()->format('m');
    }

    // ──────────────────────────────────────────────
    // Reactive Hooks
    // ──────────────────────────────────────────────

    public function updatedSelectedDependency()
    {
        $this->selectedAppointment = '';
        $this->availabilityData = [];
    }

    public function updatedSelectedAppointment()
    {
        if ($this->selectedAppointment) {
            $this->calendarYear = (int) now()->format('Y');
            $this->calendarMonth = (int) now()->format('m');
            $this->loadAvailability();
        } else {
            $this->availabilityData = [];
        }
    }

    // ──────────────────────────────────────────────
    // Calendar Methods
    // ──────────────────────────────────────────────

    public function loadAvailability()
    {
        if (!$this->selectedAppointment) {
            $this->availabilityData = [];
            return;
        }

        $appointment = Appointment::find($this->selectedAppointment);
        if (!$appointment) {
            $this->availabilityData = [];
            return;
        }

        $this->availabilityData = $appointment->getAvailabilityForMonth(
            $this->calendarYear,
            $this->calendarMonth
        );

        $this->dispatch('admin-calendar-updated', [
            'availability' => $this->availabilityData,
            'year' => $this->calendarYear,
            'month' => $this->calendarMonth,
        ]);
    }

    public function onMonthChanged($year, $month)
    {
        $this->calendarYear = (int) $year;
        $this->calendarMonth = (int) $month;
        $this->loadAvailability();
    }

    // ──────────────────────────────────────────────
    // Render
    // ──────────────────────────────────────────────

    public function render()
    {
        $dependencies = BackofficeDependency::whereHas('appointments', function ($q) {
            $q->where('status', true);
        })->orderBy('name')->get();

        $appointments = Appointment::active()
            ->when($this->selectedDependency, function ($q) {
                $q->where('backoffice_dependency_id', $this->selectedDependency);
            })
            ->orderBy('name')
            ->get();

        return view('livewire.appointments.bookings-calendar', [
            'dependencies' => $dependencies,
            'appointments' => $appointments,
        ]);
    }
}
