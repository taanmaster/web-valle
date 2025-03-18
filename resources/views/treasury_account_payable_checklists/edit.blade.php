@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Editar Checklist @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('treasury_account_payable_checklists.update', $checklist->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $checklist->name }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $checklist->description }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">Estado <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" {{ $checklist->status === 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ $checklist->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark btn-sm">Guardar cambios</button>
                        <a href="{{ route('treasury_account_payable_checklists.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection