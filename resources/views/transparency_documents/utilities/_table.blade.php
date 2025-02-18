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
            @foreach($transparency_documents as $transparency_document)
            <tr>
                <th scope="row">#{{ $transparency_document->id }}</th>
                <td>
                    <a href="{{ route('transparency_documents.show', $transparency_document->id) }}">
                        {{ $transparency_document->name }}
                    </a>
                </td>

                <td>{{ $transparency_document->created_at }}</td>
                <td>{{ $transparency_document->updated_at }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('transparency_documents.show', $transparency_document->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i> Ver Detalle</a>

                        <form method="POST" action="{{ route('transparency_documents.destroy', $transparency_document->id) }}" style="display: inline-block;">
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
 