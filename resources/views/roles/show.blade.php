@extends('layouts.master')

@section('title')Detalles del Rol @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Configuraciones @endslot
        @slot('li_3') <a href="{{ route('roles.index') }}">Roles</a> @endslot
        @slot('title') {{ $role->name }} @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información del Rol</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre:</label>
                        <p>{{ $role->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Guard Name:</label>
                        <p><span class="badge bg-info">{{ $role->guard_name }}</span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha de Creación:</label>
                        <p>{{ $role->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Última Actualización:</label>
                        <p>{{ $role->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                            <i class="bx bx-edit"></i> Editar Rol
                        </a>
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Volver a Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Permisos del Rol -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Permisos Asignados 
                        <span class="badge bg-secondary">{{ $permissions->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($permissions->count() > 0)
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <span class="badge bg-success">{{ $permission->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-shield-x display-4 text-muted"></i>
                            <p class="text-muted mt-2">Este rol no tiene permisos asignados.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Usuarios con este Rol -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Usuarios con este Rol 
                        <span class="badge bg-primary">{{ $users->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-primary">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    {{ $user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show"></i> Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-user-x display-4 text-muted"></i>
                            <p class="text-muted mt-2">No hay usuarios asignados a este rol.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
