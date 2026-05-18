@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Editar Particular @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Particular</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('citizens.update', $citizen->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label fw-semibold">Nombre del Beneficiario <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $citizen->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label fw-semibold">Primer Apellido <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ $citizen->first_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label fw-semibold">Segundo Apellido <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ $citizen->last_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-semibold">Teléfono <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $citizen->phone }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Correo Electrónico <span class="text-muted fw-normal">(Opcional)</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $citizen->email }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="curp" class="form-label fw-semibold">CURP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="curp" name="curp"
                                        value="{{ $citizen->curp }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ine_number" class="form-label fw-semibold">INE Número <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ine_number" name="ine_number"
                                        value="{{ $citizen->ine_number }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ine_section" class="form-label fw-semibold">Sección <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ine_section" name="ine_section"
                                        value="{{ $citizen->ine_section }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label fw-semibold">Calle y número <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $citizen->street }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="colony" class="form-label fw-semibold">Colonia <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="colony" name="colony"
                                        value="{{ $citizen->colony }}" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('citizens.show', $citizen->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
