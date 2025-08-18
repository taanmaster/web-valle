<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ciudadano</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Información Adicional</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citizenUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded-circle bg-success text-white">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="bx bx-user"></i> Ciudadano
                                </small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
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
                    <td>
                        @php
                            // Verificar si el usuario tiene información adicional en user_infos
                            $hasAdditionalInfo = false;
                            try {
                                $hasAdditionalInfo = DB::table('user_infos')->where('user_id', $user->id)->exists();
                            } catch (\Exception $e) {
                                // Si la tabla no existe aún, no mostrar error
                            }
                        @endphp
                        @if($hasAdditionalInfo)
                            <span class="badge bg-info">
                                <i class="bx bx-info-circle"></i> Perfil completo
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="bx bx-user-plus"></i> Perfil básico
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
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="openEditCitizenModal({
                                        id: {{ $user->id }},
                                        name: '{{ $user->name }}',
                                        email: '{{ $user->email }}'
                                    })">
                                        <i class="bx bx-edit me-2"></i>Editar
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('users.destroy-citizen', $user->id) }}" method="POST" style="display: inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario ciudadano?')">
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
