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
            <form method="POST" action="{{ route('headerbands.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body"> 
                        <h4>Información General</h4>
                        <hr>
                        
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="link">Mostrar en: 
                                    <span data-toggle="tooltip" data-placement="top" title="Este será el sitio web donde aparecerá este contenido."><i class="fas fa-info-circle"></i></span>
                                </label>
                                <select class="form-control" name="company_id" required>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

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

                <div class="text-right mt-40 mb-5">
                    <a href="{{ route('headerbands.index') }}" class="btn btn-default btn-lg">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-lg">Guardar Nuevo Cintillo</button>
                </div>
            </div>
        </form>
        </div>
    </div>

@endsection
