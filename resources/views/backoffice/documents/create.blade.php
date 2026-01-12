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
@slot('li_3') <a href="{{ route('backoffice.documents.index') }}">Oficios</a> @endslot
@slot('title') Nuevo Oficio @endslot
@endcomponent

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Crear Nuevo Oficio</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backoffice.documents.store') }}" method="POST" id="documentForm">
                        @csrf

                        <!-- Información General -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> Información General</h6>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Dependencia Destino <span class="text-danger">*</span></label>
                                <select name="dependency_id" id="dependency_id" class="form-select @error('dependency_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar dependencia destino...</option>
                                    @foreach($dependencies as $dependency)
                                        <option value="{{ $dependency->id }}" 
                                                data-responsible="{{ $dependency->responsible_name }}"
                                                {{ old('dependency_id') == $dependency->id ? 'selected' : '' }}>
                                            {{ $dependency->formatted_code }} - {{ $dependency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Seleccione la dependencia a la que se enviará el oficio.</small>
                                @error('dependency_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Remitente (Destino)</label>
                                <input type="text" 
                                       id="sender_display" 
                                       class="form-control" 
                                       readonly 
                                       placeholder="Se llenará al seleccionar dependencia destino">
                                <small class="text-muted">Director de la dependencia destino.</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Asunto <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="subject" 
                                       class="form-control @error('subject') is-invalid @enderror" 
                                       value="{{ old('subject') }}" 
                                       placeholder="Asunto del oficio"
                                       required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Solicitante</label>
                                <input type="text" 
                                       class="form-control bg-light" 
                                       value="{{ $userDependency->responsible_name }}" 
                                       readonly>
                                <small class="text-muted">Director de tu dependencia: {{ $userDependency->name }}</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Prioridad <span class="text-danger">*</span></label>
                                <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                    <option value="baja" {{ old('priority', 'baja') == 'baja' ? 'selected' : '' }}>Baja</option>
                                    <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('priority') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="solicitud" {{ old('type', 'solicitud') == 'solicitud' ? 'selected' : '' }}>Solicitud</option>
                                    <option value="respuesta" {{ old('type') == 'respuesta' ? 'selected' : '' }}>Respuesta</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Cuerpo del Oficio -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-file-alt me-2 text-primary"></i> Cuerpo del Oficio</h6>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Contenido del Oficio <span class="text-danger">*</span></label>
                                <textarea name="body" 
                                          class="form-control @error('body') is-invalid @enderror" 
                                          rows="10" 
                                          placeholder="Escriba el contenido del oficio aquí..."
                                          required>{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('backoffice.documents.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Guardar como Borrador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Al cambiar la dependencia, actualizar el remitente
    document.getElementById('dependency_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const responsible = selectedOption.getAttribute('data-responsible') || '';
        document.getElementById('sender_display').value = responsible;
    });

    // Si hay una dependencia seleccionada al cargar, mostrar el remitente
    const dependencySelect = document.getElementById('dependency_id');
    if (dependencySelect.value) {
        const selectedOption = dependencySelect.options[dependencySelect.selectedIndex];
        document.getElementById('sender_display').value = selectedOption.getAttribute('data-responsible') || '';
    }
});
</script>
@endsection
