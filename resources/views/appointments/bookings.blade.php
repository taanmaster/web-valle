@extends('layouts.master')
@section('title') Intranet @endsection

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}">
<style>
    .fc .fc-bg-event {
        opacity: 0.35;
    }
    .fc .fc-daygrid-day:hover {
        background-color: rgba(0, 0, 0, 0.04);
    }
    .fc .fc-daygrid-day.fc-day-selected {
        outline: 3px solid var(--bs-primary);
        outline-offset: -3px;
    }
</style>
@endpush

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Citas @endslot
        @slot('title') Citas Agendadas @endslot
    @endcomponent

    <div class="container-fluid py-4">
        {{-- Calendario de Citas --}}
        <livewire:appointments.bookings-calendar />
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/locales/es.js') }}"></script>
<script>
document.addEventListener('livewire:initialized', function() {
    let adminCalendar = null;
    let currentCalendarYear = null;
    let currentCalendarMonth = null;

    function initAdminCalendar(availability, year, month) {
        const calendarEl = document.getElementById('admin-bookings-calendar');
        if (!calendarEl) return;

        // Destruir calendario anterior si existe
        if (adminCalendar) {
            adminCalendar.destroy();
            adminCalendar = null;
        }

        // Guardar el mes/año actual para evitar loops
        currentCalendarYear = year;
        currentCalendarMonth = month;

        // Construir eventos de fondo
        const events = [];
        if (availability) {
            Object.keys(availability).forEach(function(date) {
                const dayData = availability[date];
                events.push({
                    start: date,
                    display: 'background',
                    color: dayData.color,
                    extendedProps: {
                        available: dayData.available,
                        total: dayData.total,
                        percentage: dayData.percentage
                    }
                });
            });
        }

        // Fecha inicial del calendario
        const initialDate = year + '-' + String(month).padStart(2, '0') + '-01';

        adminCalendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            initialDate: initialDate,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            height: 'auto',
            events: events,
            dateClick: function(info) {
                // Leer el appointmentId seleccionado
                const appointmentInput = document.getElementById('admin-selected-appointment');
                const appointmentId = appointmentInput ? appointmentInput.value : null;
                if (!appointmentId) return;

                // Redirigir a la vista de detalle del día
                window.location.href = '/admin/appointment-bookings/day/' + appointmentId + '/' + info.dateStr;
            },
            datesSet: function(info) {
                // Calcular mes/año visible
                const midDate = new Date((info.start.getTime() + info.end.getTime()) / 2);
                const newYear = midDate.getFullYear();
                const newMonth = midDate.getMonth() + 1;

                // Solo llamar a Livewire si el mes realmente cambió (evita loop infinito)
                if (newYear === currentCalendarYear && newMonth === currentCalendarMonth) return;

                currentCalendarYear = newYear;
                currentCalendarMonth = newMonth;

                const wrapper = calendarEl.closest('[wire\\:id]');
                if (wrapper) {
                    Livewire.find(wrapper.getAttribute('wire:id')).call('onMonthChanged', newYear, newMonth);
                }
            }
        });

        adminCalendar.render();
    }

    // Datos pendientes cuando el evento llega antes que el DOM
    let pendingCalendarData = null;

    // Escuchar cuando Livewire actualiza la disponibilidad
    Livewire.on('admin-calendar-updated', (data) => {
        const params = Array.isArray(data) ? data[0] : data;
        const calendarEl = document.getElementById('admin-bookings-calendar');
        if (calendarEl) {
            initAdminCalendar(params.availability, params.year, params.month);
        } else {
            // El DOM aún no tiene el div, guardar para cuando aparezca
            pendingCalendarData = params;
        }
    });

    // Observar aparición/desaparición del div del calendario
    const adminObserver = new MutationObserver(function() {
        const calendarEl = document.getElementById('admin-bookings-calendar');
        if (calendarEl && !adminCalendar && pendingCalendarData) {
            // El div apareció y hay datos pendientes → inicializar
            initAdminCalendar(pendingCalendarData.availability, pendingCalendarData.year, pendingCalendarData.month);
            pendingCalendarData = null;
        } else if (!calendarEl && adminCalendar) {
            adminCalendar.destroy();
            adminCalendar = null;
            currentCalendarYear = null;
            currentCalendarMonth = null;
        }
    });

    adminObserver.observe(document.body, { childList: true, subtree: true });
});
</script>
@endpush
