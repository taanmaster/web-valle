@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Popups @endslot
@slot('title') Editar Popup @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <form method="POST" action="{{ route('popups.update', $popup->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h4>Información General</h4>
                            <hr>
                            
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="style_type">Tipo de popup <span class="text-danger">*</span></label>
                                    <select id="style_type" name="style_type" class="form-control" onchange="showDiv('selector', this)">
                                        <option {{ ($popup->style_type == 'fixed') ? 'selected' : 'true' }} value="fixed">Fijo</option>
                                        <option  {{ ($popup->style_type == 'floating') ? 'selected' : 'true' }} value="floating">Flotante</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $popup->title }}" required="" />
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="subtitle">Subtítulo <span class="text-info">(Opcional)</span></label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $popup->subtitle }}" />
                                </div>
        
                                 <div class="form-group col-md-12">
                                    <label>Texto <span class="text-info">(Opcional)</span></label>
                                    <textarea class="form-control" id="body_text" name="text">{{ $popup->text }}</textarea>
                                 </div>
                            </div>
        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" {{ ($popup->show_on_enter == '1') ? 'checked' : 'true' }} class="custom-control-input" id="show_on_enter" name="show_on_enter" value="1">
                                        <label class="custom-control-label" for="show_on_enter">Mostrar al cargar la página</label>
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" {{ ($popup->show_on_exit == '1') ? 'checked' : 'true' }} class="custom-control-input" id="show_on_exit" name="show_on_exit" value="1">
                                        <label class="custom-control-label" for="show_on_exit">Mostrar al salir de la página</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                                <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="image">Imagen del popup <span class="text-success">Recomendado</span></label>
                                    <input type="file" id="image" class="form-control" name="image" />
                                    @if($popup->image)
                                    <img class="img-fluid mt-2" src="{{ asset('img/popups/' . $popup->image ) }}" alt="{{ $popup->title }}">
                                    @endif
                                </div>
                            </div>
        
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input {{ ($popup->has_button == '1') ? 'checked' : 'true' }} type="checkbox" class="custom-control-input" id="has_button" name="has_button" value="1">
                                        <label class="custom-control-label" for="has_button">Mostrar Botón</label>
                                    </div>
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="text_button">Texto en el botón <span class="text-info">(Opcional)</span></label>
                                    <input type="text" class="form-control" id="text_button" name="text_button" value="{{ $popup->text_button }}" />
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="link">URL del botón <span class="text-info">(Opcional)</span></label>
                                    <input type="url" class="form-control" id="link" name="link" value="{{ $popup->link }}" />
                                </div>
            
                                <div id="selector" class="form-group col-md-12 {{ ($popup->style_type == 'fixed') ? 'hiddenform' : '' }}">
                                    <label for="priority">Posición</label>
                                    <div class="row selector" name="priority">
        
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'top-left') ? 'checked' : 'true' }} name="position" value="top-left"> </input> 
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'top-mid') ? 'checked' : 'true' }} name="position" value="top-mid"> </input>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'top-right') ? 'checked' : 'true' }} name="position" value="top-right"> </input>
                                        </div>
        
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'mid-left') ? 'checked' : 'true' }} name="position" value="mid-left"> </input> 
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'mid-mid') ? 'checked' : 'true' }} name="position" value="mid-mid"> </input>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'mid-right') ? 'checked' : 'true' }} name="position" value="mid-right"> </input>
                                        </div>
        
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'bottom-left') ? 'checked' : 'true' }} name="position" value="bottom-left"> </input> 
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'bottom-mid') ? 'checked' : 'true' }} name="position" value="bottom-mid"> </input>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" class="cube" {{ ($popup->position == 'bottom-right') ? 'checked' : 'true' }} name="position" value="bottom-right"> </input>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="text-right mt-4 mb-5">
                        <a href="{{ route('popups.index') }}" class="btn btn-default btn-lg">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-lg">Actualizar Popup</button>
                    </div>
                </div>
        
                <!-- Preview -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Vista Previa</h4>
                            <hr>
                            <div class="d-flex">
                                <div class="card-banner d-flex justify-content-center align-items-center" id="hex_" style="background: {{ $popup->hex }}">
                                    <div class="card-banner-content">
                                        <h5 id="title_">{{ $popup->title }}</h5>
                                        <p id="subtitle_">{{ $popup->subtitle}}</p>
                                         @if ($popup->has_button == '1')
                                        <a href="#" class="btn btn-light rounded" id="text_button_">{{ $popup->text_button }}</a>
                                        @endif
                                    </div>
                                    <img src="{{ asset('img/popups/' . $popup->image ) }}" id="output" class="card-banner-image" width="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection