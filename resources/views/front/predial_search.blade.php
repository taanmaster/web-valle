@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Encabezado -->
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="fas fa-home fa-4x text-primary"></i>
                </div>
                <h1 class="display-5 fw-bold mb-3">Consulta tu Predial en Línea</h1>
                <p class="lead text-muted">
                    Ingresa los datos de tu propiedad para consultar tu estado de cuenta y recibos de predial
                </p>
            </div>

            <!-- Tarjeta de búsqueda -->
            <div class="card shadow-lg border-0 rounded-4 mb-5">
                <div class="card-body p-5">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('predial.search.results') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="taxpayer_phone" class="form-label fw-semibold">
                                <i class="fas fa-phone text-primary me-2"></i>
                                Teléfono del Contribuyente
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('taxpayer_phone') is-invalid @enderror" 
                                   id="taxpayer_phone" 
                                   name="taxpayer_phone" 
                                   placeholder="Ejemplo: 4721234567"
                                   value="{{ old('taxpayer_phone') }}"
                                   required>
                            @error('taxpayer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Ingresa el teléfono registrado en tu cuenta de predial (10 dígitos)
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="location_account" class="form-label fw-semibold">
                                <i class="fas fa-hashtag text-primary me-2"></i>
                                Cuenta Catastral
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('location_account') is-invalid @enderror" 
                                   id="location_account" 
                                   name="location_account" 
                                   placeholder="Ejemplo: 34A000005001"
                                   value="{{ old('location_account') }}"
                                   required>
                            @error('location_account')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Ingresa tu número de cuenta catastral (lo encuentras en tus recibos anteriores)
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>
                                Buscar mi Predial
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        ¿Necesitas ayuda?
                    </h5>
                    <p class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Teléfono:</strong> Es el que registraste al dar de alta tu propiedad
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Cuenta Catastral:</strong> Lo encuentras en tus recibos de predial anteriores
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-phone-alt text-primary me-2"></i>
                        <strong>¿No tienes tus datos?</strong> Comunícate con Tesorería Municipal para obtenerlos
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection