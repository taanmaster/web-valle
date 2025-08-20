<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Rol</th>
                <th>Guard Name</th>
                <th>Permisos</th>
                <th>Usuarios</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>
                        <strong>{{ $role->name }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $role->guard_name }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $role->permissions->count() }} permisos</span>
                    </td>
                    <td>
                        @php
                            $userCount = \App\Models\User::role($role->name)->count();
                        @endphp
                        <span class="badge bg-primary">{{ $userCount }} usuarios</span>
                    </td>
                    <td>{{ $role->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Acciones
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('roles.show', $role->id) }}">
                                        <i class="bx bx-show me-2"></i>Ver Detalles
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="openEditModal({
                                        id: {{ $role->id }},
                                        name: '{{ $role->name }}',
                                        guard_name: '{{ $role->guard_name }}',
                                        permissions: @json($role->permissions)
                                    })">
                                        <i class="bx bx-edit me-2"></i>Editar
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Estás seguro de eliminar este rol?')">
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
