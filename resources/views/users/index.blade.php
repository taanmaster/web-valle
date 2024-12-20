@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Usuarios @endslot
@slot('title') Listado @endslot
@endcomponent

<div class="row">
    <div class="col">
        <div class="row"> 
            <div class="col md-2 d-flex mb-4">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary btn-sm"><i class='bx bx-plus-circle mr-4'></i> Crear Nuevo Usuario</a>
            </div>
    
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        @if($users->count() == 0)
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('img/illustration/group_13.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay elementos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('users.create') }}" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase d-flex align-items-center text-uppercase fs-7"><i class='bx bx-plus-circle mr-4'></i> Crear Nuevo Usuario</a>
                        </div>
                        @else
                            @include('users.utilities._table')
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    
        <div id="modalCreate" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Usuario</h6>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
    
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="modal-body pd-25">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name">Nombre Completo</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
            
                                <div class="col-md-12 mb-3">
                                    <label for="email">Correo Electrónico</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>
            
                                <div class="col-md-6 mb-3">
                                    <label for="password">Contraseña</label>
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                </div>
            
                                <div class="col-md-6 mb-3">
                                    <label for="password-confirm">Confirmar Contraseña</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
            
                                <h6 class="mt-4">Definir Roles</h6>
                                <hr>
            
                                <div class="col-md-12 mb-3">
                                    <select class="form-control" name="rol">
                                        <option value="0">Selecciona un Rol de Usuario</option>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->name }}">
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear Nuevo Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
