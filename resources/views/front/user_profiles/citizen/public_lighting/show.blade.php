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

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Encabezado --}}
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                            <div>
                                <h5 class="mb-1">Folio de solicitud: <span class="text-muted">{{ $lightingRequest->folio }}</span></h5>
                                <p class="text-muted mb-0">Tipo de Trámite: Petición Servicio de Alumbrado Público</p>
                                <p class="text-muted mb-0">Fecha de Solicitud: {{ $lightingRequest->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="badge bg-{{ $lightingRequest->status_color }}">{{ $lightingRequest->status_label }}</span>
                        </div>

                        {{-- ===== DATOS DEL SOLICITANTE ===== --}}
                        <div class="card mb-4">
                            <div class="card-header text-white" style="background-color:#0d6e6e;">
                                <strong>DATOS DEL SOLICITANTE</strong>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <p class="small text-muted mb-0">Nombre Completo</p>
                                        <p class="mb-0">{{ $lightingRequest->full_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Teléfono de contacto</p>
                                        <p class="mb-0">{{ $lightingRequest->phone }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Correo Electrónico</p>
                                        <p class="mb-0">{{ $lightingRequest->email ?: '—' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===== UBICACIÓN DEL REPORTE ===== --}}
                        <div class="card mb-4">
                            <div class="card-header text-white" style="background-color:#0d6e6e;">
                                <strong>UBICACIÓN DEL REPORTE</strong>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <p class="small text-muted mb-0">Colonia</p>
                                        <p class="mb-0">{{ $lightingRequest->colony }}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="small text-muted mb-0">Calle</p>
                                        <p class="mb-0">{{ $lightingRequest->street }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="small text-muted mb-0">Número</p>
                                        <p class="mb-0">{{ $lightingRequest->number ?: '—' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Entre calles</p>
                                        <p class="mb-0">{{ $lightingRequest->between_streets ?: '—' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Referencias adicionales</p>
                                        <p class="mb-0">{{ $lightingRequest->references ?: '—' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Ubicación en mapa</p>
                                        @if ($lightingRequest->map_url)
                                            <a href="{{ $lightingRequest->map_url }}" target="_blank" rel="noopener">
                                                <ion-icon name="map-outline"></ion-icon> Ver en mapa
                                            </a>
                                        @else
                                            <p class="mb-0">—</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Fotografía del lugar</p>
                                        @if ($lightingRequest->location_photo_s3_url)
                                            <a href="{{ $lightingRequest->location_photo_s3_url }}" target="_blank" rel="noopener">
                                                <img src="{{ $lightingRequest->location_photo_s3_url }}" class="img-thumbnail mt-1" width="160" alt="Fotografía del lugar">
                                            </a>
                                        @else
                                            <p class="mb-0">—</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===== INFORMACIÓN DEL PROBLEMA ===== --}}
                        <div class="card mb-4">
                            <div class="card-header text-white" style="background-color:#0d6e6e;">
                                <strong>INFORMACIÓN DEL PROBLEMA</strong>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <p class="small text-muted mb-0">Descripción</p>
                                        <p class="mb-0">{!! nl2br(e($lightingRequest->description)) !!}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Número de poste/luminaria</p>
                                        <p class="mb-0">{{ $lightingRequest->pole_number ?: '—' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="small text-muted mb-0">Desde cuándo presenta el problema</p>
                                        <p class="mb-0">{{ $lightingRequest->problem_since ?: '—' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===== EVIDENCIA DEL PROBLEMA ===== --}}
                        <div class="card mb-4">
                            <div class="card-header text-white" style="background-color:#0d6e6e;">
                                <strong>EVIDENCIA DEL PROBLEMA</strong>
                            </div>
                            <div class="card-body">
                                @if ($lightingRequest->files->count())
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($lightingRequest->files as $file)
                                            <a href="{{ $file->s3_asset_url }}" target="_blank" rel="noopener">
                                                <img src="{{ $file->s3_asset_url }}" class="img-thumbnail" width="160" alt="{{ $file->name }}">
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Sin fotografías adjuntas.</p>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('citizen.public_lighting.index') }}" class="btn btn-secondary">
                            <ion-icon name="arrow-back-outline"></ion-icon> Volver a mis peticiones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
