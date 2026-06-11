<div>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-3">
        <h4 class="fw-bold text-uppercase mb-0">Módulo de Ayuda para Ciudadanos y Servidores Públicos</h4>
        <div class="d-flex gap-2">
            <button wire:click="toggleFilters" class="btn btn-secondary fw-semibold px-4">Filtros</button>
            <a href="{{ route('ayuda.admin.create') }}" class="btn btn-primary fw-semibold px-4">Nueva Guía</a>
        </div>
    </div>

    {{-- Filtros --}}
    @if ($show_filters)
        <div class="row g-3 mb-4 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Fecha</label>
                <input type="date" class="form-control rounded-pill" wire:model.live="filter_fecha">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Categoría</label>
                <select class="form-select rounded-pill" wire:model.live="filter_categoria">
                    <option value="">Todos</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Dependencia</label>
                <input type="text" class="form-control rounded-pill" placeholder="Título" wire:model.live="filter_dependencia">
            </div>
            @if ($filter_fecha || $filter_categoria || $filter_dependencia)
                <div class="col-md-3">
                    <button wire:click="resetFilters" class="btn btn-link text-danger p-0 mt-3">Limpiar filtros</button>
                </div>
            @endif
        </div>
    @endif

    {{-- Grid de guías --}}
    <div class="row g-4">
        @forelse ($guias as $guia)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                    {{-- Cover --}}
                    <div style="height: 200px; background: #d9d9d9; overflow: hidden;">
                        @if ($guia->imagen_portada)
                            <img src="{{ \Storage::disk('s3')->url($guia->imagen_portada) }}"
                                class="w-100 h-100" style="object-fit: cover;" alt="{{ $guia->titulo }}">
                        @endif
                    </div>

                    <div class="card-body">
                        <small class="text-muted">
                            {{ $guia->fecha_entrada ? $guia->fecha_entrada->translatedFormat('M d, Y') : $guia->created_at->translatedFormat('M d, Y') }}
                        </small>
                        <h5 class="fw-bold mt-1 mb-1">{{ $guia->titulo }}</h5>
                        <p class="text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $guia->descripcion }}
                        </p>

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle bg-secondary" style="width:28px;height:28px;flex-shrink:0;"></div>
                            <small class="text-muted">{{ $guia->categoria?->nombre ?? '—' }}</small>
                            @if ($guia->destacada)
                                <span class="badge bg-warning text-dark ms-auto">Destacada</span>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('ayuda.admin.show', $guia->id) }}" class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="bx bx-show"></i> Ver
                            </a>
                            <a href="{{ route('ayuda.admin.edit', $guia->id) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bx bx-edit"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('ayuda.admin.destroy', $guia->id) }}"
                                onsubmit="return confirm('¿Eliminar esta guía?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No hay guías registradas.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $guias->links() }}</div>
</div>
