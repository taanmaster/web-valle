<div>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
        <h4 class="fw-bold text-uppercase mb-0">Conoce tus Beneficios</h4>
        <div class="d-flex gap-2">
            <button wire:click="toggleFilters" class="btn btn-secondary fw-semibold px-4">Filtros</button>
            <a href="{{ route('benefits.admin.create') }}" class="btn btn-primary fw-semibold px-4">Nueva
                Entrada</a>
        </div>
    </div>

    {{-- Alertas flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bx bx-check-circle fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filtros --}}
    @if ($show_filters)
        <div class="row g-3 mb-4 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Fecha</label>
                <input type="date" class="form-control rounded-pill" wire:model.live="filter_fecha">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Título</label>
                <input type="text" class="form-control rounded-pill" placeholder="Buscar por título"
                    wire:model.live.debounce.300ms="filter_titulo">
            </div>
            @if ($filter_fecha || $filter_titulo)
                <div class="col-md-3">
                    <button wire:click="resetFilters" class="btn btn-link text-danger p-0 mt-3">Limpiar filtros</button>
                </div>
            @endif
        </div>
    @endif

    {{-- Grid de entradas --}}
    <div class="row g-4">
        @forelse ($entries as $entry)
            <div class="col-md-6" wire:key="entry-{{ $entry->id }}">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                    {{-- Cover --}}
                    <div style="height: 200px; background: #d9d9d9; overflow: hidden;">
                        @if ($entry->hero_img)
                            <img src="{{ $entry->hero_img }}" class="w-100 h-100" style="object-fit: cover;"
                                alt="{{ $entry->title }}">
                        @endif
                    </div>

                    <div class="card-body">
                        <small class="text-muted">
                            {{ $entry->published_at ? $entry->published_at->translatedFormat('M d, Y') : $entry->created_at->translatedFormat('M d, Y') }}
                        </small>
                        <h5 class="fw-bold mt-1 mb-1">{{ $entry->title }}</h5>
                        <p class="text-muted small mb-3"
                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $entry->description }}
                        </p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('benefits.admin.show', $entry->id) }}"
                                class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="bx bx-show"></i> Ver
                            </a>
                            <a href="{{ route('benefits.admin.edit', $entry->id) }}"
                                class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bx bx-edit"></i> Editar
                            </a>
                            <button wire:click="delete({{ $entry->id }})"
                                wire:confirm="¿Eliminar este beneficio? Esta acción no se puede deshacer."
                                class="btn btn-sm btn-outline-danger" title="Eliminar" aria-label="Eliminar">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No hay beneficios registrados.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $entries->links() }}</div>
</div>
