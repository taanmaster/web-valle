<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
                    @foreach($locations as $location)
                    <tr>
                        <th scope="row">#{{ $location->id }}</th>
                        <td>{{ $location->name }}</td>
                        <td class="text-muted">
                            {{ $location->street_name }} #{{ $location->street_num }}<br>
                            {{ $location->colony ? Str::limit($location->colony, 30) . ' - ' : '' }}{{ $location->zip_code }}
                        </td>
                        <td>{{ $location->type }}</td>
                        <td>
                            <div class="d-flex gap-2" role="group" aria-label="Basic example">
                                <a href="{{ route('dif.locations.show', $location->id) }}" class="btn btn-sm btn-primary">Ver</a>
                                <a href="{{ route('dif.locations.edit', $location->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                                <form method="POST" action="{{ route('dif.locations.destroy', $location->id) }}" style="display: inline-block;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta locación?')">
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
