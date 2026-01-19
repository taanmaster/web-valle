@extends('layouts.master')
@section('title')Intranet @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('li_3') <a href="{{ route('backoffice.dependencies.index') }}">Dependencias</a> @endslot
@slot('title') Editar Dependencia @endslot
@endcomponent

<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Dependencia</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backoffice.dependencies.update', $dependency->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Código <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="code" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       value="{{ old('code', $dependency->code) }}" 
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
                                       value="{{ old('name', $dependency->name) }}" 
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
                                       value="{{ old('responsible_name', $dependency->responsible_name) }}" 
                                       placeholder="Nombre completo del responsable"
                                       required>
                                <small class="text-muted">Este nombre aparecerá como "Solicitante" en los oficios creados por usuarios de esta dependencia.</small>
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
                                       value="{{ old('type', $dependency->type) }}" 
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
                                <i class="fas fa-save me-2"></i> Actualizar Dependencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel de Gestión de Usuarios -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i> Usuarios Asignados</h6>
                </div>
                <div class="card-body p-4">
                    <!-- Formulario para agregar usuario -->
                    <form action="{{ route('backoffice.dependencies.attach-user', $dependency->id) }}" method="POST" class="mb-4">
                        @csrf
                        <label class="form-label">Agregar Usuario</label>
                        <div class="input-group">
                            <select name="user_id" id="user_select" class="form-select" required>
                                <option value="">Buscar usuario...</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <small class="text-muted">Solo se muestran usuarios sin dependencia asignada.</small>
                    </form>

                    <!-- Lista de usuarios asignados -->
                    <h6 class="border-bottom pb-2 mb-3">Usuarios en esta dependencia</h6>
                    @if($dependency->users->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($dependency->users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br><small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <form action="{{ route('backoffice.dependencies.detach-user', [$dependency->id, $user->id]) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('¿Desasignar a {{ $user->name }} de esta dependencia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-user-slash fa-2x mb-2"></i>
                            <p class="mb-0">No hay usuarios asignados</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#user_select').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar usuario...',
        allowClear: true,
        ajax: {
            url: '{{ route("backoffice.dependencies.search-users") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });
});
</script>
@endsection
