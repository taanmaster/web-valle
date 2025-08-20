<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Valor</th>
                <th>Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($assistances as $assistance)
            <tr>
                <th scope="row">#{{ $assistance->id }}</th>
                <td>{{ $assistance->name }}</td>
                <td>{{ $assistance->value ?? '—' }}</td>
                <td>
                    @if($assistance->is_active)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('dif.social_assistances.show', $assistance->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('dif.social_assistances.edit', $assistance->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('dif.social_assistances.destroy', $assistance->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este apoyo?')">
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
