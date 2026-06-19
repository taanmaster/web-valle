<div>
@push('stylesheets')
<style>
    .step-card { background: #fff; border: 1px dashed #ccc; border-radius: 10px; }
    .step-number { width: 32px; min-width: 32px; background: #f0f0f0; border-radius: 8px 0 0 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #555; }
    .drag-handle { cursor: grab; background: #f8d7d7; border-radius: 0 8px 8px 0; width: 28px; min-width: 28px; display: flex; align-items: center; justify-content: center; color: #999; }
    .drag-handle:active { cursor: grabbing; }
    .timeline { position: relative; padding-left: 24px; }
    .timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: #ddd; }
    .timeline-item { position: relative; margin-bottom: 16px; }
    .timeline-item::before { content: ''; position: absolute; left: -20px; top: 6px; width: 12px; height: 12px; border-radius: 50%; background: #888; }
    .add-step-btn { background: #e8f4ff; border: none; color: #3d6cb9; font-weight: 600; letter-spacing: 0.05em; width: 100%; padding: 14px; border-radius: 8px; }
    .add-step-btn:hover { background: #d4eaff; }
    .autosave-badge { font-size: 0.78rem; color: #28a745; display: inline-flex; align-items: center; gap: 4px; }
</style>
@endpush

{{-- Toast container --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="autosave-toast" class="toast align-items-center border-0 text-white"
        style="background:#2d8653;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i class="bx bx-check-circle fs-5"></i>
                <span id="autosave-toast-msg">Guardado</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<div class="row layout-spacing">
    <div class="main-content">

        {{-- Title + autosave indicator --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <h4 class="fw-bold text-uppercase mb-0">
                @if ($mode === 0) CREACIÓN DE GUÍA NUEVA
                @elseif ($mode === 1) VER GUÍA
                @else EDITAR GUÍA
                @endif
            </h4>
            @if ($mode === 2)
                <span class="autosave-badge">
                    <i class="bx bx-cloud-upload"></i> Guardado automático activo
                </span>
            @endif
        </div>

        <form wire:submit.prevent="save" enctype="multipart/form-data">
            @csrf

            {{-- ─── DATOS DE LA GUÍA ──────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-body">

                    {{-- Fecha de entrada --}}
                    <div class="row justify-content-end mb-3">
                        <div class="col-auto d-flex align-items-center gap-3">
                            <label class="mb-0">Fecha de entrada</label>
                            <input type="date" class="form-control" style="width:180px;"
                                wire:model.blur="fecha_entrada"
                                @if($mode===1) disabled @endif>
                        </div>
                    </div>

                    {{-- Título --}}
                    <div class="row align-items-center mb-3">
                        <div class="col-md-2"><label class="col-form-label">Título</label></div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    wire:model.blur="titulo"
                                    @if($mode===1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('titulo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="row align-items-center mb-3">
                        <div class="col-md-2"><label class="col-form-label">Descripción</label></div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control"
                                    wire:model.blur="descripcion"
                                    @if($mode===1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                        </div>
                    </div>

                    {{-- Imagen de portada --}}
                    <div class="row align-items-start mb-3">
                        <div class="col-md-2"><label class="col-form-label">Imagen de portada</label></div>
                        <div class="col-md-10">
                            @if ($mode === 1 && $guia?->imagen_portada)
                                <img src="{{ \Storage::disk('s3')->url($guia->imagen_portada) }}"
                                    class="img-fluid rounded" style="max-height:200px;" alt="Portada">
                            @elseif ($mode !== 1)
                                <label class="d-flex align-items-center justify-content-center gap-3 border rounded-3 p-4 bg-light"
                                    style="cursor:pointer; min-height:80px;">
                                    <i class="bx bx-image-add fs-3 text-muted"></i>
                                    <span class="text-muted">Arrastra o carga imagen</span>
                                    <input type="file" class="d-none" wire:model.live="imagen_portada" accept="image/*">
                                </label>
                                @if ($imagen_portada && !is_string($imagen_portada))
                                    <img src="{{ $imagen_portada->temporaryUrl() }}" class="img-fluid rounded mt-2" style="max-height:150px;">
                                @elseif ($guia?->imagen_portada)
                                    <small class="text-muted d-block mt-1">Imagen actual guardada.</small>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Categoría + Dependencia --}}
                    <div class="row align-items-center mb-3">
                        <div class="col-md-2"><label class="col-form-label">Categorías</label></div>
                        <div class="col-md-4">
                            <livewire:ayuda.category-selector
                                :selectedId="$guia_categoria_id"
                                :mode="$mode"
                                :key="'cat-selector-'.($guia?->id ?? 'new')" />
                        </div>
                        <div class="col-md-2"><label class="col-form-label">Dependencia</label></div>
                        <div class="col-md-4">
                            <select class="form-select" wire:model.blur="dependencia"
                                @if($mode===1) disabled @endif>
                                <option value="">Seleccionar...</option>
                                @foreach ($dependencias as $dep)
                                    <option value="{{ $dep->name }}">{{ $dep->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Audiencia + Destacada --}}
                    <div class="row align-items-center">
                        <div class="col-md-2"><label class="col-form-label fw-semibold">Selector de Audiencia</label></div>
                        <div class="col-md-10 d-flex flex-wrap gap-4 align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="mostrar_front"
                                    wire:model.blur="mostrar_front"
                                    @if($mode===1) disabled @endif>
                                <label class="form-check-label" for="mostrar_front">Mostrar en Portal Ciudadano</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="mostrar_admin"
                                    wire:model.blur="mostrar_admin"
                                    @if($mode===1) disabled @endif>
                                <label class="form-check-label" for="mostrar_admin">Mostrar en Intranet del municipio</label>
                            </div>
                            <div class="form-check ms-md-4">
                                <input class="form-check-input" type="checkbox" id="destacada"
                                    wire:model.blur="destacada"
                                    @if($mode===1) disabled @endif>
                                <label class="form-check-label" for="destacada">Guía destacada</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ─── CONSTRUCTOR DE PASOS ───────────────────────────── --}}
            <h5 class="fw-bold text-uppercase mb-3">Constructor de Pasos</h5>

            @if ($mode !== 1)
                <button type="button" wire:click="addStep" class="add-step-btn mb-3">AGREGAR PASO</button>
            @endif

            <div id="steps-sortable">
                @foreach ($steps as $index => $step)
                    <div class="d-flex mb-3 step-item" data-tempkey="{{ $step['tempKey'] }}">

                        <div class="step-number me-2">{{ $index + 1 }}</div>

                        <div class="step-card flex-grow-1 p-3">

                            {{-- Título del paso --}}
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3"><label class="col-form-label">Título del paso</label></div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('steps.'.$index.'.titulo') is-invalid @enderror"
                                            wire:model.blur="steps.{{ $index }}.titulo"
                                            @if($mode===1) disabled @endif>
                                        <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                    </div>
                                    @error('steps.'.$index.'.titulo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Descripción --}}
                            <div class="row align-items-start mb-3">
                                <div class="col-md-3"><label class="col-form-label">Descripción explicativa</label></div>
                                <div class="col-md-9">
                                    <textarea class="form-control" rows="3"
                                        wire:model.blur="steps.{{ $index }}.descripcion"
                                        @if($mode===1) disabled @endif></textarea>
                                </div>
                            </div>

                            {{-- Imagen de apoyo --}}
                            <div class="row align-items-start mb-3">
                                <div class="col-md-3"><label class="col-form-label">Imagen de apoyo</label></div>
                                <div class="col-md-9">
                                    @if ($mode === 1 && $step['imagen_apoyo_path'])
                                        <img src="{{ \Storage::disk('s3')->url($step['imagen_apoyo_path']) }}"
                                            class="img-fluid rounded" style="max-height:150px;" alt="">
                                    @elseif ($mode !== 1)
                                        <label class="d-flex align-items-center justify-content-center gap-3 border rounded-3 p-3 bg-light"
                                            style="cursor:pointer;">
                                            <i class="bx bx-image-add text-muted fs-4"></i>
                                            <span class="text-muted small">Arrastra o carga imágenes</span>
                                            <input type="file" class="d-none"
                                                wire:model.live="stepImages.{{ $step['tempKey'] }}" accept="image/*">
                                        </label>
                                        @if ($step['imagen_apoyo_path'])
                                            <small class="text-muted">Imagen guardada.</small>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <p class="fw-bold mb-2">Opcionales</p>

                            {{-- Enlace --}}
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3 small">Enlace al trámite o servicio</div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Ingresa texto"
                                        wire:model.blur="steps.{{ $index }}.enlace_texto"
                                        @if($mode===1) disabled @endif>
                                </div>
                                <div class="col-md-5">
                                    <input type="url" class="form-control form-control-sm @error('steps.'.$index.'.enlace_url') is-invalid @enderror"
                                        placeholder="Ingresa URL"
                                        wire:model.blur="steps.{{ $index }}.enlace_url"
                                        @if($mode===1) disabled @endif>
                                    @error('steps.'.$index.'.enlace_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pregunta frecuente --}}
                            <div class="row align-items-start mb-3">
                                <div class="col-md-3 small">Pregunta frecuente o recomendación</div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea class="form-control form-control-sm" rows="2"
                                            wire:model.blur="steps.{{ $index }}.pregunta_frecuente"
                                            @if($mode===1) disabled @endif></textarea>
                                        <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Advertencia --}}
                            <div class="row align-items-start mb-3">
                                <div class="col-md-3 small">Mensaje de advertencia</div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea class="form-control form-control-sm" rows="2"
                                            wire:model.blur="steps.{{ $index }}.mensaje_advertencia"
                                            @if($mode===1) disabled @endif></textarea>
                                        <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Archivo adjunto --}}
                            <div class="row align-items-center mb-1">
                                <div class="col-md-3 small">Archivo adjunto</div>
                                <div class="col-md-9">
                                    @if ($mode === 1 && $step['archivo_adjunto_path'])
                                        <a href="{{ \Storage::disk('s3')->url($step['archivo_adjunto_path']) }}"
                                            target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bx bx-file"></i> Ver archivo
                                        </a>
                                    @elseif ($mode !== 1)
                                        <label class="d-flex align-items-center justify-content-center border rounded-3 p-3 bg-light"
                                            style="cursor:pointer;">
                                            <span class="text-muted small">Arrastra o carga de archivos</span>
                                            <input type="file" class="d-none"
                                                wire:model.live="stepFiles.{{ $step['tempKey'] }}">
                                        </label>
                                        @if ($step['archivo_adjunto_path'])
                                            <small class="text-muted">Archivo guardado.</small>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>

                        {{-- Drag handle + delete --}}
                        @if ($mode !== 1)
                            <div class="d-flex flex-column ms-2 gap-2">
                                <div class="drag-handle flex-grow-1" title="Arrastrar para reordenar">
                                    <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                </div>
                                <button type="button" wire:click="removeStep({{ $index }})"
                                    class="btn btn-sm btn-outline-danger" title="Eliminar paso">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            @if ($mode !== 1 && count($steps) > 0)
                <button type="button" wire:click="addStep" class="add-step-btn mb-4">AGREGAR PASO</button>
            @endif

            {{-- ─── CRONOLOGÍA ─────────────────────────────────────── --}}
            @if ($guia !== null && $cambios->count() > 0)
                <h5 class="fw-bold mt-5 mb-3">Cronología</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="timeline">
                            @foreach ($cambios as $cambio)
                                <div class="timeline-item">
                                    <p class="mb-0 small fw-semibold">{{ $cambio->descripcion }}</p>

                                    @if (!empty($cambio->detalle['de']) || !empty($cambio->detalle['a']))
                                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                            <span class="badge bg-light text-secondary border"
                                                style="max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
                                                title="{{ $cambio->detalle['de'] }}">
                                                {{ \Str::limit($cambio->detalle['de'] ?? '', 60) }}
                                            </span>
                                            <i class="bx bx-right-arrow-alt text-muted"></i>
                                            <span class="badge bg-light text-dark border fw-semibold"
                                                style="max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
                                                title="{{ $cambio->detalle['a'] }}">
                                                {{ \Str::limit($cambio->detalle['a'] ?? '', 60) }}
                                            </span>
                                        </div>
                                    @endif

                                    <small class="text-muted d-block mt-1">
                                        {{ $cambio->user?->name ?? 'Sistema' }}
                                        · {{ $cambio->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ─── ACCIONES ────────────────────────────────────────── --}}
            <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                <a href="{{ route('ayuda.admin.index') }}" class="btn btn-secondary px-4">
                    {{ $mode === 1 ? 'Volver' : 'Cancelar' }}
                </a>

                @if ($mode === 0)
                    <button type="submit" class="btn btn-primary px-5 fw-semibold">
                        Guardar Guía
                    </button>
                @elseif ($mode === 2)
                    <span class="autosave-badge fs-6">
                        <i class="bx bx-check-double"></i> Los cambios se guardan automáticamente
                    </span>
                @elseif ($mode === 1)
                    <a href="{{ route('ayuda.admin.edit', $guia->id) }}" class="btn btn-primary">
                        <i class="bx bx-edit"></i> Editar guía
                    </a>
                @endif
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"
    integrity="sha384-BSxuMLxX+FCbTdYec3TbXlnMGEEM2QXTFdtDaveen71o+jswm2J36+xFqp8k4VHM"
    crossorigin="anonymous"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        initSortable();

        // Re-init after Livewire re-renders
        Livewire.hook('morph.updated', () => initSortable());

        // Toast listener
        Livewire.on('toast', ({ message }) => {
            const toastEl = document.getElementById('autosave-toast');
            if (!toastEl) return;
            document.getElementById('autosave-toast-msg').textContent = message;
            // Re-instantiate each time to restart delay
            const instance = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 2500 });
            instance.show();
        });
    });

    function initSortable() {
        const el = document.getElementById('steps-sortable');
        if (!el || el._sortableInit) return;
        el._sortableInit = true;

        new Sortable(el, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function () {
                el._sortableInit = false; // allow re-init after Livewire morph
                const order = [...el.querySelectorAll('.step-item')].map(n => n.dataset.tempkey);
                Livewire.dispatch('reorderSteps', { order });
            }
        });
    }
</script>
@endpush

</div>{{-- single root --}}
