<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($citizens as $citizen)
            <tr>
                <th scope="row">#{{ $citizen->id }}</th>
                <td>
                    <a href="{{ route('citizens.show', $citizen->id) }}">
                        {{ $citizen->name }}
                    </a>
                </td>

                <td>{{ $citizen->created_at }}</td>
                <td>{{ $citizen->updated_at }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{--  <a href="{{ route('citizens.edit', $citizen->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i></a> --}}

                        <form method="POST" action="{{ route('citizens.destroy', $citizen->id) }}" style="display: inline-block;">
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
 