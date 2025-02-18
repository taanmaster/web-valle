<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transparency_dependencies as $dependency)
            <tr>
                <th scope="row">#{{ $dependency->id }}</th>
                <td>
                    <a href="{{ route('transparency_dependencies.show', $dependency->id) }}">
                        {{ $dependency->name }}
                    </a>
                </td>

                <td>{{ $dependency->created_at }}</td>
                <td>{{ $dependency->updated_at }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('transparency_dependencies.show', $dependency->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i> Ver Detalle</a>

                        <form method="POST" action="{{ route('transparency_dependencies.destroy', $dependency->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-sm btn-icon">
                                <i class='bx bx-trash-alt text-danger'></i> Eliminar
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
 