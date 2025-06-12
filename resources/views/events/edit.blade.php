@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Eventos @endslot
@slot('title') Editar Evento @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nombre del Evento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $event->name }}" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="date_start" class="form-label">Fecha y Hora de Inicio <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="date_start" name="date_start" value="{{ date('Y-m-d\TH:i', strtotime($event->date_start)) }}" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="date_end" class="form-label">Fecha y Hora de Fin <span class="text-info">(Opcional)</span></label>
                                <input type="datetime-local" class="form-control" id="date_end" name="date_end" value="{{ $event->date_end ? date('Y-m-d\TH:i', strtotime($event->date_end)) : '' }}">
                                <small class="form-text text-muted">Deje vacío si es un evento sin hora de finalización definida.</small>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="location" class="form-label">Ubicación <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="blog_url" class="form-label">URL del Blog</label>
                                <input type="text" class="form-control" id="blog_url" name="blog_url" value="{{ $event->blog_url }}" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-left mt-4 mb-5">
                    <button type="submit" class="btn btn-primary btn-lg d-block w-100">Actualizar Evento</button>
                    <hr>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary d-block">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection