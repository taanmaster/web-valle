@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('title') Gestión de Inspectores @endslot
@endcomponent

<style>
    .avatar{
        width: 30px;
        height: 30px;
        font-size: 14px;
    }

    .avatar-initial{
        width: 30px;
        height: 30px;
        display: block;
        text-align: center;
        line-height: 30px;
        font-size: 14px;
    }
</style>

<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-2 d-flex mb-4">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateInspector" class="btn btn-success btn-sm">
                    <i class='bx bx-plus-circle mr-4'></i> Crear Inspector
                </a>
            </div>

            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        @if($inspectors->count() == 0)
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('img/illustration/group_13.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay inspectores registrados!</h4>
                            <p class="mb-4">Empieza a crear inspectores para el área de Desarrollo Urbano.</p>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateInspector" class="btn btn-sm btn-success btn-uppercase d-flex align-items-center text-uppercase fs-7">
                                <i class='bx bx-plus-circle mr-4'></i> Crear Inspector
                            </a>
                        </div>
                        @else
                            @include('urban_dev.inspectors.utilities._inspectors_table')
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- MODAL PARA CREAR INSPECTOR -->
        <div id="modalCreateInspector" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Inspector</h6>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('urban_dev.inspectors.store') }}">
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

                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-info">
                                        <i class="bx bx-info-circle me-2"></i>
                                        <strong>Rol:</strong> Este usuario será creado automáticamente con el rol de "Inspector".
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Crear Inspector</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Inspector -->
        <div id="modalEditInspector" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Inspector</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editInspectorForm" method="POST" action="">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editInspectorName" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="editInspectorName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editInspectorEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="editInspectorEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editInspectorPassword" class="form-label">Contraseña (Dejar vacío para mantener)</label>
                                <input type="password" class="form-control" id="editInspectorPassword" name="password">
                            </div>
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle me-2"></i>
                                <strong>Rol:</strong> Este usuario mantendrá automáticamente el rol de "Inspector".
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openEditInspectorModal(inspector) {
                const form = document.getElementById('editInspectorForm');
                form.action = `{{ route('urban_dev.inspectors.update', '') }}/${inspector.id}`;
                document.getElementById('editInspectorName').value = inspector.name;
                document.getElementById('editInspectorEmail').value = inspector.email;
                new bootstrap.Modal(document.getElementById('modalEditInspector')).show();
            }
        </script>
    </div>
</div>

@endsection
