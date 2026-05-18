<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold">ID</th>
                <th class="fw-semibold">Nombre</th>
                <th class="fw-semibold">CURP</th>
                <th class="fw-semibold">Información</th>
                <th class="fw-semibold">Dirección</th>
                <th class="fw-semibold"># Apoyos</th>
                <th class="fw-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citizens as $citizen)
                <tr>
                    <td><span class="badge bg-primary">#{{ $citizen->id }}</span></td>
                    <td>{{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }}</td>
                    <td><small class="text-muted">{{ $citizen->curp }}</small></td>
                    <td class="text-muted small">
                        <i class="fas fa-phone me-1"></i>{{ $citizen->phone ?? 'Sin Registro' }}<br>
                        <i class="fas fa-envelope me-1"></i>{{ $citizen->email ?? 'Sin Registro' }}
                    </td>
                    <td class="text-muted small">
                        {{ $citizen->address ?? $citizen->street }}<br>
                        {{ $citizen->colony }}
                    </td>
                    <td><span class="badge bg-info">{{ $citizen->supports->count() ?? 0 }}</span></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('citizens.show', $citizen->id) }}" class="btn btn-outline-primary" title="Ver" aria-label="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('citizens.edit', $citizen->id) }}" class="btn btn-outline-secondary" title="Editar" aria-label="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('citizens.destroy', $citizen->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Eliminar" aria-label="Eliminar"
                                    onclick="return confirm('¿Eliminar a {{ $citizen->name }} {{ $citizen->first_name }}? Esta acción no se puede deshacer.')"
                                    style="border-radius: 0 0.25rem 0.25rem 0;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
