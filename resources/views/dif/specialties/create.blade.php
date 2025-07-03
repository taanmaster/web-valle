@extends('layouts.master')

@section('title')Agregar Especialidad @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.specialties.index') }}">Especialidades</a> @endslot
        @slot('title') Agregar Especialidad @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-plus"></i> Agregar Especialidad
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.specialties.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.specialties.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Ingresa el nombre de la especialidad" value="{{ old('name') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description">Descripción:</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Ingresa la descripción de la especialidad (opcional)" rows="4">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="is_active">Estado:</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('dif.specialties.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
