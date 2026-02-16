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
                        <div class="alert alert-warning">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Recuerda confirmar tu cita mínimo 24 horas antes, de lo contrario el sistema la cancelará automáticamente. Para confirmar da click dentro en VER CITA.
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

                        @if ($bookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Trámite</th>
                                            <th>Dependencia</th>
                                            <th>Fecha</th>
                                            <th>Horario</th>
                                            <th>Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold text-primary">{{ $booking->folio }}</span>
                                                </td>
                                                <td>{{ $booking->appointment->name ?? 'N/A' }}</td>
                                                <td>
                                                    <small class="text-muted">{{ $booking->appointment->dependency->name ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($booking->date)->locale('es')->isoFormat('ddd D MMM YYYY') }}</span>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                                    - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                                                    @if ($booking->attendance_status)
                                                        <br>
                                                        <span class="badge bg-{{ $booking->attendance_color }} mt-1" style="font-size: 0.7em;">
                                                            {{ $booking->attendance_label }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('citizen.appointments.show', $booking->id) }}"
                                                        class="btn btn-outline-primary btn-sm" title="Ver detalle">
                                                        <ion-icon name="eye-outline"></ion-icon> Ver Cita
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <ion-icon name="calendar-outline" style="font-size: 3rem;" class="text-muted"></ion-icon>
                                <h5 class="mt-3 text-muted">No tienes citas agendadas</h5>
                                <p class="text-muted">Agenda tu primera cita para realizar un trámite municipal.</p>
                                <a href="{{ url('/citas') }}" class="btn btn-primary">
                                    <ion-icon name="add-outline"></ion-icon> Agendar Cita
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar { width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; }
        .avatar-lg { width: 4rem; height: 4rem; }
        .avatar-initial { font-weight: bold; font-size: 1.2rem; }
    </style>
@endsection
