<div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header + CREAR --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0" style="font-weight:700; text-transform:uppercase; letter-spacing:1px;">
            Descargables
        </h4>
        <button class="btn btn-primary fw-semibold px-4" wire:click="openCreate"
            style="width:fit-content; max-width:fit-content">
            CREAR
        </button>
    </div>

    {{-- Tabla --}}
    <div class="card" style="border-radius:12px;">
        <div class="card-body p-0">
            <table class="table table-borderless align-middle mb-0">
                <thead>
                    <tr style="border-bottom:1.5px solid #e5e5e5;">
                        <th class="ps-4 py-3 text-uppercase"
                            style="font-size:.8rem; color:#888; font-weight:600;">Título</th>
                        <th class="py-3 text-uppercase text-center"
                            style="font-size:.8rem; color:#888; font-weight:600;">Documento</th>
                        <th class="pe-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td class="ps-4 py-3">{{ $item->title }}</td>
                            <td class="py-3 text-center">
                                @if ($item->document_url)
                                    <a href="{{ $item->document_url }}" target="_blank"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="ti ti-file-text me-1"></i> Ver PDF
                                    </a>
                                @else
                                    <span class="text-muted small">Sin documento</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-end" style="white-space:nowrap;">
                                <button class="btn btn-link p-0 me-2" wire:click="openEdit({{ $item->id }})"
                                    title="Editar">
                                    <i class="ti ti-pencil" style="font-size:1.3rem; color:#555;"></i>
                                </button>
                                <button class="btn btn-link p-0 text-danger" title="Eliminar"
                                    onclick="confirm('¿Eliminar este registro?') || event.stopImmediatePropagation()"
                                    wire:click="delete({{ $item->id }})">
                                    <i class="ti ti-trash" style="font-size:1.2rem;"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    @if ($showModal)
        <div class="modal-backdrop fade show" style="z-index:1040;"></div>
        <div class="modal fade show d-block" tabindex="-1" style="z-index:1050;">
            <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
                <div class="modal-content" style="border-radius:12px; border:none;">
                    <div class="modal-body p-4">

                        <h5 class="mb-4 text-uppercase fw-bold" style="letter-spacing:1px;">
                            {{ $itemId ? 'Editar Descargable' : 'Nuevo Descargable' }}
                        </h5>

                        <form wire:submit.prevent="save">

                            <div class="mb-3 row align-items-center">
                                <label class="col-md-4 col-form-label text-uppercase fw-semibold"
                                    style="font-size:.85rem; letter-spacing:.5px;">Título</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" wire:model="title"
                                        placeholder="Título del documento">
                                    @error('title')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-4 col-form-label text-uppercase fw-semibold"
                                    style="font-size:.85rem; letter-spacing:.5px;">
                                    Documento PDF
                                    @if ($itemId)
                                        <span class="d-block text-muted fw-normal" style="font-size:.75rem;">
                                            (opcional al editar)
                                        </span>
                                    @endif
                                </label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control" wire:model="document" accept=".pdf">
                                    @error('document')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                    <div wire:loading wire:target="document" class="mt-1">
                                        <small class="text-muted">Subiendo archivo...</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary"
                                    wire:click="closeModal">Cancelar</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-5"
                                    wire:loading.attr="disabled" wire:target="save">
                                    <span wire:loading.remove wire:target="save">Guardar</span>
                                    <span wire:loading wire:target="save">Guardando...</span>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
