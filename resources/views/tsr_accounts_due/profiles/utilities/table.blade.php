<div>
    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>
                Usa los filtros para ubicar una cuenta y entra a <strong>Ver</strong> para generar enteros provisionales.
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Fecha desde:</label>
                    <input type="date" class="form-control" wire:model.live="start_date">
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Fecha hasta:</label>
                    <input type="date" class="form-control" wire:model.live="end_date">
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i> Clave de cuenta:
                    </label>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="code"
                        placeholder="Buscar por clave única">
                </div>
                <div class="col-lg-2">
                    <a href="{{ route('account_due_profiles.index') }}" class="btn btn-outline-secondary w-100" title="Limpiar filtros">
                        <i class="fas fa-times me-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($profiles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Fecha</th>
                                <th class="fw-semibold">Clave</th>
                                <th class="fw-semibold">Nombre/Razón Social</th>
                                <th class="fw-semibold">RFC/CURP</th>
                                <th class="fw-semibold">Correo</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profiles as $profile)
                                <tr>
                                    <td>{{ $profile->created_at->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-primary">{{ $profile->code }}</span></td>
                                    <td>{{ $profile->name }}</td>
                                    <td>{{ $profile->rfc_curp }}</td>
                                    <td>{{ $profile->email }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('account_due_profiles.show', $profile->id) }}"
                                                class="btn btn-outline-primary" title="Ver perfil" aria-label="Ver perfil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('account_due_profiles.edit', $profile->id) }}"
                                                class="btn btn-outline-secondary" title="Editar perfil" aria-label="Editar perfil">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal_{{ $profile->id }}" title="Eliminar perfil" aria-label="Eliminar perfil">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <div class="modal fade" id="deleteModal_{{ $profile->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel_{{ $profile->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="deleteModalLabel_{{ $profile->id }}">Eliminar Perfil</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('account_due_profiles.destroy', $profile->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-body text-start">
                                                            <p class="mb-0">
                                                                <strong>¿Confirmas eliminar este perfil?</strong>
                                                                Esta acción también eliminará los enteros provisionales asociados.
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
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-folder-open fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">No hay perfiles registrados</h5>
                    <p class="text-muted mb-4">Crea un perfil para comenzar el flujo de enteros e ingresos.</p>
                    <a href="{{ route('account_due_profiles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Crear Primer Perfil
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
