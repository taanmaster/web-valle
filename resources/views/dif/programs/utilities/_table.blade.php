<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($programs as $program)
            <tr>
                <th scope="row">#{{ $program->id }}</th>
                <td>{{ $program->name }}</td>
                <td class="text-muted">
                    {{ $program->description ? Str::limit($program->description, 50) : 'Sin descripción' }}
                </td>
                <td class="text-muted">
                    {{ $program->full_address ? Str::limit($program->full_address, 40) : 'Sin dirección' }}
                </td>
                <td>
                    @if($program->is_active)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('dif.programs.show', $program->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('dif.programs.edit', $program->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('dif.programs.destroy', $program->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este programa?')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
