{{-- Grupo de radios Sí / No estilo píldora. Requiere: $field, $mode --}}
<div class="d-flex flex-wrap gap-2">
    <input type="radio" class="btn-check" id="{{ $field }}_yes" value="1" wire:model.live="{{ $field }}"
        @disabled($mode == 1)>
    <label class="btn btn-outline-primary btn-sm rounded-pill px-3" for="{{ $field }}_yes">Sí</label>

    <input type="radio" class="btn-check" id="{{ $field }}_no" value="0" wire:model.live="{{ $field }}"
        @disabled($mode == 1)>
    <label class="btn btn-outline-primary btn-sm rounded-pill px-3" for="{{ $field }}_no">No</label>
</div>
