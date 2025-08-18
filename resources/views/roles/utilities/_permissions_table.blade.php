<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Permiso</th>
                <th>Guard Name</th>
                <th>Roles Asignados</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>
                        <strong>{{ $permission->name }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $permission->guard_name }}</span>
                    </td>
                    <td>
                        @php
                            $rolesWithPermission = \Spatie\Permission\Models\Role::whereHas('permissions', function ($query) use ($permission) {
                                $query->where('id', $permission->id);
                            })->where('name', '!=', 'citizen')->get();
                        @endphp
                        @if($rolesWithPermission->count() > 0)
                            @foreach($rolesWithPermission as $role)
                                <span class="badge bg-primary me-1">{{ $role->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">Sin asignar</span>
                        @endif
                    </td>
                    <td>{{ $permission->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Acciones
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="openEditPermissionModal({
                                        id: {{ $permission->id }},
                                        name: '{{ $permission->name }}',
                                        guard_name: '{{ $permission->guard_name }}'
                                    })">
                                        <i class="bx bx-edit me-2"></i>Editar
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('roles.destroy-permission', $permission->id) }}" method="POST" style="display: inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Estás seguro de eliminar este permiso?')">
                                            <i class="bx bx-trash me-2"></i>Eliminar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
