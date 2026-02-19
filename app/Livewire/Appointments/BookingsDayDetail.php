<?php

namespace App\Livewire\Appointments;

use App\Exports\AppointmentBookingsExport;
use App\Models\Appointment;
use App\Models\AppointmentBooking;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class BookingsDayDetail extends Component
{
    public $appointmentId;
    public $date;

    public function mount($appointmentId, $date)
    {
        $this->appointmentId = $appointmentId;
        $this->date = $date;
    }

    // ──────────────────────────────────────────────
    // Attendance
    // ──────────────────────────────────────────────

    public function markAttendance($bookingId, $status)
    {
        $booking = AppointmentBooking::findOrFail($bookingId);
        $booking->update(['attendance_status' => $status]);
        session()->flash('success', 'Asistencia actualizada correctamente.');
    }

    // ──────────────────────────────────────────────
    // Export
    // ──────────────────────────────────────────────

    public function exportDay()
    {
        $appointment = Appointment::find($this->appointmentId);
        $slug = $appointment ? $appointment->slug : 'citas';
        $filename = "citas_{$slug}_{$this->date}.xlsx";

        return Excel::download(
            new AppointmentBookingsExport($this->appointmentId, $this->date),
            $filename
        );
    }

    // ──────────────────────────────────────────────
    // Render
    // ──────────────────────────────────────────────

    public function render()
    {
        $appointment = Appointment::with('dependency')->findOrFail($this->appointmentId);

        $bookings = AppointmentBooking::with(['appointment.dependency'])
            ->where('appointment_id', $this->appointmentId)
            ->where('date', $this->date)
            ->orderBy('start_time', 'asc')
            ->get();

        return view('livewire.appointments.bookings-day-detail', [
            'appointment' => $appointment,
            'bookings' => $bookings,
        ]);
    }
}
