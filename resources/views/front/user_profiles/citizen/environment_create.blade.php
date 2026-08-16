@extends('front.layouts.app')

@section('title', 'Nueva Solicitud - Medio Ambiente')

@section('content')
    @php
        $isDonacion = $requestType === \App\Models\EnvironmentRequest::TYPE_DONACION;
        $formTitle = config("medio_ambiente.procedures.".($requestType === \App\Models\EnvironmentRequest::TYPE_PODA ? 'poda' : ($requestType === \App\Models\EnvironmentRequest::TYPE_TALA ? 'tala' : 'donacion-de-arboles')).".form_title");
    @endphp

    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <ion-icon name="leaf-outline"></ion-icon>
                            {{ $formTitle }}
                        </h5>
                        <span class="badge bg-primary text-uppercase">Nueva</span>
                    </div>
                    <div class="card-body">
                        <form id="environmentRequestForm" method="POST" action="{{ route('citizen.environment.store') }}">
                            @csrf
                            <input type="hidden" name="request_type" value="{{ $requestType }}">

                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Datos de la Solicitud</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tipo de trámite</label>
                                            <input type="text" class="form-control" value="{{ $formTitle }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Folio de Solicitud</label>
                                            <input type="text" class="form-control" value="Se genera al enviar" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Fecha de Solicitud</label>
                                            <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                                            @error('nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="domicilio" class="form-label">
                                                {{ $isDonacion ? 'Domicilio' : 'Domicilio Particular' }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="domicilio" id="domicilio" class="form-control @error('domicilio') is-invalid @enderror" value="{{ old('domicilio') }}" required>
                                            @error('domicilio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @unless ($isDonacion)
                                            <div class="col-md-6">
                                                <label for="colonia" class="form-label">Colonia <span class="text-danger">*</span></label>
                                                <input type="text" name="colonia" id="colonia" class="form-control @error('colonia') is-invalid @enderror" value="{{ old('colonia') }}" required>
                                                @error('colonia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="motivo" class="form-label">Motivo <span class="text-danger">*</span></label>
                                                <input type="text" name="motivo" id="motivo" class="form-control @error('motivo') is-invalid @enderror" value="{{ old('motivo') }}" required>
                                                @error('motivo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="telefono_celular" class="form-label">Teléfono Celular <span class="text-danger">*</span></label>
                                                <input type="text" name="telefono_celular" id="telefono_celular" class="form-control @error('telefono_celular') is-invalid @enderror" value="{{ old('telefono_celular') }}" required>
                                                @error('telefono_celular')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="telefono_fijo" class="form-label">Teléfono Fijo <span class="text-danger">*</span></label>
                                                <input type="text" name="telefono_fijo" id="telefono_fijo" class="form-control @error('telefono_fijo') is-invalid @enderror" value="{{ old('telefono_fijo') }}" required>
                                                @error('telefono_fijo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endunless
                                    </div>
                                </div>
                            </div>

                            @if ($isDonacion)
                                <p class="text-muted small">
                                    <ion-icon name="information-circle-outline"></ion-icon>
                                    Al enviar podrás adjuntar tu INE, carta compromiso y solicitud de donación.
                                </p>
                            @endif

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-warning fw-bold">Enviar Solicitud</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
