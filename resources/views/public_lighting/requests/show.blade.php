@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Alumbrado Público @endslot
@slot('li_3') <a href="{{ route('public_lighting.requests.index') }}">Peticiones</a> @endslot
@slot('title') Petición {{ $lightingRequest->folio }} @endslot
@endcomponent

@php
    $r = $lightingRequest;
    $receivedLog = $r->logs->firstWhere('status', 'recibida');
@endphp

<div class="row layout-spacing">
    <div class="main-content">

        {{-- Encabezado --}}
        <div class="card bg-danger-subtle border-0 mb-4">
            <div class="card-body">
                <div class="row align-items-center g-3">
                    <div class="col-6 col-md-3">
                        <small class="text-danger">Folio</small>
                        <p class="mb-0 fw-semibold">{{ $r->folio }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-danger">Fecha de recepción</small>
                        <p class="mb-0 fw-semibold">{{ $r->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-danger">Hora de recepción</small>
                        <p class="mb-0 fw-semibold">{{ $r->created_at->format('H:i') }} hrs</p>
                    </div>
                    <div class="col-6 col-md-3 text-md-end">
                        <small class="text-danger d-block">Estatus</small>
                        <span class="badge bg-{{ $r->status_color }} px-3 py-2">{{ $r->status_label }}</span>
                        <small class="text-muted d-block mt-1">La petición fue enviada correctamente por el ciudadano.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Columna izquierda: información de la petición --}}
            <div class="col-lg-7">

                <div class="card mb-4">
                    <div class="card-header pl-header"><h6 class="mb-0 text-white small text-uppercase">Datos del solicitante</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <small class="text-muted text-uppercase">Nombre completo</small>
                                <p class="mb-0 fw-semibold">{{ $r->full_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase">Teléfono de contacto</small>
                                <p class="mb-0 fw-semibold">{{ $r->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase">Correo electrónico</small>
                                <p class="mb-0 fw-semibold">{{ $r->email ?: ($r->user->email ?? '—') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header pl-header"><h6 class="mb-0 text-white small text-uppercase">Ubicación del reporte</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <small class="text-muted text-uppercase">Colonia</small>
                                <p class="mb-0 fw-semibold">{{ $r->colony }}</p>
                            </div>
                            <div class="col-md-5">
                                <small class="text-muted text-uppercase">Calle</small>
                                <p class="mb-0 fw-semibold">{{ $r->street }}</p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted text-uppercase">Número</small>
                                <p class="mb-0 fw-semibold">{{ $r->number ?: '—' }}</p>
                            </div>
                            <div class="col-12">
                                <small class="text-muted text-uppercase">Entre calles</small>
                                <p class="mb-0 fw-semibold">{{ $r->between_streets ?: '—' }}</p>
                            </div>
                            <div class="col-12">
                                <small class="text-muted text-uppercase">Referencias adicionales</small>
                                <p class="mb-0">{{ $r->references ?: '—' }}</p>
                            </div>
                            <div class="col-12">
                                <small class="text-muted text-uppercase d-block mb-2">Ubicación en mapa</small>
                                @if ($r->location_photo_s3_url)
                                    <a href="{{ $r->location_photo_s3_url }}" target="_blank" rel="noopener">
                                        <img src="{{ $r->location_photo_s3_url }}" class="img-fluid rounded-4 mb-2" alt="Imagen de referencia de la ubicación">
                                    </a>
                                @endif
                                @if ($r->map_url)
                                    <a href="{{ $r->map_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">
                                        <i class="ti ti-map-pin"></i> Abrir en Google Maps
                                    </a>
                                @elseif (! $r->location_photo_s3_url)
                                    <p class="mb-0 text-muted">El ciudadano no proporcionó ubicación en mapa.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header pl-header"><h6 class="mb-0 text-white small text-uppercase">Información del problema</h6></div>
                    <div class="card-body">
                        <small class="text-muted text-uppercase">Descripción del problema</small>
                        <div class="border rounded-3 bg-light p-3 mb-3">{!! nl2br(e($r->description)) !!}</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase">Número de poste / luminaria</small>
                                <p class="mb-0 fw-semibold">{{ $r->pole_number ?: '—' }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase">Desde cuándo presenta el problema</small>
                                <p class="mb-0 fw-semibold">{{ $r->problem_since ?: '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header pl-header d-flex justify-content-between">
                        <h6 class="mb-0 text-white small text-uppercase">Evidencia del problema</h6>
                        <small class="text-white">{{ $r->files->count() }} foto(s)</small>
                    </div>
                    <div class="card-body">
                        @include('public_lighting.requests._photos', ['photos' => $r->files])
                    </div>
                </div>

                <div class="card">
                    <div class="card-body py-2">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" {{ $r->terms_accepted ? 'checked' : '' }} disabled>
                            <label class="form-check-label small">
                                El ciudadano aceptó los términos y condiciones el {{ $r->created_at->format('d/m/Y') }} a las {{ $r->created_at->format('H:i') }} h.
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna derecha: gestión --}}
            <div class="col-lg-5">

                <div class="card mb-4">
                    <div class="card-header pl-header">
                        <h6 class="mb-0 text-white">Actualizar estatus</h6>
                        <small class="text-white-50">Al guardar se notifica al ciudadano</small>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('public_lighting.requests.update_status', $r) }}">
                            @csrf
                            <label class="form-label fw-semibold">Nuevo estatus *</label>
                            @foreach ($assignableStatuses as $key => $help)
                                <label class="border rounded-3 p-2 mb-2 d-flex gap-2 align-items-start w-100">
                                    <input class="form-check-input mt-1 pl-status" type="radio" name="status" value="{{ $key }}"
                                        {{ old('status') === $key ? 'checked' : '' }} required>
                                    <span>
                                        <span class="fw-semibold d-block">{{ \App\Models\PublicLightingRequest::STATUSES[$key][0] }}</span>
                                        <small class="text-muted">{{ $help }}</small>
                                    </span>
                                </label>
                            @endforeach

                            <label class="form-label fw-semibold mt-2" for="pl-message">Mensaje al ciudadano *</label>
                            <textarea name="message" id="pl-message" rows="4" class="form-control mb-3" required
                                placeholder="Selecciona un estatus para cargar el mensaje sugerido...">{{ old('message') }}</textarea>

                            <button type="submit" class="btn btn-success w-100">Guardar estatus y notificar</button>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-0">Historial y mensajes enviados</h6>
                            <small class="text-muted">{{ $r->logs->where('user_id', '!=', null)->count() }} mensajes enviados</small>
                        </div>
                        @forelse ($r->logs as $log)
                            <div class="d-flex gap-2 mb-3">
                                <span class="badge rounded-circle bg-{{ \App\Models\PublicLightingRequest::STATUSES[$log->status][1] ?? 'secondary' }} p-1 mt-1 align-self-start">&nbsp;</span>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong class="small">{{ $log->status_label }}</strong>
                                        <small class="text-muted">{{ $log->created_at->format('d/m/Y · H:i') }} h</small>
                                    </div>
                                    <small class="text-muted d-block">{{ $log->user->name ?? 'Sistema' }} · {{ $log->message }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Sin movimientos registrados.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header pl-header d-flex justify-content-between">
                        <h6 class="mb-0 text-white small text-uppercase">Evidencia de atención</h6>
                        <small class="text-white">{{ $r->attentionFiles->count() }} foto(s)</small>
                    </div>
                    <div class="card-body">
                        @include('public_lighting.requests._photos', ['photos' => $r->attentionFiles])

                        <form method="POST" action="{{ route('public_lighting.requests.upload_evidence', $r) }}" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="photos[]" accept="image/jpeg,image/png" multiple class="form-control" required>
                                <button type="submit" class="btn btn-outline-secondary">Subir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const messages = @json($suggestedMessages);
        const textarea = document.getElementById('pl-message');
        document.querySelectorAll('.pl-status').forEach(function (radio) {
            radio.addEventListener('change', function () {
                textarea.value = messages[this.value] || '';
                textarea.focus();
            });
        });
    })();
</script>
@endsection

@push('stylesheets')
    <style>
        .pl-header { background-color: #561a1d; }
    </style>
@endpush
