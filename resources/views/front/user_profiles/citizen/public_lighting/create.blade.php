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
                                </h5>
                                <p class="text-muted mb-0">Tipo de Trámite: Petición Servicio de Alumbrado Público</p>
                                <p class="text-muted mb-0">Fecha de Solicitud: {{ now()->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="badge bg-secondary">Nueva</span>
                        </div>

                        <form method="POST" action="{{ route('citizen.public_lighting.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- ===== DATOS DEL SOLICITANTE ===== --}}
                            <div class="card mb-4">
                                <div class="card-header text-white" style="background-color:#0d6e6e;">
                                    <strong>DATOS DEL SOLICITANTE</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Nombre Completo</label>
                                            <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Teléfono de contacto</label>
                                            <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Correo Electrónico</label>
                                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control">
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
                                            <label class="form-label">Colonia</label>
                                            <input type="text" name="colony" value="{{ old('colony') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Calle</label>
                                            <input type="text" name="street" value="{{ old('street') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Número</label>
                                            <input type="text" name="number" value="{{ old('number') }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Entre calles</label>
                                            <input type="text" name="between_streets" value="{{ old('between_streets') }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Referencias adicionales</label>
                                            <input type="text" name="references" value="{{ old('references') }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Ubicación en mapa</label>
                                            <div class="border border-dashed rounded p-3 text-center h-100">
                                                <ion-icon name="map-outline" style="font-size:1.5rem;"></ion-icon>
                                                <p class="mb-2 text-muted small">Copia la liga de Google Maps y pégala aquí</p>
                                                <input type="url" name="map_url" value="{{ old('map_url') }}" class="form-control" placeholder="https://maps.app.goo.gl/...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Fotografía del lugar</label>
                                            <div class="border border-dashed rounded p-3 text-center h-100">
                                                <ion-icon name="cloud-upload-outline" style="font-size:1.5rem;"></ion-icon>
                                                <p class="mb-2 text-muted small">Arrastra o selecciona JPG/PNG</p>
                                                <input type="file" name="location_photo" accept="image/jpeg,image/png" class="form-control">
                                            </div>
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
                                            <label class="form-label">Descripción</label>
                                            <textarea name="description" rows="4" class="form-control" required
                                                placeholder="Ej. La luminaria está apagada desde hace varios días.">{{ old('description') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Número de poste/luminaria, si existe</label>
                                            <input type="text" name="pole_number" value="{{ old('pole_number') }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Desde cuándo presenta el problema</label>
                                            <input type="text" name="problem_since" value="{{ old('problem_since') }}" class="form-control"
                                                placeholder="Ej. Hace una semana">
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
                                    <div class="border border-dashed rounded p-4 text-center">
                                        <ion-icon name="images-outline" style="font-size:1.5rem;"></ion-icon>
                                        <p class="mb-2 text-muted">Subir foto(s) — JPG/PNG, máximo 5</p>
                                        <input type="file" name="photos[]" accept="image/jpeg,image/png" multiple class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- ===== FOOTER ===== --}}
                            <div class="border rounded p-3 text-center">
                                <p class="small text-muted mb-2">Para enviar tu petición es necesario que aceptes los términos y condiciones.</p>
                                <div class="form-check d-inline-block mb-3">
                                    <input class="form-check-input" type="checkbox" name="terms_accepted" value="1" id="terms_accepted"
                                        {{ old('terms_accepted') ? 'checked' : '' }} required>
                                    <label class="form-check-label small" for="terms_accepted">
                                        Acepto los <a href="{{ route('contraloria.privacy_notice') }}" target="_blank">términos y condiciones y el aviso de privacidad</a>.
                                    </label>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-warning fw-bold">
                                        <ion-icon name="send-outline"></ion-icon> ENVIAR PETICIÓN
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
