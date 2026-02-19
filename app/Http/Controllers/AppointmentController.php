<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentBooking;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Listado de trámites configurados.
     */
    public function index()
    {
        return view('appointments.index');
    }

    /**
     * Formulario para crear un nuevo trámite.
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Almacenar un nuevo trámite (delegado a Livewire).
     */
    public function store(Request $request)
    {
        // Delegado al componente Livewire
        return redirect()->route('appointments.index');
    }

    /**
     * Mostrar detalle de un trámite.
     */
    public function show($id)
    {
        $appointment = Appointment::with(['dependency', 'schedules', 'holidays'])->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Formulario de edición de un trámite.
     */
    public function edit($id)
    {
        $appointment = Appointment::with(['dependency', 'schedules', 'holidays'])->findOrFail($id);
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Actualizar un trámite (delegado a Livewire).
     */
    public function update(Request $request, $id)
    {
        // Delegado al componente Livewire
        return redirect()->route('appointments.index');
    }

    /**
     * Eliminar un trámite.
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Trámite eliminado correctamente.');
    }

    /**
     * Gestión de días inhábiles de un trámite.
     */
    public function holidays($id)
    {
        $appointment = Appointment::with('holidays')->findOrFail($id);
        return view('appointments.holidays', compact('appointment'));
    }

    /**
     * Listado general de citas agendadas (bookings).
     */
    public function bookings()
    {
        return view('appointments.bookings');
    }

    /**
     * Listado total de citas agendadas (tabla clásica).
     */
    public function bookingsList()
    {
        return view('appointments.bookings-list');
    }

    /**
     * Detalle de citas agendadas para un trámite en una fecha específica.
     */
    public function bookingsDay($appointmentId, $date)
    {
        $appointment = Appointment::with('dependency')->findOrFail($appointmentId);

        // Validar formato de fecha
        try {
            $parsedDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            abort(404);
        }

        return view('appointments.bookings-day', [
            'appointment' => $appointment,
            'date' => $parsedDate,
        ]);
    }

    /**
     * Citas agendadas filtradas por la dependencia del usuario autenticado.
     */
    public function bookingsByDependency()
    {
        $user = auth()->user();

        if (!$user->backoffice_dependency_id) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes una dependencia asignada para ver citas.');
        }

        $dependencyName = \App\Models\BackofficeDependency::find($user->backoffice_dependency_id)?->name ?? 'Tu Dependencia';

        return view('appointments.bookings-dependency', [
            'dependencyId' => $user->backoffice_dependency_id,
            'dependencyName' => $dependencyName,
        ]);
    }
}
