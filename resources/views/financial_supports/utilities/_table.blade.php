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
            @foreach($financial_supports as $financial_support)
            <tr>
                <th scope="row">#{{ $financial_support->id }}</th>
                <td>
                    <a href="{{ route('financial_supports.show', $financial_support->id) }}">
                        {{ $financial_support->name }}
                    </a>
                </td>

                <td>{{ $financial_support->created_at }}</td>
                <td>{{ $financial_support->updated_at }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{--  <a href="{{ route('financial_supports.edit', $financial_support->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i></a> --}}

                        <form method="POST" action="{{ route('financial_supports.destroy', $financial_support->id) }}" style="display: inline-block;">
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
 