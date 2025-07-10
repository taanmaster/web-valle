@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Documentos
        @endslot
        @slot('title')
            Particulares
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-8">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('citizens.update', $citizen->id) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">Nombre del Beneficiario <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $citizen->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">Primer Apellido <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ $citizen->first_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Segundo Apellido <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ $citizen->last_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Teléfono <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $citizen->phone }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Correo Electrónico <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $citizen->email }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="curp" class="form-label">CURP <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="curp" name="curp"
                                        value="{{ $citizen->curp }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ine_number" class="form-label">INE Número <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="ine_number" name="ine_number"
                                        value="{{ $citizen->ine_number }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ine_section" class="form-label">Sección <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="ine_section" name="ine_section"
                                        value="{{ $citizen->ine_section }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label">Domicilio <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $citizen->address }}" required>
                                </div>
                                {{--
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Descripción <span
                                            class="text-info tx-12">(Opcional)</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $citizen->description }}</textarea>
                                </div>
                                 --}}

                                <div class="row">
                                    <button type="submit" class="btn btn-de-dark btn-sm">Guardar datos</button>
                                </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
