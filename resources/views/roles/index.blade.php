@extends('layouts.master')

@section('title')Intranet @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Configuraciones @endslot
        @slot('title') Roles y Permisos @endslot
    @endcomponent

    @include('layouts.utilities._messages')

    <div class="row">
        <div class="col">
            <div class="alert alert-warning">
                <strong>¡Aviso!</strong>

                <ol class="mb-0">
                   <li>Los cambios en los roles y permisos pueden afectar el acceso de los usuarios.</li>
                   <li>Es recomendable realizar pruebas exhaustivas después de cualquier modificación.</li>
                   <li>Se tiene que crear primero los PERMISOS para poder asociarlos a los roles.</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <!-- Pestañas de navegación -->
            <ul class="nav nav-tabs mb-4" id="rolesPermissionsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab">
                        <i class='bx bx-user-check'></i> Roles
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab">
                        <i class='bx bx-key'></i> Permisos
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="rolesPermissionsTabContent">
                <!-- TAB DE ROLES -->
                <div class="tab-pane fade show active" id="roles" role="tabpanel">
                    <div class="row"> 
                        <div class="col-md-2 d-flex mb-4">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateRole" class="btn btn-primary btn-sm">
                                <i class='bx bx-plus-circle mr-4'></i> Crear Nuevo Rol
                            </a>
                        </div>
                
                        <div class="col-lg-12">
                            <div class="box">
                                <div class="box-body"> 
                                    @if($roles->count() == 0)
                                    <div class="text-center" style="padding:80px 0px 100px 0px;">
                                        <img src="{{ asset('img/illustration/group_13.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                                        <h4>¡No hay roles guardados en la base de datos!</h4>
                                        <p class="mb-4">Empieza a crearlos en la sección correspondiente.</p>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateRole" class="btn btn-sm btn-primary btn-uppercase d-flex align-items-center text-uppercase fs-7">
                                            <i class='bx bx-plus-circle mr-4'></i> Crear Nuevo Rol
                                        </a>
                                    </div>
                                    @else
                                        @include('roles.utilities._table')
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB DE PERMISOS -->
                <div class="tab-pane fade" id="permissions" role="tabpanel">
                    <div class="row">
                        <div class="col-md-2 d-flex mb-4">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreatePermission" class="btn btn-success btn-sm">
                                <i class='bx bx-plus-circle mr-4'></i> Crear Nuevo Permiso
                            </a>
                        </div>

                        <div class="col-lg-12">
                            <div class="box">
                                <div class="box-body">
                                    @if($permissions->count() == 0)
                                    <div class="text-center" style="padding:80px 0px 100px 0px;">
                                        <img src="{{ asset('img/illustration/group_13.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                                        <h4>¡No hay permisos guardados en la base de datos!</h4>
                                        <p class="mb-4">Empieza a crearlos en la sección correspondiente.</p>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreatePermission" class="btn btn-sm btn-success btn-uppercase d-flex align-items-center text-uppercase fs-7">
                                            <i class='bx bx-plus-circle mr-4'></i> Crear Nuevo Permiso
                                        </a>
                                    </div>
                                    @else
                                        @include('roles.utilities._permissions_table')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODALES DE ROLES -->
            <div id="modalCreateRole" class="modal fade">
                <div class="modal-dialog modal-dialog-vertical-center" role="document">
                    <div class="modal-content bd-0 tx-14">
                        <div class="modal-header">
                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Rol</h6>
                            <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
        
                        <form method="POST" action="{{ route('roles.store') }}">
                        {{ csrf_field() }}
                            <div class="modal-body pd-25">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Nombre del Rol</label>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                
                                    <div class="col-md-12 mb-3">
                                        <label for="guard_name">Guard Name</label>
                                        <select id="guard_name" class="form-control" name="guard_name" required>
                                            <option value="web" selected>Web</option>
                                            <option value="api">API</option>
                                        </select>
                                    </div>
                
                                    <h6 class="mt-4">Asignar Permisos</h6>
                                    <hr>
                
                                    <div class="col-md-12 mb-3">
                                        @if($permissions->count() > 0)
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}">
                                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No hay permisos disponibles.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Crear Nuevo Rol</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal para Editar Rol -->
            <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editRoleForm" method="POST" action="">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editName" class="form-label">Nombre del Rol</label>
                                    <input type="text" class="form-control" id="editName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editGuardName" class="form-label">Guard Name</label>
                                    <select id="editGuardName" class="form-control" name="guard_name" required>
                                        <option value="web">Web</option>
                                        <option value="api">API</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <h6>Permisos</h6>
                                    <hr>
                                    <div id="editPermissions" class="row">
                                        @foreach($permissions as $permission)
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input edit-permission" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="edit_permission_{{ $permission->id }}">
                                                    <label class="form-check-label" for="edit_permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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

            <!-- MODALES DE PERMISOS -->
            <div id="modalCreatePermission" class="modal fade">
                <div class="modal-dialog modal-dialog-vertical-center" role="document">
                    <div class="modal-content bd-0 tx-14">
                        <div class="modal-header">
                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Permiso</h6>
                            <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form method="POST" action="{{ route('roles.store-permission') }}">
                        {{ csrf_field() }}
                            <div class="modal-body pd-25">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="permission_name">Nombre del Permiso</label>
                                        <input id="permission_name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        <small class="form-text text-muted">Ejemplo: crear-usuarios, ver-reportes, administrar-contenido</small>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="permission_guard_name">Guard Name</label>
                                        <select id="permission_guard_name" class="form-control" name="guard_name" required>
                                            <option value="web" selected>Web</option>
                                            <option value="api">API</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Crear Permiso</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Editar Permiso -->
            <div id="modalEditPermission" class="modal fade">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Permiso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editPermissionForm" method="POST" action="">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editPermissionName" class="form-label">Nombre del Permiso</label>
                                    <input type="text" class="form-control" id="editPermissionName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editPermissionGuardName" class="form-label">Guard Name</label>
                                    <select id="editPermissionGuardName" class="form-control" name="guard_name" required>
                                        <option value="web">Web</option>
                                        <option value="api">API</option>
                                    </select>
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
                function openEditModal(role) {
                    const form = document.getElementById('editRoleForm');
                    form.action = `{{ route('roles.update', '') }}/${role.id}`;
                    document.getElementById('editName').value = role.name;
                    document.getElementById('editGuardName').value = role.guard_name;
                    
                    // Limpiar checkboxes
                    const checkboxes = document.querySelectorAll('.edit-permission');
                    checkboxes.forEach(checkbox => checkbox.checked = false);
                    
                    // Marcar permisos del rol
                    if (role.permissions) {
                        role.permissions.forEach(permission => {
                            const checkbox = document.getElementById(`edit_permission_${permission.id}`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }
                    
                    new bootstrap.Modal(document.getElementById('modalEdit')).show();
                }

                function openEditPermissionModal(permission) {
                    const form = document.getElementById('editPermissionForm');
                    form.action = `{{ route('roles.update-permission', '') }}/${permission.id}`;
                    document.getElementById('editPermissionName').value = permission.name;
                    document.getElementById('editPermissionGuardName').value = permission.guard_name;
                    
                    new bootstrap.Modal(document.getElementById('modalEditPermission')).show();
                }

                // Activar pestaña de permisos si viene de un redirect
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.location.hash === '#permissions') {
                        const permissionsTab = new bootstrap.Tab(document.getElementById('permissions-tab'));
                        permissionsTab.show();
                    }
                });
            </script>
        </div>
    </div>

@endsection

@section('script')

@endsection
