<div>
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ $editingId ? 'Editar categoría' : 'Nueva categoría' }}</h6>
                </div>
                <div class="card-body">
                    <form wire:submit="save">
                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" wire:model="is_active" id="categoryIsActive">
                            <label class="form-check-label" for="categoryIsActive">Activa</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            @if ($editingId)
                                <button type="button" class="btn btn-secondary" wire:click="resetForm">Cancelar</button>
                            @endif
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Nombre</th>
                            <th class="fw-semibold">Entradas</th>
                            <th class="fw-semibold">Estatus</th>
                            <th class="fw-semibold text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->blogs_count }}</td>
                                <td>
                                    <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                        {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="edit({{ $category->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $category->id }})"
                                        wire:confirm="¿Eliminar esta categoría? Las entradas que la usan quedarán sin categoría.">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center py-4">
                                        <i class="far fa-folder-open fa-4x text-muted"></i>
                                        <p class="mt-3 mb-0 text-muted">Aún no hay categorías.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
