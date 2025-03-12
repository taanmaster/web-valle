@php
    $html_tag_data = [];
    $title = 'Popups';
    $description= 'Creación de Popups'
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
        <div class="row mb-4">
            <div class="col-md-6 text-left">
                <a href="{{ route('popups.index') }}" class="btn btn-info mr-2"><i class="simple-icon-arrow-left" aria-hidden="true"></i> Regresar</a>
            </div>
    
            <div class="col-md-6 text-right">
                <a href="{{ route('popups.edit', $popup->id ) }}" class="btn btn-primary mr-2"><i class="simple-icon-pencil"></i> Editar</a>
    
                <form method="POST" action="{{ route('popups.destroy', $popup->id) }}" style="display: inline-block;">
                    <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" data-original-title="Borrar">
                        <i class="simple-icon-trash"></i> Eliminar
                    </button>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="mb-0">
                                    Información del Banner 
    
                                    @if($popup->is_active == true)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Desactivado</span>
                                    @endif
                                </h4>
                                <hr>
                                
                                <div class="row mt-5">
                                    
                                    <div class="col">
                                        <h5>Título</h5>
                                        <p>{{ $popup->title }}</p>
    
                                        <h5>Subtítulo</h5>
                                        <p>{{ $popup->subtitle}}</p>
    
                                        <h5>Texto de botón</h5>
                                        <p>{{ $popup->text_button}}</p>
    
                                        <h5>Color</h5>
                                        <p>{{ $popup->hex}}</p>
                                    </div>
                                    <div class="col">
                                        <h5>Imagen</h5>
                                        <div class="card">
                                            <p class="badge badge-primary">Identificador de base de datos: {{ $popup->id }}</p>
                                            
                                            <div class="card-body">
                                                <img class="img-fluid mb-4" src="{{ asset('img/popups/' . $popup->image ) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
