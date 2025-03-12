<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Pertenece a</th>
                <th>Título</th>
                <th>Texto</th>
                <th>Link</th>
                <th>Prioridad</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($headerbands as $headerband)
            <tr>
                <td>{{ $headerband->company->name }}</td>
                <td style="width:250px;">
                    <strong>{{ $headerband->title }}</strong><br>
                </td>
                <td>{!! $headerband->text ?? '' !!}</td>
                <td>{{ $headerband->band_link }}</td>
                <td>{{ $headerband->priority}}</td>

                <td>
                    @if($headerband->is_active == true)
                        <span class="badge bg-success">Activado</span><br>
                    @else
                        <span class="badge bg-warning">Desactivado</span><br>
                    @endif
                </td>
                
                <td class="d-flex">
                    <a href="{{ route('headerbands.edit', $headerband->id) }}" class="btn btn-link text-dark px-1 py-0" data-bs-toggle="tooltip" data-bs-original-title="Editar">
                        <i class='bx bx-edit-alt'></i>
                    </a>

                    <form method="POST" action="{{ route('headerbands.status', $headerband->id) }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-link text-dark px-1 py-0" data-bs-toggle="tooltip" data-bs-original-title="Cambiar estado">
                            Cambiar Estado
                        </button>
                    </form>

                    <form method="POST" action="{{ route('headerbands.destroy', $headerband->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-link text-danger px-1 py-0" data-bs-toggle="tooltip" data-bs-original-title="Eliminar Cintillo">
                            <i class='bx bx-trash-alt text-danger'></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>                    
</div>
 