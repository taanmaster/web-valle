<?php

namespace App\Livewire\Front\Appointments;

use App\Models\Appointment;
use App\Models\AppointmentBooking;
use App\Models\BackofficeDependency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppointmentBookingWizard extends Component
{
    // Paso actual del wizard
    public $step = 1;

    // Paso 1: Selección de dependencia y trámite
    public $selectedDependency = '';
    public $selectedAppointment = '';
    public $availableAppointments = [];

    // Paso 2: Calendario - mes actual
    public $calendarYear;
    public $calendarMonth;
    public $availabilityData = [];
    public $selectedDate = '';

    // Paso 3: Horarios disponibles
    public $availableSlots = [];
    public $selectedSlot = '';

    // Paso 4: Datos del ciudadano
    public $fullName = '';
    public $email = '';
    public $phone = '';
    public $notes = '';

    // Referencias
    public $appointmentName = '';
    public $dependencyName = '';

    protected $listeners = [
        'dateSelected' => 'onDateSelected',
        'monthChanged' => 'onMonthChanged',
    ];

    public function mount()
    {
        $this->calendarYear = (int) date('Y');
        $this->calendarMonth = (int) date('m');

        // Verificar si hay una booking pendiente en sesión (post-login)
        $pending = session('pending_booking');
        if ($pending && Auth::check()) {
            $this->selectedAppointment = $pending['appointment_id'] ?? '';
            $this->selectedDate = $pending['date'] ?? '';
            $this->selectedSlot = $pending['start_time'] ?? '';

            if ($this->selectedAppointment) {
                $appointment = Appointment::with('dependency')->find($this->selectedAppointment);
                if ($appointment) {
                    $this->selectedDependency = $appointment->backoffice_dependency_id;
                    $this->appointmentName = $appointment->name;
                    $this->dependencyName = $appointment->dependency->name ?? '';
                    $this->availableAppointments = Appointment::active()
                        ->where('backoffice_dependency_id', $this->selectedDependency)
                        ->get()->toArray();

                    if ($this->selectedDate && $this->selectedSlot) {
                        $this->loadSlots();
                        $this->prefillUserData();
                        $this->step = 4;
                    } elseif ($this->selectedDate) {
                        $this->loadSlots();
                        $this->step = 2;
                    } else {
                        $this->loadAvailability();
                        $this->step = 2;
                    }
                }
            }

            session()->forget('pending_booking');
        }
    }

    // ──────────────────────────────────────────────
    // Paso 1: Selección
    // ──────────────────────────────────────────────

    public function updatedSelectedDependency($value)
    {
        $this->selectedAppointment = '';
        $this->selectedDate = '';
        $this->selectedSlot = '';
        $this->availableSlots = [];
        $this->availabilityData = [];
        $this->step = 1;

        if ($value) {
            $this->availableAppointments = Appointment::active()
                ->where('backoffice_dependency_id', $value)
                ->orderBy('name')
                ->get()
                ->toArray();

            $dep = BackofficeDependency::find($value);
            $this->dependencyName = $dep ? $dep->name : '';
        } else {
            $this->availableAppointments = [];
            $this->dependencyName = '';
        }
    }

    public function updatedSelectedAppointment($value)
    {
        $this->selectedDate = '';
        $this->selectedSlot = '';
        $this->availableSlots = [];
        $this->availabilityData = [];

        if ($value) {
            $appointment = Appointment::find($value);
            $this->appointmentName = $appointment ? $appointment->name : '';
            $this->calendarYear = (int) date('Y');
            $this->calendarMonth = (int) date('m');
            $this->loadAvailability();
            $this->step = 2;
            $this->dispatch('calendar-updated',
                availability: $this->availabilityData,
                year: $this->calendarYear,
                month: $this->calendarMonth
            );
        } else {
            $this->appointmentName = '';
            $this->step = 1;
        }
    }

    // ──────────────────────────────────────────────
    // Paso 2: Calendario
    // ──────────────────────────────────────────────

    public function loadAvailability()
    {
        if (!$this->selectedAppointment) return;

        $appointment = Appointment::find($this->selectedAppointment);
        if (!$appointment) return;

        $this->availabilityData = $appointment->getAvailabilityForMonth(
            $this->calendarYear,
            $this->calendarMonth
        );
    }

    public function onMonthChanged($year, $month)
    {
        $this->calendarYear = (int) $year;
        $this->calendarMonth = (int) $month;
        $this->loadAvailability();
        $this->dispatch('calendar-updated',
            availability: $this->availabilityData,
            year: $this->calendarYear,
            month: $this->calendarMonth
        );
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->subMonth();

        // No permitir navegar al pasado
        if ($date->lt(Carbon::now()->startOfMonth())) {
            return;
        }

        $this->calendarYear = $date->year;
        $this->calendarMonth = $date->month;
        $this->loadAvailability();
        $this->dispatch('calendar-updated',
            availability: $this->availabilityData,
            year: $this->calendarYear,
            month: $this->calendarMonth
        );
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->addMonth();

        // No permitir navegar más de 3 meses en el futuro
        $maxDate = Carbon::now()->addMonths(3)->endOfMonth();
        if ($date->gt($maxDate)) {
            return;
        }

        $this->calendarYear = $date->year;
        $this->calendarMonth = $date->month;
        $this->loadAvailability();
        $this->dispatch('calendar-updated',
            availability: $this->availabilityData,
            year: $this->calendarYear,
            month: $this->calendarMonth
        );
    }

    public function onDateSelected($date)
    {
        if (!$this->selectedAppointment) return;

        // Verificar que el día tiene disponibilidad
        $dayData = $this->availabilityData[$date] ?? null;
        if (!$dayData || $dayData['available'] === 0) return;

        $this->selectedDate = $date;
        $this->loadSlots();
    }

    public function selectDate($date)
    {
        if (!$this->selectedAppointment) return;

        // Validar que la fecha no sea pasada
        $carbonDate = Carbon::parse($date);
        if ($carbonDate->lt(Carbon::today())) return;

        // No depender de availabilityData cacheada; cargar slots directamente
        $this->selectedDate = $date;
        $this->selectedSlot = '';
        $this->loadSlots();
    }

    // ──────────────────────────────────────────────
    // Paso 3: Horarios
    // ──────────────────────────────────────────────

    private function loadSlots()
    {
        if (!$this->selectedAppointment || !$this->selectedDate) return;

        $appointment = Appointment::find($this->selectedAppointment);
        if (!$appointment) return;

        $this->availableSlots = $appointment->generateSlots($this->selectedDate);
    }

    public function selectSlot($startTime)
    {
        // Verificar autenticación
        if (!Auth::check()) {
            // Guardar datos en sesión para post-login
            session(['pending_booking' => [
                'appointment_id' => $this->selectedAppointment,
                'date' => $this->selectedDate,
                'start_time' => $startTime,
            ]]);

            return redirect()->route('login');
        }

        $this->selectedSlot = $startTime;
        $this->prefillUserData();
        $this->step = 4;
    }

    private function prefillUserData()
    {
        if (!Auth::check()) return;

        $user = Auth::user();
        $this->fullName = $user->name ?? '';
        $this->email = $user->email ?? '';

        // Intentar obtener teléfono del perfil ciudadano
        $citizen = \App\Models\Citizen::where('email', $user->email)->first();
        $this->phone = $citizen->phone ?? '';
    }

    // ──────────────────────────────────────────────
    // Paso 4: Confirmación y Agendamiento
    // ──────────────────────────────────────────────

    public function bookAppointment()
    {
        $this->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'selectedAppointment' => 'required|exists:appointments,id',
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedSlot' => 'required',
        ], [
            'fullName.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'phone.required' => 'El teléfono es obligatorio.',
        ]);

        $appointment = Appointment::find($this->selectedAppointment);
        if (!$appointment) {
            session()->flash('booking_error', 'El trámite seleccionado no existe.');
            return;
        }

        // Calcular hora de fin
        $endTime = Carbon::parse($this->selectedSlot)
            ->addMinutes($appointment->slot_duration)
            ->format('H:i');

        // Verificar que el slot sigue disponible
        $exists = AppointmentBooking::where('appointment_id', $this->selectedAppointment)
            ->where('date', $this->selectedDate)
            ->where('start_time', $this->selectedSlot)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            session()->flash('booking_error', 'Lo sentimos, este horario ya fue tomado por otro ciudadano. Por favor selecciona otro horario.');
            $this->loadSlots();
            $this->step = 2;
            return;
        }

        // Crear la cita
        $booking = AppointmentBooking::create([
            'folio' => AppointmentBooking::generateFolio(),
            'appointment_id' => $this->selectedAppointment,
            'user_id' => Auth::id(),
            'date' => $this->selectedDate,
            'start_time' => $this->selectedSlot,
            'end_time' => $endTime,
            'status' => 'scheduled',
            'full_name' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'notes' => $this->notes ?: null,
        ]);

        // Redirigir al perfil ciudadano con el detalle de la cita
        return redirect()->route('citizen.appointments.show', [
            'booking' => $booking->id,
            'just_booked' => 1,
        ]);
    }

    public function goBack()
    {
        if ($this->step === 4) {
            $this->step = 2;
            $this->selectedSlot = '';
        } elseif ($this->step === 2) {
            $this->step = 1;
            $this->selectedDate = '';
            $this->selectedSlot = '';
            $this->availableSlots = [];
        }
    }

    // ──────────────────────────────────────────────
    // Render
    // ──────────────────────────────────────────────

    public function render()
    {
        $dependencies = BackofficeDependency::whereHas('appointments', function ($q) {
            $q->where('status', true);
        })->orderBy('name')->get();

        return view('livewire.front.appointments.appointment-booking-wizard', [
            'dependencies' => $dependencies,
        ]);
    }
}
