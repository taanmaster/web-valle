@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="mb-1">
                                    <ion-icon name="earth-outline"></ion-icon> {{ $thirdPartyRequest->event_name }}
                                </h5>
                                <div class="d-flex gap-3 text-muted small">
                                    <span><strong>Folio:</strong> {{ $thirdPartyRequest->folio }}</span>
                                    <span><strong>Enviada:</strong> {{ $thirdPartyRequest->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <span class="badge bg-{{ $thirdPartyRequest->status_color }} fs-6">{{ $thirdPartyRequest->status }}</span>
                        </div>

                        {{-- Sección 1: Datos del Solicitante --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><ion-icon name="person-outline"></ion-icon> 1. Datos del Solicitante</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Nombre Completo</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->full_name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Organización</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->organization_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <small class="text-muted">Tipo</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->applicant_type === 'persona_fisica' ? 'Persona Física' : 'Persona Moral' }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <small class="text-muted">{{ $thirdPartyRequest->applicant_type === 'persona_fisica' ? 'CURP' : 'RFC' }}</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->rfc_or_curp }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <small class="text-muted">Domicilio Fiscal</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->fiscal_address }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Teléfono</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->phone }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Correo Electrónico</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección 2: Datos del Evento --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><ion-icon name="calendar-outline"></ion-icon> 2. Datos del Evento</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Nombre del Evento</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->event_name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Tipo de Evento</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->event_type }}</p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <small class="text-muted">Objetivo</small>
                                        <p class="mb-0">{{ $thirdPartyRequest->event_objective }}</p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <small class="text-muted">Descripción</small>
                                        <p class="mb-0">{{ $thirdPartyRequest->event_description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección 3: Fecha y Lugar --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><ion-icon name="location-outline"></ion-icon> 3. Fecha y Lugar</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <small class="text-muted">Fecha Inicio</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->start_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <small class="text-muted">Fecha Fin</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->end_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <small class="text-muted">Hora Inicio</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->start_time }}</p>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <small class="text-muted">Hora Fin</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->end_time }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Sede</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->venue }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Tipo de Acceso</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->event_access_type }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección 4: Impacto --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><ion-icon name="trending-up-outline"></ion-icon> 4. Impacto Turístico</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Impacto Esperado</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->expected_impact }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Asistentes Estimados</small>
                                        <p class="mb-0 fw-semibold">{{ number_format($thirdPartyRequest->estimated_attendees) }}</p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <small class="text-muted">Promueve Identidad Cultural</small>
                                        <p class="mb-0">{{ $thirdPartyRequest->promotes_identity }}</p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <small class="text-muted">Genera Impacto Económico</small>
                                        <p class="mb-0">{{ $thirdPartyRequest->generates_economic_impact }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección 5: Apoyo --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><ion-icon name="hand-left-outline"></ion-icon> 5. Apoyo Solicitado</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <small class="text-muted">Tipo de Apoyo</small>
                                        <p class="mb-0 fw-semibold">{{ $thirdPartyRequest->support_type }}</p>
                                    </div>
                                    <div class="col-md-8 mb-2">
                                        <small class="text-muted">Descripción del Apoyo</small>
                                        <p class="mb-0">{{ $thirdPartyRequest->support_description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección 6: Firma --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><ion-icon name="create-outline"></ion-icon> 6. Declaración y Firma</h6>
                            </div>
                            <div class="card-body">
                                @if ($thirdPartyRequest->signature_url)
                                    <div class="text-center">
                                        <img src="{{ $thirdPartyRequest->signature_url }}" alt="Firma" class="img-fluid border rounded" style="max-height: 200px;">
                                    </div>
                                @else
                                    <p class="text-muted text-center mb-0">No se adjuntó firma.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Botón Volver --}}
                        <div class="text-center mt-4">
                            <a href="{{ route('citizen.third_party.index') }}" class="btn btn-secondary">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver a Mis Solicitudes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
