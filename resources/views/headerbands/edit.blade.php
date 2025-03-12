@php
    $html_tag_data = [];
    $title = 'Empresas';
    $description= 'Creación de Empresas'
@endphp
@extends('layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')
@endsection

@section('js_vendor')
@endsection

@section('js_page')
@endsection

@section('content')
<form method="POST" action="{{ route('headerbands.update', $headerband->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    
    <div class="col">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container mb-3">
            <div class="row">
                <!-- Title Start -->
                <div class="col mb-2">
                    <h1 class="mb-2 pb-0 display-4" id="title">{{ $title }}</h1>
                    <div class="text-muted font-heading text-small">Let us manage the database engines for your applications so you can focus on building.</div>
                </div>
                <!-- Title End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <div class="row"> 
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body"> 
                        <h4>Información General</h4>
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

                <div class="text-right mt-40 mb-5">
                    <a href="{{ route('headerbands.index') }}" class="btn btn-default btn-lg">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-lg">Guardar Cintillo</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
