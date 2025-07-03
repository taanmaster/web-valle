@extends('layouts.master')

@section('title')Editar Tipo de Consulta @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.consult_types.index') }}">Tipos de Consulta</a> @endslot
        @slot('title') Editar Tipo de Consulta @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-edit"></i> Editar Tipo de Consulta
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.consult_types.show', $consultType->id) }}" class="btn btn-secondary btn-sm me-2">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('dif.consult_types.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.consult_types.update', $consultType->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Ingresa el nombre del tipo de consulta" value="{{ old('name', $consultType->name) }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Descripción:</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Ingresa la descripción del tipo de consulta (opcional)" rows="4">{{ old('description', $consultType->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('dif.consult_types.show', $consultType->id) }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
