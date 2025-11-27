<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($adminUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded-circle bg-primary text-white">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary me-1">{{ $role->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">Sin roles</span>
                        @endif
                    </td>
                    <td>
                        @if($user->email_verified_at)
                            <span class="badge bg-success">
                                <i class="bx bx-check"></i> Verificado
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="bx bx-time"></i> Pendiente
                            </span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Acciones
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.show', $user->id) }}">
                                        <i class="bx bx-show me-2"></i>Ver Detalles
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" 
                                       data-user-id="{{ $user->id }}"
                                       data-user-name="{{ $user->name }}"
                                       data-user-email="{{ $user->email }}"
                                       data-user-roles="{{ json_encode($user->roles->pluck('name')->toArray()) }}"
                                       onclick="openEditAdminModal(this)">
                                        <i class="bx bx-edit me-2"></i>Editar
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario administrativo?')">
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
