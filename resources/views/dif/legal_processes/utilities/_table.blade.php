<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Expediente</th>
                <th>Asesorado</th>
                <th>Demandado</th>
                <th>Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($processes as $process)
            <tr>
                <th scope="row">#{{ $process->id }}</th>
                <td>{{ $process->case_num }}</td>
                <td>{{ $process->advised_person }}</td>
                <td>{{ $process->sued_person }}</td>
                <td>
                    <span class="badge bg-info">{{ $process->status ?? '—' }}</span>
                </td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('dif.legal_processes.show', $process->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('dif.legal_processes.edit', $process->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('dif.legal_processes.destroy', $process->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este caso?')">
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
