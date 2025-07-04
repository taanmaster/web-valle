@extends('layouts.master')

@section('title')Editar Especialidad @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.specialties.index') }}">Especialidades</a> @endslot
        @slot('title') Editar Especialidad @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-edit"></i> Editar Especialidad
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.specialties.show', $specialty->id) }}" class="btn btn-secondary btn-sm me-2">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('dif.specialties.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.specialties.update', $specialty->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Ingresa el nombre de la especialidad" value="{{ old('name', $specialty->name) }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description">Descripción:</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Ingresa la descripción de la especialidad (opcional)" rows="4">{{ old('description', $specialty->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="is_active">Estado:</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ old('is_active', $specialty->is_active) == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('is_active', $specialty->is_active) == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('dif.specialties.show', $specialty->id) }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
