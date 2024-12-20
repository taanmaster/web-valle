<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>id</th>
                <th>name</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($gazettes as $gazette)
            <tr>
                <td>{{ $gazette->id }}</td>
                <td>{{ $gazette->name }}</td>
          
                <td>                                                                                                   
                    <a href="{{ route('gazettes.show', $gazette->id) }}" class="btn btn-sm btn-icon mr-2" data-bs-toggle="tooltip" data-bs-original-title="Ver"><i class='bx bx-show-alt'></i></a>

                    <a href="{{ route('gazettes.show', $gazette->id) }}" class="btn btn-sm btn-icon mr-2" data-bs-toggle="tooltip" data-bs-original-title="Editar"><i class='bx bx-edit-alt'></i></a>

                    <form method="POST" action="{{ route('gazettes.destroy', $gazette->id) }}" style="display: inline-block;">
                        <button type="submit" class="btn btn-sm btn-icon" data-bs-toggle="tooltip" data-bs-original-title="Borrar">
                            <i class='bx bx-trash-alt text-danger'></i>
                        </button>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </td>
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
 