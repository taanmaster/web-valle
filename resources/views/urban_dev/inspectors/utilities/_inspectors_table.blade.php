<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Inspector</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inspectors as $inspector)
                <tr>
                    <td>{{ $inspector->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded-circle bg-success text-white">
                                    {{ strtoupper(substr($inspector->name, 0, 2)) }}
                                </span>
                            </div>
                            <strong>{{ $inspector->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $inspector->email }}</td>
                    <td>
                        @if($inspector->email_verified_at)
                            <span class="badge bg-success">
                                <i class="bx bx-check"></i> Verificado
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="bx bx-time"></i> Pendiente
                            </span>
                        @endif
                    </td>
                    <td>{{ $inspector->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Acciones
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('urban_dev.inspectors.show', $inspector->id) }}">
                                        <i class="bx bx-show me-2"></i>Ver Detalles
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="openEditInspectorModal({
                                        id: {{ $inspector->id }},
                                        name: '{{ $inspector->name }}',
                                        email: '{{ $inspector->email }}'
                                    })">
                                        <i class="bx bx-edit me-2"></i>Editar
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('urban_dev.inspectors.destroy', $inspector->id) }}" method="POST" style="display: inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Estás seguro de eliminar este inspector?')">
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
