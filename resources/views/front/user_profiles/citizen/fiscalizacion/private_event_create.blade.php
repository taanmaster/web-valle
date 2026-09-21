@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Corrige los siguientes errores:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Encabezado --}}
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                            <div>
                                <h5 class="mb-1">
                                    Folio de solicitud: <span class="text-muted">—</span>
                                    <span class="badge bg-secondary">Nuevo</span>
                                </h5>
                                <p class="text-muted mb-0">Tipo de Trámite: Autorización de Eventos Particulares</p>
                                <p class="text-muted mb-0">Fecha de Solicitud: {{ now()->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('citizen.fisc.private_event.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- ===== DATOS Y CONTACTO ===== --}}
                            <div class="card mb-4">
                                <div class="card-header text-white" style="background-color:#0d6e6e;">
                                    <strong>DATOS Y CONTACTO</strong>
                                </div>
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-3">Datos del Evento</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Tipo de Evento</label>
                                            <input type="text" name="event_type" value="{{ old('event_type') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Fecha del evento</label>
                                            <input type="date" name="event_date" value="{{ old('event_date') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Persona Responsable</label>
                                            <input type="text" name="responsible_person" value="{{ old('responsible_person') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Horario</label>
                                            <input type="text" name="schedule" value="{{ old('schedule') }}" class="form-control" placeholder="Ej. 18:00 a 23:00" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Salón o Espacio Cerrado</label>
                                            <input type="text" name="venue" value="{{ old('venue') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Asistentes</label>
                                            <input type="number" min="0" name="attendees" value="{{ old('attendees') }}" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label d-block">¿Venta de alcohol?</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="alcohol_sales" id="alcohol_si" value="1" {{ old('alcohol_sales') === '1' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="alcohol_si">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="alcohol_sales" id="alcohol_no" value="0" {{ old('alcohol_sales') === '0' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="alcohol_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== LISTA DE VERIFICACIÓN DE DOCUMENTOS ===== --}}
                            <div class="card mb-4">
                                <div class="card-header text-white bg-primary">
                                    <strong>LISTA DE VERIFICACIÓN DE DOCUMENTOS</strong>
                                </div>
                                <div class="card-body">
                                    @foreach (['comprobante-pago-entero' => 'Comprobante de Pago de Entero'] as $slug => $label)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-3 mb-2">
                                            <div class="d-flex align-items-center">
                                                <ion-icon name="ellipse-outline" style="font-size:1.3rem;" class="me-2 text-muted"></ion-icon>
                                                <div>
                                                    <div class="fw-bold">{{ strtoupper($label) }}</div>
                                                    <small class="text-muted">Pendiente de subir</small>
                                                </div>
                                            </div>
                                            <input type="file" name="documents[{{ $slug }}]" class="form-control" style="max-width: 260px;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- ===== FOOTER ===== --}}
                            <div class="alert alert-info d-flex align-items-start gap-2">
                                <ion-icon name="information-circle-outline" style="font-size:1.3rem;"></ion-icon>
                                <span>
                                    Tras el envío, tu solicitud será revisada por Fiscalización para su autorización.
                                </span>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-warning fw-bold">
                                    <ion-icon name="send-outline"></ion-icon> ENVIAR SOLICITUD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
