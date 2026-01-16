@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('li_3') <a href="{{ route('backoffice.dependencies.index') }}">Dependencias</a> @endslot
@slot('title') Nueva Dependencia @endslot
@endcomponent

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Registrar Nueva Dependencia</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backoffice.dependencies.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Código <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="code" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       value="{{ old('code') }}" 
                                       placeholder="Ej: TS, DIF, DU..."
                                       maxlength="20"
                                       style="text-transform: uppercase;"
                                       required>
                                <small class="text-muted">Este código se usará para generar folios de oficios.</small>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nombre de la Dependencia <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Ej: Tesorería Municipal"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Director/Responsable <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="responsible_name" 
                                       class="form-control @error('responsible_name') is-invalid @enderror" 
                                       value="{{ old('responsible_name') }}" 
                                       placeholder="Nombre completo del responsable"
                                       required>
                                <small class="text-muted">Este nombre aparecerá como remitente en los oficios de esta dependencia.</small>
                                @error('responsible_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Tipo</label>
                                <input type="text" 
                                       name="type" 
                                       class="form-control @error('type') is-invalid @enderror" 
                                       value="{{ old('type') }}" 
                                       placeholder="Ej: Dirección, Coordinación, Departamento..."
                                       maxlength="255">
                                <small class="text-muted">Clasificación o tipo de dependencia (opcional).</small>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('backoffice.dependencies.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Guardar Dependencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
