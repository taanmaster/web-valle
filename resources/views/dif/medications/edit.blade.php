@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Editar Medicamento @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('dif.medications.update', $medication->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="generic_name" class="form-label">Nombre genérico <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="generic_name" name="generic_name" value="{{ $medication->generic_name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="commercial_name" class="form-label">Nombre comercial <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="commercial_name" name="commercial_name" value="{{ $medication->commercial_name }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $medication->description }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="formula" class="form-label">Fórmula <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="formula" name="formula" rows="2">{{ $medication->formula }}</textarea>
                            </div>

                            {{--  
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Presentación <span class="text-info tx-12">*</span></label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="Tableta" {{ $medication->type == 'Tableta' ? 'selected' : '' }}>Tableta</option>
                                    <option value="Cápsula" {{ $medication->type == 'Cápsula' ? 'selected' : '' }}>Cápsula</option>
                                    <option value="Píldora" {{ $medication->type == 'Píldora' ? 'selected' : '' }}>Píldora</option>
                                    <option value="Supositorio" {{ $medication->type == 'Supositorio' ? 'selected' : '' }}>Supositorio</option>
                                    <option value="Jarabe" {{ $medication->type == 'Jarabe' ? 'selected' : '' }}>Jarabe</option>
                                    <option value="Gotas" {{ $medication->type == 'Gotas' ? 'selected' : '' }}>Gotas</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="type_num" class="form-label">Cantidad <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="type_num" name="type_num" value="{{ $medication->type_num }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="type_dosage" class="form-label">Unidades</label>
                                <select name="type_dosage" id="type_dosage" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="mg" {{ $medication->type_dosage == 'mg' ? 'selected' : '' }}>mg</option>
                                    <option value="gr" {{ $medication->type_dosage == 'gr' ? 'selected' : '' }}>gr</option>
                                    <option value="ml" {{ $medication->type_dosage == 'ml' ? 'selected' : '' }}>ml</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="use_type" class="form-label">Vía de administración</label>
                                <select name="use_type" id="use_type" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="Oral" {{ $medication->use_type == 'Oral' ? 'selected' : '' }}>Oral</option>
                                    <option value="Tópica" {{ $medication->use_type == 'Tópica' ? 'selected' : '' }}>Tópica</option>
                                    <option value="Oftálmica" {{ $medication->use_type == 'Oftálmica' ? 'selected' : '' }}>Oftálmica</option>
                                    <option value="Ótica" {{ $medication->use_type == 'Ótica' ? 'selected' : '' }}>Ótica</option>
                                    <option value="Inyectable" {{ $medication->use_type == 'Inyectable' ? 'selected' : '' }}>Inyectable</option>
                                    <option value="Rectal" {{ $medication->use_type == 'Rectal' ? 'selected' : '' }}>Rectal</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expiration_date" class="form-label">Fecha de expiración <span class="text-danger tx-12">*</span></label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="{{ Carbon\Carbon::parse($medication->expiration_date)->format('Y-m-d') }}" required>
                            </div>
                            --}}

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $medication->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm">Actualizar Medicamento</button>
                                <a href="{{ route('dif.medications.show', $medication->id) }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
