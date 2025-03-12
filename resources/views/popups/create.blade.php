@php
    $html_tag_data = [];
    $title = 'Popups';
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

        <form method="POST" action="{{ route('popups.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
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
                                    <label for="subtitle">Subtítulo <span class="text-info">(Opcional)</span></label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" />
                                </div>
        
                                <div class="mb-3 col-md-12">
                                    <label>Texto <span class="text-info">(Opcional)</span></label>
                                    <textarea class="form-control" id="body_text" name="text"></textarea>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" checked="true" class="custom-control-input" id="show_on_enter" name="show_on_enter" value="1">
                                        <label class="custom-control-label" for="show_on_enter">Mostrar al cargar la página</label>
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="show_on_exit" name="show_on_exit" value="1">
                                        <label class="custom-control-label" for="show_on_exit">Mostrar al salir de la página</label>
                                    </div>
                                </div>
                            </div>
        
             
                            <hr>
        
                            <div class="row">
                                <!--
                                <div class="mb-3 col-md-6">
                                    <label for="hex">Color</label>
                                    <input type="color" class="form-control" id="hex" name="hex" value="{{ old('hex') ?? 'red' }}" required="" />
                                </div>
                                -->
        
                                <div class="mb-3 col-md-12">
                                    <label for="image">Imagen del popup <span class="text-success">Recomendado</span></label>
                                    <input type="file" id="image" class="form-control"  name="image" />
                                </div>
                            </div>
        
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="has_button" name="has_button" value="1">
                                        <label class="custom-control-label" for="has_button">Mostrar Botón</label>
                                    </div>
                                </div>
        
                                <div class="mb-3 col-md-6">
                                    <label for="text_button">Texto en el botón <span class="text-info">(Opcional)</span></label>
                                    <input type="text" class="form-control" id="text_button" name="text_button" value="{{ old('text_button') }}" />
                                </div>
        
                                <div class="mb-3 col-md-6">
                                    <label for="link">URL del botón <span class="text-info">(Opcional)</span></label>
                                    <input type="url" class="form-control" id="link" name="link" value="{{ old('link') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="text-right mt-4 mb-5">
                        <button type="submit" class="btn btn-primary">Guardar Nuevo Popup</button>
                        <a href="{{ route('popups.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
