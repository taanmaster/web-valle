<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Pertenece a</th>
                <th>Tipo</th>
                <th>Periodo de Actualización</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transparency_obligations as $transparency_obligation)
            <tr>
                <th scope="row">#{{ $transparency_obligation->id }}</th>
                <td>
                    <a href="{{ route('transparency_obligations.show', $transparency_obligation->id) }}">
                        {{ $transparency_obligation->name }}
                    </a>
                </td>
                <td>{{ $transparency_obligation->dependency->name ?? 'Sin Dependencia' }}</td>
                <td>{{ $transparency_obligation->type }}</td>
                <td>{{ $transparency_obligation->update_period }}</td>
                <td>{{ $transparency_obligation->created_at }}</td>
                <td>{{ $transparency_obligation->updated_at }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('transparency_obligations.show', $transparency_obligation->id) }}" class="btn btn-sm btn-outline-primary">Ver Detalle</a>
                        <a href="{{ route('transparency_obligations.edit', $transparency_obligation->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        
                        @if (auth()->user()->hasRole('transparency_admin') || auth()->user()->hasRole('all'))  
                        <form method="POST" action="{{ route('transparency_obligations.destroy', $transparency_obligation->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class='bx bx-trash-alt text-danger'></i> Eliminar
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        @endif
                    </div>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>