@extends('layouts.master')
@section('title')Intranet @endsection

@push('stylesheets')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Usuarios @endslot
@slot('title') Gestión de Usuarios @endslot
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
        <!-- Pestañas de navegación -->
        <ul class="nav nav-tabs mb-4" id="usersTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="admin-users-tab" data-bs-toggle="tab" data-bs-target="#admin-users" type="button" role="tab">
                    <i class='bx bx-user-check'></i> Usuarios Administrativos
                    <span class="badge bg-primary ms-1">{{ $adminUsers->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="citizens-tab" data-bs-toggle="tab" data-bs-target="#citizens" type="button" role="tab">
                    <i class='bx bx-group'></i> Usuarios Ciudadanos
                    <span class="badge bg-success ms-1">{{ $citizenUsers->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="usersTabContent">
            <!-- TAB DE USUARIOS ADMINISTRATIVOS -->
            <div class="tab-pane fade show active" id="admin-users" role="tabpanel">
                <div class="row">
                    <div class="col-md-2 d-flex mb-4">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateAdmin" class="btn btn-primary btn-sm">
                            <i class='bx bx-plus-circle mr-4'></i> Crear Usuario Admin
                        </a>
                    </div>

                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                @if($adminUsers->count() == 0)
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('img/illustration/group_13.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay usuarios administrativos!</h4>
                                    <p class="mb-4">Empieza a crear usuarios administrativos.</p>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateAdmin" class="btn btn-sm btn-primary btn-uppercase d-flex align-items-center text-uppercase fs-7">
                                        <i class='bx bx-plus-circle mr-4'></i> Crear Usuario Admin
                                    </a>
                                </div>
                                @else
                                    @include('users.utilities._admin_table')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB DE USUARIOS CIUDADANOS -->
            <div class="tab-pane fade" id="citizens" role="tabpanel">
                <div class="row">
                    <div class="col-md-2 d-flex mb-4">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateCitizen" class="btn btn-success btn-sm">
                            <i class='bx bx-plus-circle mr-4'></i> Crear Usuario Ciudadano
                        </a>
                    </div>

                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                @if($citizenUsers->count() == 0)
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('img/illustration/group_13.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay usuarios ciudadanos!</h4>
                                    <p class="mb-4">Empieza a crear usuarios ciudadanos.</p>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateCitizen" class="btn btn-sm btn-success btn-uppercase d-flex align-items-center text-uppercase fs-7">
                                        <i class='bx bx-plus-circle mr-4'></i> Crear Usuario Ciudadano
                                    </a>
                                </div>
                                @else
                                    @include('users.utilities._citizens_table')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODALES PARA USUARIOS ADMINISTRATIVOS -->
        <div id="modalCreateAdmin" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Usuario Administrativo</h6>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('users.store') }}">
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

                                <h6 class="mt-4">Definir Rol Administrativo</h6>
                                <hr>

                                <div class="col-md-12 mb-3">
                                    <select class="form-control" name="rol" required>
                                        <option value="">Selecciona un Rol</option>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear Usuario Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Usuario Admin -->
        <div id="modalEditAdmin" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario Administrativo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editAdminForm" method="POST" action="">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editAdminName" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="editAdminName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editAdminEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="editAdminEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editAdminPassword" class="form-label">Contraseña (Dejar vacío para mantener)</label>
                                <input type="password" class="form-control" id="editAdminPassword" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="editAdminRole" class="form-label">Roles</label>
                                <select class="form-control" id="editAdminRole" name="roles[]" multiple required>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Puedes seleccionar múltiples roles</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODALES PARA USUARIOS CIUDADANOS -->
        <div id="modalCreateCitizen" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Usuario Ciudadano</h6>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('users.store-citizen') }}">
                    {{ csrf_field() }}
                        <div class="modal-body pd-25">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="citizen_name">Nombre Completo</label>
                                    <input id="citizen_name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="citizen_email">Correo Electrónico</label>
                                    <input id="citizen_email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="citizen_password">Contraseña</label>
                                    <input id="citizen_password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="citizen_password_confirm">Confirmar Contraseña</label>
                                    <input id="citizen_password_confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="bx bx-info-circle"></i>
                                        <strong>Nota:</strong> Este usuario será creado con rol de "Ciudadano" automáticamente.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Crear Usuario Ciudadano</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Usuario Ciudadano -->
        <div id="modalEditCitizen" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario Ciudadano</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editCitizenForm" method="POST" action="">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editCitizenName" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="editCitizenName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCitizenEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="editCitizenEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCitizenPassword" class="form-label">Contraseña (Dejar vacío para mantener)</label>
                                <input type="password" class="form-control" id="editCitizenPassword" name="password">
                            </div>
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle"></i>
                                <strong>Nota:</strong> Este usuario mantendrá su rol de "Ciudadano".
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

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            // Inicializar Select2 cuando el DOM esté listo
            $(document).ready(function() {
                $('#editAdminRole').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Selecciona uno o más roles',
                    allowClear: false,
                    dropdownParent: $('#modalEditAdmin')
                });
            });

            function openEditAdminModal(element) {
                const userId = element.getAttribute('data-user-id');
                const userName = element.getAttribute('data-user-name');
                const userEmail = element.getAttribute('data-user-email');
                const userRoles = JSON.parse(element.getAttribute('data-user-roles'));
                
                const form = document.getElementById('editAdminForm');
                form.action = `{{ route('users.update', '') }}/${userId}`;
                document.getElementById('editAdminName').value = userName;
                document.getElementById('editAdminEmail').value = userEmail;
                document.getElementById('editAdminPassword').value = '';
                
                // Seleccionar múltiples roles con Select2
                $('#editAdminRole').val(userRoles).trigger('change');
                
                new bootstrap.Modal(document.getElementById('modalEditAdmin')).show();
            }

            function openEditCitizenModal(user) {
                const form = document.getElementById('editCitizenForm');
                form.action = `{{ route('users.update-citizen', '') }}/${user.id}`;
                document.getElementById('editCitizenName').value = user.name;
                document.getElementById('editCitizenEmail').value = user.email;
                new bootstrap.Modal(document.getElementById('modalEditCitizen')).show();
            }

            // Activar pestaña de ciudadanos si viene de un redirect
            $(document).ready(function() {
                if (window.location.hash === '#citizens') {
                    const citizensTab = new bootstrap.Tab(document.getElementById('citizens-tab'));
                    citizensTab.show();
                }
            });
        </script>
        @endpush
    </div>
</div>

@endsection
