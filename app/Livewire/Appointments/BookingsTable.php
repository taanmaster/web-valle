<?php

namespace App\Livewire\Appointments;

use App\Models\AppointmentBooking;
use App\Models\Appointment;
use App\Models\BackofficeDependency;
use Livewire\Component;
use Livewire\WithPagination;

class BookingsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Si se pasa, filtra las citas solo por esta dependencia
    public $dependencyId = null;

    public $search = '';
    public $filterDependency = '';
    public $filterAppointment = '';
    public $filterStatus = '';
    public $filterAttendance = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterDependency = '';
        $this->filterAppointment = '';
        $this->filterStatus = '';
        $this->filterAttendance = '';
        $this->filterDateFrom = '';
        $this->filterDateTo = '';
        $this->resetPage();
    }

    public function markAttendance($bookingId, $status)
    {
        $booking = AppointmentBooking::findOrFail($bookingId);
        $booking->update(['attendance_status' => $status]);
        session()->flash('success', 'Asistencia actualizada correctamente.');
    }

    public function render()
    {
        $bookings = AppointmentBooking::with(['appointment.dependency', 'user'])
            ->when($this->dependencyId, function ($q) {
                $q->whereHas('appointment', function ($q2) {
                    $q2->where('backoffice_dependency_id', $this->dependencyId);
                });
            })
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('folio', 'like', '%' . $this->search . '%')
                        ->orWhere('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterDependency, function ($q) {
                $q->whereHas('appointment', function ($q2) {
                    $q2->where('backoffice_dependency_id', $this->filterDependency);
                });
            })
            ->when($this->filterAppointment, function ($q) {
                $q->where('appointment_id', $this->filterAppointment);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterAttendance, function ($q) {
                if ($this->filterAttendance === 'pending') {
                    $q->whereNull('attendance_status');
                } else {
                    $q->where('attendance_status', $this->filterAttendance);
                }
            })
            ->when($this->filterDateFrom, function ($q) {
                $q->where('date', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateTo, function ($q) {
                $q->where('date', '<=', $this->filterDateTo);
            })
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);

        if ($this->dependencyId) {
            $dependencies = BackofficeDependency::where('id', $this->dependencyId)->get();
            $appointments = Appointment::where('backoffice_dependency_id', $this->dependencyId)->orderBy('name')->get();
        } else {
            $dependencies = BackofficeDependency::orderBy('name')->get();
            $appointments = Appointment::orderBy('name')->get();
        }

        return view('livewire.appointments.bookings-table', [
            'bookings' => $bookings,
            'dependencies' => $dependencies,
            'appointments' => $appointments,
        ]);
    }
}
