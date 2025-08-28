<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>CURP</th>
                <th>Información</th>
                <th>Dirección</th>
                <th># de Apoyos</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($citizens as $citizen)
                <tr>
                    <th scope="row">#{{ $citizen->id }}</th>
                    <td>{{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }}</td>
                    <td>{{ $citizen->curp }}</td>

                    <td class="text-muted">
                        {{ $citizen->phone ?? 'Sin Registro' }} <br>
                        {{ $citizen->email ?? 'Sin Registro' }} 
                    </td>

                    <td class="text-muted">
                        {{ $citizen->address }} {{ $citizen->street }} <br>
                        {{ $citizen->colony }}
                    </td>

                    <td>{{ $citizen->supports->count() ?? 0 }}</td>

                    <td>
                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('citizens.show', $citizen->id) }}" class="btn btn-sm btn-primary">Ver</a>
                            <a href="{{ route('citizens.edit', $citizen->id) }}"
                                class="btn btn-sm btn-secondary">Editar</a>

                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $citizen->id }}">
                                Eliminar
                            </button>


                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{ $citizen->id }}" tabindex="-1"
                                aria-labelledby="deleteModal{{ $citizen->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="deleteModal{{ $citizen->id }}Label">
                                                Eliminar particular</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('citizens.destroy', $citizen->id) }}"
                                            style="display: inline-block;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="modal-body">
                                                <h1 class="text-danger">¡Alerta!</h1>
                                                <p>
                                                    Estas por eliminar a {{ $citizen->name }}
                                                    {{ $citizen->first_name }} {{ $citizen->last_name }},
                                                    esta acción no se puede deshacer. <br>
                                                    <strong>¿Estás seguro de que deseas continuar?</strong>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Eliminar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
