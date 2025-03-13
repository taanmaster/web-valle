@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Cintillos @endslot
@slot('title') Crear Cintillo @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <form method="POST" action="{{ route('headerbands.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>Información General</h5>
                            <hr>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="title">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required="" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="band_link">URL del cintillo <span class="text-info">(Opcional)</span></label>
                                    <input type="text" class="form-control" id="band_link" name="band_link" value="{{ old('subtitle') }}" />
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label>Texto  <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="text" required=""></textarea>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="text_button">Color del texto<span class="text-danger">*</span></label>
                                    <input type="color" class="form-control" name="hex_text" required="" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="text_button">Color del cintillo<span class="text-danger">*</span></label>
                                    <input type="color" class="form-control" name="hex_background" required="" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="priority">Prioridad</label>
                                    <select class="form-control" name="priority">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4 mb-5">
                        <button type="submit" class="btn btn-primary btn-lg d-block w-100">Guardar Nuevo Cintillo</button>
                        <hr>
                        <a href="{{ route('headerbands.index') }}" class="btn btn-secondary d-block">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection