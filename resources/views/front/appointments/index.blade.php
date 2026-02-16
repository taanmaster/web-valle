@extends('front.layouts.app')

@push('styles')
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
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Encabezado -->
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="fas fa-calendar-check fa-4x text-primary"></i>
                </div>
                <h1 class="display-5 fw-bold mb-3">Citas para Trámites Municipales</h1>
                <p class="lead text-muted">
                    Selecciona la dependencia y el trámite que deseas realizar. Si tu búsqueda de trámite o cita social no aparece, es posible que aún no se encuentre en el portal. Estamos trabajando para integrarlos próximamente.
                </p>
            </div>

            <!-- Wizard Livewire -->
            <livewire:front.appointments.appointment-booking-wizard />

            <!-- Información adicional -->
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        ¿Cómo funciona?
                    </h5>
                    <p class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Paso 1:</strong> Selecciona la dependencia y el trámite que necesitas
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Paso 2:</strong> Elige una fecha disponible en el calendario
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Paso 3:</strong> Selecciona el horario de tu preferencia
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Paso 4:</strong> Confirma tus datos y agenda tu cita
                    </p>
                    <hr>
                    <p class="mb-0">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        <strong>Importante:</strong> Una vez agendada la cita, deberás confirmarla con al menos
                        <strong>24 horas de anticipación</strong>. Las citas no confirmadas serán canceladas automáticamente.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/locales/es.js') }}"></script>
<script>
document.addEventListener('livewire:initialized', function() {
    let calendar = null;
    let selectedDateEl = null;

    function initCalendar(availability, year, month) {
        const calendarEl = document.getElementById('appointment-calendar');
        if (!calendarEl) return;

        // Destruir calendario anterior si existe
        if (calendar) {
            calendar.destroy();
            calendar = null;
        }

        // Construir eventos de fondo con colores de disponibilidad
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

        calendar = new FullCalendar.Calendar(calendarEl, {
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
            validRange: {
                start: new Date().toISOString().split('T')[0]
            },
            dateClick: function(info) {
                // Verificar si el día tiene disponibilidad
                const dayData = availability ? availability[info.dateStr] : null;
                if (!dayData || dayData.available === 0) return;

                // Marcar visualmente
                if (selectedDateEl) {
                    selectedDateEl.classList.remove('fc-day-selected');
                }
                selectedDateEl = info.dayEl;
                selectedDateEl.classList.add('fc-day-selected');

                // Notificar a Livewire
                const wrapper = calendarEl.closest('[wire\\:id]');
                if (wrapper) {
                    Livewire.find(wrapper.getAttribute('wire:id')).call('selectDate', info.dateStr);
                }
            },
            datesSet: function(info) {
                // Cuando el usuario navega a otro mes
                const midDate = new Date((info.start.getTime() + info.end.getTime()) / 2);
                const newYear = midDate.getFullYear();
                const newMonth = midDate.getMonth() + 1;
                const wrapper = calendarEl.closest('[wire\\:id]');
                if (wrapper) {
                    Livewire.find(wrapper.getAttribute('wire:id')).call('onMonthChanged', newYear, newMonth);
                }
            }
        });

        calendar.render();
    }

    // Escuchar cuando Livewire actualiza la disponibilidad
    Livewire.on('calendar-updated', (data) => {
        const params = Array.isArray(data) ? data[0] : data;
        initCalendar(params.availability, params.year, params.month);
    });

    // Observar cambios del DOM para re-inicializar el calendario
    const observer = new MutationObserver(function() {
        const calendarEl = document.getElementById('appointment-calendar');
        if (calendarEl && !calendar) {
            const wrapper = calendarEl.closest('[wire\\:id]');
            if (wrapper) {
                const component = Livewire.find(wrapper.getAttribute('wire:id'));
                if (component) {
                    const availability = component.availabilityData;
                    const year = component.calendarYear;
                    const month = component.calendarMonth;
                    if (availability && Object.keys(availability).length > 0) {
                        initCalendar(availability, year, month);
                    }
                }
            }
        } else if (!calendarEl && calendar) {
            calendar.destroy();
            calendar = null;
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });

    // Re-inicializar después de cada morphing de Livewire
    Livewire.hook('morph.updated', ({ el }) => {
        const calendarEl = document.getElementById('appointment-calendar');
        if (calendarEl && calendarEl.innerHTML === '') {
            const wrapper = calendarEl.closest('[wire\\:id]');
            if (wrapper) {
                const component = Livewire.find(wrapper.getAttribute('wire:id'));
                if (component) {
                    const availability = component.availabilityData;
                    const year = component.calendarYear;
                    const month = component.calendarMonth;
                    if (availability && Object.keys(availability).length > 0) {
                        setTimeout(() => initCalendar(availability, year, month), 100);
                    }
                }
            }
        }
    });
});
</script>
@endpush