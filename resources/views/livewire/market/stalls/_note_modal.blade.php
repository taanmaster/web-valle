{{-- Modal "Registrar gestión de cobro". Requiere $stall y las propiedades noteDate / noteComment del componente --}}
<div class="modal d-block" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" wire:submit="saveNote">
            <div class="modal-header mk-section-header">
                <div>
                    <h6 class="mb-0 text-white">Registrar gestión de cobro</h6>
                    <small class="text-white-50 text-capitalize-none">{{ $stall->number }} · {{ $stall->tenant_name }} · {{ $stall->space_label }}</small>
                </div>
            </div>
            <div class="modal-body">
                <label class="form-label">Fecha *</label>
                <input type="date" wire:model="noteDate" class="form-control mb-2" max="{{ now()->toDateString() }}">
                @error('noteDate')<small class="text-danger d-block">{{ $message }}</small>@enderror
                <label class="form-label">Comentario *</label>
                <textarea wire:model="noteComment" rows="3" class="form-control" placeholder="Qué se habló, compromisos y fechas..."></textarea>
                @error('noteComment')<small class="text-danger d-block">{{ $message }}</small>@enderror
                <small class="text-muted">La gestión se guarda en la bitácora del detalle del padrón.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('noteStallId', null)">Cancelar</button>
                <button type="submit" class="btn mk-btn btn-sm">Guardar gestión</button>
            </div>
        </form>
    </div>
</div>
<div class="modal-backdrop show"></div>
