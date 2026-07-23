{{-- Grupo de checkboxes estilo píldora (selección múltiple). Requiere: $field, $options, $mode --}}
<div class="d-flex flex-wrap gap-2">
    @foreach ($options as $option)
        @php $optionId = $field.'_'.\Illuminate\Support\Str::slug($option, '_'); @endphp
        <input type="checkbox" class="btn-check" id="{{ $optionId }}" value="{{ $option }}"
            wire:model.live="{{ $field }}" @disabled($mode == 1)>
        <label class="btn btn-outline-primary btn-sm rounded-pill px-3" for="{{ $optionId }}">{{ $option }}</label>
    @endforeach
</div>
