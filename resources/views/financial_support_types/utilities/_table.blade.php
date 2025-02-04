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
            @foreach($financial_support_types as $financial_support_type)
            <tr>
                <th scope="row">#{{ $financial_support_type->id }}</th>
                <td>
                    <a href="{{ route('financial_support_types.show', $financial_support_type->id) }}">
                        {{ $financial_support->name }}
                    </a>
                </td>

                <td>{{ $financial_support_type->created_at }}</td>
                <td>{{ $financial_support_type->updated_at }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{--  <a href="{{ route('financial_support_types.edit', $financial_support_type->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i></a> --}}

                        <form method="POST" action="{{ route('financial_support_types.destroy', $financial_support_type->id) }}" style="display: inline-block;">
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
 