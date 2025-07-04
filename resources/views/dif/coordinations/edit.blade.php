@extends('layouts.master')

@section('title')Editar Coordinación @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.coordinations.index') }}">Coordinaciones</a> @endslot
        @slot('title') Editar Coordinación @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-edit"></i> Editar Coordinación
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.coordinations.show', $coordination->id) }}" class="btn btn-secondary btn-sm me-2">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('dif.coordinations.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.coordinations.update', $coordination->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">Nombre:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingresa el nombre de la coordinación" value="{{ old('name', $coordination->name) }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="description">Descripción:</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Ingresa la descripción de la coordinación (opcional)" rows="4">{{ old('description', $coordination->description) }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="is_active">Estado:</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option value="1" {{ old('is_active', $coordination->is_active) == '1' ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('is_active', $coordination->is_active) == '0' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5><i class="fas fa-folder"></i> Programas Asociados</h5>
                                <p class="text-muted">Selecciona los programas que pertenecen a esta coordinación:</p>
                                
                                @if($programs->count() > 0)
                                    <div class="programs-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                                        @foreach($programs as $program)
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="program_ids[]" value="{{ $program->id }}" class="form-check-input" id="program_{{ $program->id }}" {{ in_array($program->id, old('program_ids', $selectedPrograms)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="program_{{ $program->id }}">
                                                    <strong>{{ $program->name }}</strong>
                                                    @if($program->description)
                                                        <br><small class="text-muted">{{ Str::limit($program->description, 60) }}</small>
                                                    @endif
                                                    @if($program->full_address)
                                                        <br><small class="text-info"><i class="fas fa-map-marker-alt"></i> {{ $program->full_address }}</small>
                                                    @endif
                                                </label>
                                            </div>
                                            <hr class="my-2">
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPrograms()">
                                            <i class="fas fa-check-double"></i> Seleccionar Todos
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPrograms()">
                                            <i class="fas fa-times"></i> Deseleccionar Todos
                                        </button>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> No hay programas disponibles.
                                        <a href="{{ route('dif.programs.create') }}" class="btn btn-sm btn-primary ms-2">
                                            <i class="fas fa-plus"></i> Crear Programa
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('dif.coordinations.show', $coordination->id) }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
function selectAllPrograms() {
    $('.programs-container input[type="checkbox"]').prop('checked', true);
}

function deselectAllPrograms() {
    $('.programs-container input[type="checkbox"]').prop('checked', false);
}
</script>
@endsection
