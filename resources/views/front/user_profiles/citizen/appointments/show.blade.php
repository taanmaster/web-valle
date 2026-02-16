@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <a href="{{ route('citizen.appointments.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                                    <ion-icon name="arrow-back-outline"></ion-icon> Regresar
                                </a>
                            </div>
                            <h5 class="mb-0">Detalle de Cita — <span class="text-primary">{{ $booking->folio }}</span></h5>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Información de la cita -->
                            <div class="col-lg-8">
                                <div class="card border mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><ion-icon name="information-circle-outline"></ion-icon> Información de la Cita</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Folio</label>
                                                <p class="mb-0 fw-bold text-primary fs-5">{{ $booking->folio }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Estado</label>
                                                <p class="mb-0">
                                                    <span class="badge bg-{{ $booking->status_color }} fs-6">{{ $booking->status_label }}</span>
                                                    @if ($booking->attendance_status)
                                                        <span class="badge bg-{{ $booking->attendance_color }} ms-1">{{ $booking->attendance_label }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Trámite</label>
                                                <p class="mb-0">{{ $booking->appointment->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Dependencia</label>
                                                <p class="mb-0">{{ $booking->appointment->dependency->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Fecha</label>
                                                <p class="mb-0 fw-semibold">
                                                    <ion-icon name="calendar-outline"></ion-icon>
                                                    {{ \Carbon\Carbon::parse($booking->date)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Horario</label>
                                                <p class="mb-0 fw-semibold">
                                                    <ion-icon name="time-outline"></ion-icon>
                                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                                    - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                                </p>
                                            </div>
                                            @if ($booking->description || $booking->appointment->description)
                                                <div class="col-12">
                                                    <label class="form-label text-muted fw-semibold small">Descripción del Trámite</label>
                                                    <p class="mb-0">{{ $booking->appointment->description }}</p>
                                                </div>
                                            @endif
                                            @if ($booking->notes)
                                                <div class="col-12">
                                                    <label class="form-label text-muted fw-semibold small">Notas del Ciudadano</label>
                                                    <p class="mb-0">{{ $booking->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Datos del solicitante -->
                                <div class="card border mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><ion-icon name="person-outline"></ion-icon> Datos del Solicitante</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label text-muted fw-semibold small">Nombre Completo</label>
                                                <p class="mb-0">{{ $booking->full_name }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-muted fw-semibold small">Correo Electrónico</label>
                                                <p class="mb-0">{{ $booking->email }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-muted fw-semibold small">Teléfono</label>
                                                <p class="mb-0">{{ $booking->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel lateral con acciones -->
                            <div class="col-lg-4">
                                <div class="card border mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><ion-icon name="settings-outline"></ion-icon> Acciones</h6>
                                    </div>
                                    <div class="card-body d-grid gap-2">
                                        @if ($booking->status === 'scheduled')
                                            <form action="{{ route('citizen.appointments.confirm', $booking->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success w-100"
                                                    onclick="return confirm('¿Deseas confirmar tu asistencia a esta cita?')">
                                                    <ion-icon name="checkmark-circle-outline"></ion-icon> Confirmar Asistencia
                                                </button>
                                            </form>
                                            <form action="{{ route('citizen.appointments.cancel', $booking->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger w-100"
                                                    onclick="return confirm('¿Estás seguro de que deseas cancelar esta cita? Esta acción no se puede deshacer.')">
                                                    <ion-icon name="close-circle-outline"></ion-icon> Cancelar Cita
                                                </button>
                                            </form>
                                        @elseif ($booking->status === 'confirmed')
                                            <form action="{{ route('citizen.appointments.cancel', $booking->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger w-100"
                                                    onclick="return confirm('¿Estás seguro de que deseas cancelar esta cita? Esta acción no se puede deshacer.')">
                                                    <ion-icon name="close-circle-outline"></ion-icon> Cancelar Cita
                                                </button>
                                            </form>
                                        @elseif ($booking->status === 'cancelled')
                                            <div class="alert alert-secondary text-center mb-0">
                                                <ion-icon name="ban-outline"></ion-icon> Esta cita fue cancelada.
                                            </div>
                                        @endif

                                        {{--  
                                        <a href="{{ url('/citas') }}" class="btn btn-outline-primary w-100">
                                            <ion-icon name="add-outline"></ion-icon> Agendar Nueva Cita
                                        </a>
                                        --}}
                                    </div>
                                </div>

                                <!-- Línea de tiempo -->
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><ion-icon name="time-outline"></ion-icon> Historial</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex align-items-start mb-3">
                                                <span class="badge bg-primary rounded-pill me-2 mt-1">1</span>
                                                <div>
                                                    <small class="text-muted">Agendada</small><br>
                                                    <small>{{ $booking->created_at->locale('es')->isoFormat('D MMM YYYY, H:mm') }}</small>
                                                </div>
                                            </li>
                                            @if ($booking->confirmed_at)
                                                <li class="d-flex align-items-start mb-3">
                                                    <span class="badge bg-success rounded-pill me-2 mt-1">2</span>
                                                    <div>
                                                        <small class="text-muted">Confirmada</small><br>
                                                        <small>{{ \Carbon\Carbon::parse($booking->confirmed_at)->locale('es')->isoFormat('D MMM YYYY, H:mm') }}</small>
                                                    </div>
                                                </li>
                                            @endif
                                            @if ($booking->cancelled_at)
                                                <li class="d-flex align-items-start mb-3">
                                                    <span class="badge bg-danger rounded-pill me-2 mt-1">
                                                        <ion-icon name="close-outline" style="font-size: 0.7em;"></ion-icon>
                                                    </span>
                                                    <div>
                                                        <small class="text-muted">Cancelada</small><br>
                                                        <small>{{ \Carbon\Carbon::parse($booking->cancelled_at)->locale('es')->isoFormat('D MMM YYYY, H:mm') }}</small>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmación cuando acaba de agendar una cita --}}
    @if (request('just_booked'))
        <div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-labelledby="bookingSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-success">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title text-white" id="bookingSuccessModalLabel">
                            <ion-icon name="checkmark-circle-outline"></ion-icon> ¡Cita Agendada Exitosamente!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="mb-3">
                            <ion-icon name="calendar-outline" style="font-size: 4rem; color: #198754;"></ion-icon>
                        </div>
                        <h4 class="text-success">Folio: {{ $booking->folio }}</h4>
                        <p class="text-muted">Tu cita ha sido registrada con éxito.</p>
                        <hr>
                        <div class="text-start">
                            <p class="mb-1"><strong>Trámite:</strong> {{ $booking->appointment->name }}</p>
                            <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($booking->date)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}</p>
                            <p class="mb-1"><strong>Horario:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                        </div>
                        <hr>
                        <div class="alert alert-warning mb-0">
                            <ion-icon name="alert-circle-outline"></ion-icon> <strong>Importante:</strong> Confirma tu asistencia antes de 24 horas o tu cita será cancelada automáticamente.
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <form action="{{ route('citizen.appointments.confirm', $booking->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <ion-icon name="checkmark-circle-outline"></ion-icon> Confirmar Ahora
                            </button>
                        </form>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Confirmar Después
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var modal = new bootstrap.Modal(document.getElementById('bookingSuccessModal'));
                    modal.show();
                });
            </script>
        @endpush
    @endif

    <style>
        .avatar { width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; }
        .avatar-lg { width: 4rem; height: 4rem; }
        .avatar-initial { font-weight: bold; font-size: 1.2rem; }
    </style>
@endsection
