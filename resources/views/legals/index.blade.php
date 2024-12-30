@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Configuraciones @endslot
@slot('title') Textos Legales @endslot
@endcomponent

<div class="row"> 
    <div class="col-lg-12 mb-4">
        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase text-uppercase fs-7"><i class='bx bx-plus-circle mr-4'></i> Nuevo Texto Legal</a>
    </div>
</div>

@include('legals.utilities._modal')

@if($legals->count() == 0)
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body"> 
                <div class="text-center" style="padding:80px 0px 100px 0px;">
                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                    <h4>¡No hay elementos guardados en la base de datos!</h4>
                    <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase text-uppercase fs-7"><i class='bx bx-plus-circle mr-4'></i> Nuevo Texto Legal</a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    @foreach($legals as $legal)
    <div class="col-md-4">
        <div class="card card-body">
            <h2>{{ $legal->title }}</h2>
            <div class="d-flex align-items-center gap-2">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalEdit_{{ $legal->id }}" class="btn btn-sm btn-outline-primary">Editar</a>
            
                <form method="POST" action="{{ route('legals.destroy', $legal->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit"  class="btn btn-sm btn-outline-danger">Eliminar</button> 
                </form>
            </div>
            
            <hr>
            <p class="mb-0">Creado: {{ $legal->created_at }}</p>
            <p>Actualizado: {{ $legal->updated_at }}</p>
        </div>
    </div>

    <div class="modal fade" id="modalEdit_{{ $legal->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit_{{ $legal->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h6 class="modal-title m-0 text-white" id="modalEdit_{{ $legal->id }}">Nuevo Texto Legal</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->

                <form method="POST" action="{{ route('legals.update', $legal->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="modal-body pd-25">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label>Nombre del texto <span class="text-dange">*</span></label>
                                <input type="text" name="title" value="{{ $legal->title }}" required="" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Prioridad <span class="text-info">(Opcional)</span></label>
                                <select class="form-control" name="priority">
                                    <option {{ ($legal->priority == '1') ? 'selected' : '' }} value="1">1</option>
                                    <option {{ ($legal->priority == '2') ? 'selected' : '' }} value="2">2</option>
                                    <option {{ ($legal->priority == '3') ? 'selected' : '' }} value="3">3</option>
                                    <option {{ ($legal->priority == '4') ? 'selected' : '' }} value="4">4</option>
                                    <option {{ ($legal->priority == '5') ? 'selected' : '' }} value="5">5</option>
                                    <option {{ ($legal->priority == '6') ? 'selected' : '' }} value="6">6</option>
                                    <option {{ ($legal->priority == '7') ? 'selected' : '' }} value="7">7</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="type" value="{{ $legal->type }}">
                        <textarea name="description" id="" class="form-control" cols="30" rows="10">{!! $legal->description ?? '' !!}</textarea>
                        
                        <textarea id="justHtml_{{ $legal->id }}" name="description" required="" style="display:none;">{!! $legal->description ?? '' !!}</textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-de-dark btn-sm">Guardar datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
