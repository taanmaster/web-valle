<div>
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Título</label>
            <input type="text" class="form-control" wire:model.live.debounce.300ms="title" placeholder="Buscar por título">
        </div>
        <div class="col-md-4">
            <label class="form-label">Categoría</label>
            <select class="form-select" wire:model.live="blog_category_id">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" wire:model.live="published_date">
        </div>
        <div class="col-md-12 text-end mt-2">
            @if ($published_date != '' || $title != '' || $blog_category_id != '')
                <button wire:click="resetFilters" class="btn btn-secondary">Reiniciar Filtros</button>
            @endif
        </div>
    </div>

    <div class="row">
        @forelse ($entries as $entry)
            <div class="col-md-6 mb-4">
                <div class="card">
                    @if ($entry->hero_img)
                        <img src="{{ $entry->hero_img }}" class="card-img-top"
                            style="height:200px; object-fit:cover;" alt="Portada de {{ $entry->title }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                            style="height:200px;">
                            <i class='bx bx-image-alt text-muted' style="font-size:3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <small class="text-muted">{{ $entry->published_at }}</small>
                            @if ($entry->category)
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $entry->category->name }}</span>
                            @endif
                        </div>
                        <h5 class="card-title mb-2">{{ $entry->title }}</h5>
                        <p class="card-text">{{ $entry->description }}</p>

                        <div class="d-flex mt-3 w-100 justify-content-end align-items-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route($routePrefix . '.admin.edit', $entry->id) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class='bx bx-edit'></i> Editar
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    wire:click="deleteEntry({{ $entry->id }})"
                                    wire:confirm="¿Eliminar esta entrada?">
                                    <i class='bx bx-trash-alt'></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="text-center py-5">
                    <i class="far fa-folder-open fa-4x text-muted"></i>
                    <p class="mt-3 mb-0 text-muted">No hay entradas que coincidan con los filtros.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex align-items-center justify-content-center">
        {{ $entries->links() }}
    </div>
</div>
