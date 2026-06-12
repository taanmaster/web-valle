<?php

namespace App\Livewire\GeneralCalendar;

use Livewire\Component;
use Carbon\Carbon;

use App\Models\GeneralCalendarProcedure;
use App\Models\GeneralCalendarAppointment;

class AppointmentForm extends Component
{
    public $filter_dependencia = '';
    public $procedure_id       = '';
    public $fecha              = '';
    public $horario            = '';

    public $full_name   = '';
    public $email       = '';
    public $phone       = '';
    public $approval_id = '';

    // Anti-spam: honeypot (debe permanecer vacío) + tiempo mínimo de llenado
    public $website = '';
    public $form_started_at;

    public ?string $successFolio = null;

    public function mount(): void
    {
        $this->form_started_at = now()->timestamp;
    }

    public function updatedFilterDependencia(): void
    {
        $this->reset(['procedure_id', 'fecha', 'horario']);
    }

    public function updatedProcedureId(): void
    {
        $this->reset(['fecha', 'horario']);
    }

    public function updatedFecha(): void
    {
        $this->horario = '';
        $this->resetValidation('fecha');

        if (!$this->fecha || !$this->selectedProcedure) {
            return;
        }

        // Solo días de la semana con bloques de disponibilidad configurados
        $dayOfWeek = Carbon::parse($this->fecha)->dayOfWeek;

        if (!in_array($dayOfWeek, $this->selectedProcedure->availableDaysOfWeek())) {
            $this->addError('fecha', 'Este trámite no atiende ese día. Días con citas disponibles: '
                . ($this->selectedProcedure->availableDayNamesList() ?: 'ninguno por el momento') . '.');
            $this->fecha = '';
        }
    }

    public function getSelectedProcedureProperty(): ?GeneralCalendarProcedure
    {
        return $this->procedure_id
            ? GeneralCalendarProcedure::active()->find($this->procedure_id)
            : null;
    }

    public function getAvailableSlotsProperty(): array
    {
        if (!$this->selectedProcedure || !$this->fecha) {
            return [];
        }

        return array_values(array_filter(
            $this->selectedProcedure->slotsForDate($this->fecha),
            fn ($slot) => $slot['available']
        ));
    }

    public function cancel(): void
    {
        $this->reset([
            'filter_dependencia', 'procedure_id', 'fecha', 'horario',
            'full_name', 'email', 'phone', 'approval_id', 'successFolio',
        ]);
        $this->resetValidation();
    }

    public function save(): void
    {
        // ─── Anti-spam ────────────────────────────────────────────
        if ($this->website !== '') {
            // Honeypot llenado: bot. Se ignora silenciosamente.
            $this->cancel();

            return;
        }

        if (now()->timestamp - (int) $this->form_started_at < 3) {
            // Enviado demasiado rápido para ser humano
            $this->addError('horario', 'No se pudo procesar la solicitud, intenta de nuevo.');

            return;
        }

        $procedure = $this->selectedProcedure;

        $this->validate([
            'procedure_id' => 'required',
            'fecha'        => 'required|date|after_or_equal:today',
            'horario'      => 'required|date_format:H:i',
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:20',
            'approval_id'  => ($procedure?->requires_id ? 'required' : 'nullable') . '|string|max:255',
        ], [
            'procedure_id.required' => 'Selecciona el servicio o trámite.',
            'fecha.required'        => 'Selecciona la fecha.',
            'fecha.after_or_equal'  => 'La fecha no puede ser anterior a hoy.',
            'horario.required'      => 'Selecciona el horario.',
            'full_name.required'    => 'Escribe tu nombre completo.',
            'email.required'        => 'Escribe tu correo electrónico.',
            'email.email'           => 'El correo no es válido.',
            'phone.required'        => 'Escribe tu teléfono de contacto.',
            'approval_id.required'  => 'Este trámite requiere el ID de aprobación.',
        ]);

        if (!$procedure) {
            $this->addError('procedure_id', 'El trámite seleccionado ya no está disponible.');

            return;
        }

        // El día de la semana debe tener disponibilidad configurada
        if (!in_array(Carbon::parse($this->fecha)->dayOfWeek, $procedure->availableDaysOfWeek())) {
            $this->addError('fecha', 'Este trámite no atiende ese día. Días con citas disponibles: '
                . ($procedure->availableDayNamesList() ?: 'ninguno por el momento') . '.');

            return;
        }

        // Validación del ID de aprobación contra el registro de IDs emitidos
        if ($procedure->requires_id && !$this->approvalIdIsValid($this->approval_id)) {
            $this->addError('approval_id', 'El ID de aprobación no es válido. Verifica el ID que te entregó el sistema al concluir tu proceso.');

            return;
        }

        // El bloque debe seguir disponible (evita dobles reservas)
        $stillAvailable = collect($procedure->slotsForDate($this->fecha))
            ->firstWhere('start', $this->horario)['available'] ?? false;

        if (!$stillAvailable) {
            $this->addError('horario', 'Ese horario acaba de ocuparse, selecciona otro.');
            $this->horario = '';

            return;
        }

        $end = Carbon::parse($this->fecha . ' ' . $this->horario)
            ->addMinutes(GeneralCalendarProcedure::SLOT_MINUTES)
            ->format('H:i');

        $appointment = GeneralCalendarAppointment::create([
            'folio'                         => GeneralCalendarAppointment::generateFolio(),
            'general_calendar_procedure_id' => $procedure->id,
            'date'                          => $this->fecha,
            'start_time'                    => $this->horario,
            'end_time'                      => $end,
            'full_name'                     => $this->full_name,
            'email'                         => $this->email,
            'phone'                         => $this->phone,
            'approval_id'                   => $this->approval_id ?: null,
            'status'                        => 'scheduled',
        ]);

        $this->successFolio = $appointment->folio;

        $this->reset([
            'fecha', 'horario', 'full_name', 'email', 'phone', 'approval_id',
        ]);
        $this->form_started_at = now()->timestamp;
    }

    /**
     * Valida el ID de aprobación contra los IDs emitidos por el sistema.
     *
     * Pendiente: aún no existe la relación de tipos de ID emitidos por otros
     * procesos, por lo que ningún ID es válido todavía — los trámites que
     * requieren ID no pueden completar citas hasta conectar ese registro.
     */
    private function approvalIdIsValid(string $approvalId): bool
    {
        return false;
    }

    public function render()
    {
        $dependencias = GeneralCalendarProcedure::active()
            ->whereNotNull('dependencia')
            ->distinct()
            ->orderBy('dependencia')
            ->pluck('dependencia');

        $procedures = GeneralCalendarProcedure::active()
            ->when($this->filter_dependencia, fn ($q) => $q->where('dependencia', $this->filter_dependencia))
            ->orderBy('name')
            ->get();

        return view('front.general-calendar.appointment-form', [
            'dependencias' => $dependencias,
            'procedures'   => $procedures,
        ]);
    }
}
