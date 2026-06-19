<div class="position-relative" style="max-width: 320px;">

    {{-- Trigger --}}
    <div wire:click="toggle"
        class="d-flex align-items-center gap-2 px-3 py-2 border rounded-3 bg-white"
        style="cursor: {{ $mode === 1 ? 'default' : 'pointer' }}; min-height: 40px;">
        @if ($selected)
            <span class="badge rounded-pill" style="background:#e8eaff; color:#3d4eac; font-weight:500;">
                {{ $selected->nombre }}
            </span>
            @if ($mode !== 1)
                <button type="button" wire:click.stop="deselect" class="btn-close ms-auto" style="font-size:0.6rem;"></button>
            @endif
        @else
            <span class="text-muted small">{{ $mode === 1 ? 'Sin categoría' : 'Seleccionar categoría...' }}</span>
            @if ($mode !== 1)
                <i class="bx bx-chevron-down ms-auto text-muted"></i>
            @endif
        @endif
    </div>

    {{-- Dropdown --}}
    @if ($isOpen && $mode !== 1)
        <div class="position-absolute bg-white border rounded-3 shadow-lg mt-1 w-100"
            style="z-index: 1050; min-width: 260px; max-height: 320px; overflow-y: auto;">

            {{-- Search --}}
            <div class="p-2 border-bottom">
                <input type="text"
                    class="form-control form-control-sm border-0 bg-light"
                    placeholder="Buscar categoría..."
                    wire:model.live="search"
                    wire:keydown.escape="close"
                    autofocus>
            </div>

            {{-- List --}}
            <ul class="list-unstyled mb-0 py-1">
                @forelse ($categories as $cat)
                    <li class="d-flex align-items-center px-3 py-2 gap-2 rounded"
                        style="cursor:pointer; transition:background .15s;"
                        onmouseenter="this.style.background='#f0f4ff'"
                        onmouseleave="this.style.background='transparent'">
                        <span wire:click="select({{ $cat->id }})" class="flex-grow-1 small fw-medium">
                            {{ $cat->nombre }}
                        </span>
                        <button type="button"
                            wire:click.stop="deleteCategory({{ $cat->id }})"
                            class="btn btn-sm p-0 lh-1"
                            style="color: {{ $cat->guias_count > 0 ? '#ccc' : '#e74c3c' }}; cursor: {{ $cat->guias_count > 0 ? 'not-allowed' : 'pointer' }};"
                            title="{{ $cat->guias_count > 0 ? 'Tiene '.$cat->guias_count.' guía(s) — no se puede eliminar' : 'Eliminar categoría' }}">
                            <i class="bx bx-x fs-5"></i>
                        </button>
                    </li>
                @empty
                    @if ($search)
                        <li class="px-3 py-2">
                            <button type="button" wire:click="createCategory"
                                class="btn btn-sm btn-light w-100 text-start">
                                <i class="bx bx-plus"></i> Crear "{{ $search }}"
                            </button>
                        </li>
                    @else
                        <li class="px-3 py-2 text-muted small">No hay categorías. Escribe para crear una.</li>
                    @endif
                @endforelse
            </ul>

            {{-- Close --}}
            <div class="border-top p-2 text-end">
                <button type="button" wire:click="close" class="btn btn-sm btn-link text-muted p-0">Cerrar</button>
            </div>
        </div>
    @endif
</div>
