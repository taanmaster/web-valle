@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Cintillos @endslot
@slot('title') Editar Cintillo @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <form method="POST" action="{{ route('headerbands.update', $headerband->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>Información General</h5>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="title">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $headerband->title }}" required="" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="band_link">URL del cintillo <span class="text-info">(Opcional)</span></label>
                                    <input type="text" class="form-control" id="band_link" name="band_link" value="{{ $headerband->band_link }}" />
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Texto  <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="text" required="">{{ $headerband->text }}</textarea>
                                </div>
    
                                <div class="form-group col-md-6">
                                    <label for="text_button">Color del texto<span class="text-danger">*</span></label>
                                    <input type="color" class="form-control" name="hex_text" required="" value="{{ $headerband->hex_text }}" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="text_button">Color del cintillo<span class="text-danger">*</span></label>
                                    <input type="color" class="form-control" name="hex_background" required="" value="{{ $headerband->hex_background }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="priority">Prioridad</label>
                                    <select class="form-control" name="priority">
                                    <option {{ ($headerband->priority == '1') ? 'selected' : '' }} value="1">1</option>
                                    <option {{ ($headerband->priority == '2') ? 'selected' : '' }} value="2">2</option>
                                    <option {{ ($headerband->priority == '3') ? 'selected' : '' }} value="3">3</option>
                                    <option {{ ($headerband->priority == '4') ? 'selected' : '' }} value="4">4</option>
                                    <option {{ ($headerband->priority == '5') ? 'selected' : '' }} value="5">5</option>
                                    <option {{ ($headerband->priority == '6') ? 'selected' : '' }} value="6">6</option>
                                    <option {{ ($headerband->priority == '7') ? 'selected' : '' }} value="7">7</option>
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4 mb-5">
                        <button type="submit" class="btn btn-primary btn-lg d-block w-100">Guardar Cintillo</button>
                        <hr>
                        <a href="{{ route('headerbands.index') }}" class="btn btn-secondary d-block">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection