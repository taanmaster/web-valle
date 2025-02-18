@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Obligaciones @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('transparency_obligations.update', $transparency_obligation->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $transparency_obligation->name }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $transparency_obligation->description }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Tipo <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="Especifica" {{ $transparency_obligation->type == 'Especifica' ? 'selected' : '' }}>Especifica</option>
                                    <option value="Común" {{ $transparency_obligation->type == 'Común' ? 'selected' : '' }}>Común</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="update_period" class="form-label">Periodo de Actualización <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="update_period" name="update_period" required>
                                    <option value="Trimestral" {{ $transparency_obligation->update_period == 'Trimestral' ? 'selected' : '' }}>Trimestral</option>
                                    <option value="Anual" {{ $transparency_obligation->update_period == 'Anual' ? 'selected' : '' }}>Anual</option>
                                    <option value="Semestral" {{ $transparency_obligation->update_period == 'Semestral' ? 'selected' : '' }}>Semestral</option>
                                    <option value="Trianual" {{ $transparency_obligation->update_period == 'Trianual' ? 'selected' : '' }}>Trianual</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection