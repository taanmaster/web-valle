<div>
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="">Fecha de creación</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>

        <div class="col-md-4">
            <label for="">Clave única de la cuenta</label>
            <input type="text" class="form-control" wire:model.live="code">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Clave</th>
                    <th>Nombre/Razón Social</th>
                    <th>RFC/CURP</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profiles as $profile)
                    <tr>
                        <td>{{ $profile->created_at->format('d/m/Y') }}</td>
                        <td>{{ $profile->code }}</td>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->rfc_curp }}</td>
                        <td>{{ $profile->email }}</td>
                        <td>
                            <a href="{{ route('account_due_profiles.show', $profile->id) }}" class="btn btn-primary btn-sm">Ver</a>
                            <a href="{{ route('account_due_profiles.edit', $profile->id) }}" class="btn btn-secondary btn-sm">Editar</a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $profile->id }}">
                                Eliminar
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal_{{ $profile->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="deleteModalLabel">Eliminar Perfil</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('account_due_profiles.destroy', $profile->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                        <p> <strong>¿Estás seguro de que deseas eliminar este perfil?.</strong>
                                            <br>
                                            Al confirmar, se eliminarán todos los enteros provisionales asociados a este perfil permanentemente.
                                        </p>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
