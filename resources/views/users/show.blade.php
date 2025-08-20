@extends('layouts.master')
@section('title')Detalle de Usuario @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') <a href="{{ route('users.index') }}">Usuarios</a> @endslot
@slot('title') {{ $user->name }} @endslot
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
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información del Usuario</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar mb-3">
                        <span class="avatar-initial rounded-circle bg-success text-white">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">ID:</label>
                    <p>{{ $user->id }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email Verificado:</label>
                    <p>
                        @if($user->email_verified_at)
                            <span class="badge bg-success">
                                <i class="bx bx-check"></i> Verificado
                            </span>
                            <br>
                            <small class="text-muted">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                        @else
                            <span class="badge bg-warning">
                                <i class="bx bx-x"></i> No verificado
                            </span>
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Registro:</label>
                    <p>{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Última Actualización:</label>
                    <p>{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="bx bx-edit"></i> Editar Usuario
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Volver a Usuarios
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Roles del Usuario -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bx bx-user-check"></i> Roles Asignados
                    <span class="badge bg-primary">{{ $user->roles->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                @if($user->roles->count() > 0)
                    <div class="row">
                        @foreach($user->roles as $role)
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">{{ $role->name }}</h6>
                                            <span class="badge bg-info">{{ $role->guard_name }}</span>
                                        </div>
                                        <p class="text-muted small mb-2">
                                            Asignado: {{ $role->pivot->created_at ? $role->pivot->created_at->format('d/m/Y') : 'N/A' }}
                                        </p>
                                        <div class="text-end">
                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-show"></i> Ver Rol
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bx bx-user-x display-4 text-muted"></i>
                        <p class="text-muted mt-2">Este usuario no tiene roles asignados.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Permisos del Usuario -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bx bx-key"></i> Permisos
                    @php
                        $allPermissions = $user->getAllPermissions();
                    @endphp
                    <span class="badge bg-success">{{ $allPermissions->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                @if($allPermissions->count() > 0)
                    <div class="accordion" id="permissionsAccordion">
                        @php
                            $directPermissions = $user->getDirectPermissions();
                            $rolePermissions = $user->getPermissionsViaRoles();
                        @endphp

                        <!-- Permisos Directos -->
                        @if($directPermissions->count() > 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="directPermissionsHeading">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#directPermissions">
                                        Permisos Directos
                                        <span class="badge bg-warning ms-2">{{ $directPermissions->count() }}</span>
                                    </button>
                                </h2>
                                <div id="directPermissions" class="accordion-collapse collapse show" data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @foreach($directPermissions as $permission)
                                                <div class="col-md-4 mb-2">
                                                    <span class="badge bg-warning">{{ $permission->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Permisos por Roles -->
                        @if($rolePermissions->count() > 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="rolePermissionsHeading">
                                    <button class="accordion-button {{ $directPermissions->count() > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#rolePermissions">
                                        Permisos por Roles
                                        <span class="badge bg-success ms-2">{{ $rolePermissions->count() }}</span>
                                    </button>
                                </h2>
                                <div id="rolePermissions" class="accordion-collapse collapse {{ $directPermissions->count() == 0 ? 'show' : '' }}" data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        @foreach($user->roles as $role)
                                            @if($role->permissions->count() > 0)
                                                <div class="mb-3">
                                                    <h6 class="text-primary">
                                                        <i class="bx bx-user-check"></i> {{ $role->name }}
                                                        <span class="badge bg-primary">{{ $role->permissions->count() }}</span>
                                                    </h6>
                                                    <div class="row">
                                                        @foreach($role->permissions as $permission)
                                                            <div class="col-md-4 mb-1">
                                                                <span class="badge bg-success">{{ $permission->name }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @if(!$loop->last)<hr>@endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bx bx-shield-x display-4 text-muted"></i>
                        <p class="text-muted mt-2">Este usuario no tiene permisos asignados.</p>
                        <small class="text-muted">Los permisos pueden asignarse directamente al usuario o a través de roles.</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
