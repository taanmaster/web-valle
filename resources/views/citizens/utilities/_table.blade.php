<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Información</th>
                <th># de Apoyos</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($citizens as $citizen)
            <tr>
                <th scope="row">#{{ $citizen->id }}</th>
                <td>{{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }}</td>
                <td class="text-muted">{{ $citizen->phone }} <br>
                    {{ $citizen->email }} <br>
                    {{ $citizen->curp }}
                </td>

                <td>{{ $citizen->supports->count() ?? 0 }}</td>

                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('citizens.show', $citizen->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('citizens.edit', $citizen->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('citizens.destroy', $citizen->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger">
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