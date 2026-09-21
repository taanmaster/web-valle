@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Fiscalización @endslot
@slot('li_3') <a href="{{ route('fiscalizacion.advertising_requests.index') }}">Publicidad en Vía Pública</a> @endslot
@slot('title') Nueva Solicitud @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-plus-circle me-2"></i> Captura de Permiso de Publicidad en Vía Pública
                        </h5>
                    </div>
                    <div class="card-body p-4">

                        <div class="alert alert-info d-flex align-items-start gap-2">
                            <i class="fas fa-info-circle mt-1"></i>
                            <div>Este trámite se captura únicamente por el personal de Fiscalización cuando el ciudadano acude en persona con su material publicitario.</div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                                <strong>Corrige los siguientes errores:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('fiscalizacion.advertising_requests.store') }}" enctype="multipart/form-data">
                            @csrf

                            <hr class="my-4">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-user text-primary me-2"></i> Datos del Ciudadano
                            </h6>
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <label class="form-label">Correo del Ciudadano <span class="text-danger">*</span></label>
                                    <input type="email" name="citizen_email" value="{{ old('citizen_email') }}"
                                        class="form-control @error('citizen_email') is-invalid @enderror"
                                        placeholder="correo@ejemplo.com" required>
                                    @error('citizen_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">El ciudadano debe estar previamente registrado en el portal.</small>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-bullhorn text-primary me-2"></i> Datos de la Publicidad
                            </h6>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Publicidad <span class="text-danger">*</span></label>
                                    <input type="text" name="advertising_type" value="{{ old('advertising_type') }}"
                                        class="form-control @error('advertising_type') is-invalid @enderror" required>
                                    @error('advertising_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Piezas Autorizadas</label>
                                    <input type="text" name="authorized_pieces" value="{{ old('authorized_pieces') }}" class="form-control">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Ubicaciones autorizadas</label>
                                    <input type="text" name="authorized_locations" value="{{ old('authorized_locations') }}" class="form-control">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Periodo autorizado</label>
                                    <input type="text" name="authorized_period" value="{{ old('authorized_period') }}" class="form-control" placeholder="Ej. 01/10/2026 al 15/10/2026">
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label">Descripción de la publicidad</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-file-invoice-dollar text-primary me-2"></i> Comprobante de pago
                            </h6>
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <label class="form-label">Comprobante de pago</label>
                                    <input type="file" name="documents[comprobante-pago]" class="form-control">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('fiscalizacion.advertising_requests.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Guardar
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
