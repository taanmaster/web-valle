<div>
    <form wire:submit="save">
        {{-- Encabezado --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <p class="pc-eyebrow mb-1">1 · Trámites · {{ $procedure ? 'Editor' : 'Nuevo trámite' }}</p>
                <h4 class="mb-0">{{ $name ?: ($procedure->name ?? 'Trámite sin nombre') }}</h4>
                @if ($dirty || ! $procedure)
                    <small class="text-warning">Cambios sin guardar</small>
                @else
                    <small class="text-muted"><i class="ti ti-check"></i> Sin cambios pendientes</small>
                @endif
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('proteccion_civil.procedures.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left"></i> Catálogo
                </a>
                <button type="submit" class="btn pc-btn btn-sm text-uppercase">
                    <span wire:loading.remove wire:target="save">Guardar</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Datos generales --}}
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Datos generales del trámite</h6>

                <label class="pc-label">Nombre del trámite * · aparece en la tarjeta del front</label>
                <input type="text" wire:model.live.debounce.300ms="name" class="form-control mb-3">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="pc-label d-block">Tipo *</label>
                        @foreach (\App\Models\CivilProtectionProcedure::TYPES as $key => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model.live="type" value="{{ $key }}" id="type-{{ $key }}">
                                <label class="form-check-label" for="type-{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.live="is_published" id="is_published">
                            <label class="form-check-label" for="is_published">Publicar en el front informativo</label>
                        </div>
                    </div>
                </div>

                <label class="pc-label">Descripción breve * · se muestra al ciudadano en su perfil</label>
                <textarea wire:model.live.debounce.300ms="description" rows="2" class="form-control mb-3"></textarea>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="pc-label">Prefijo de folio *</label>
                        <input type="text" wire:model.live.debounce.300ms="folio_prefix" maxlength="5"
                            class="form-control font-monospace text-uppercase" placeholder="Ej. TCM" @disabled($this->prefixLocked)>
                        <small class="text-muted">
                            @if ($this->prefixLocked)
                                No se puede cambiar: ya hay expedientes con este prefijo.
                            @else
                                De 2 a 5 letras. Ej. {{ $folio_prefix ?: 'TCM' }}-136-{{ now()->year }}
                            @endif
                        </small>
                    </div>
                    <div class="col-md-4">
                        <label class="pc-label">Vigencia (días) *</label>
                        <input type="number" min="1" wire:model.live.debounce.300ms="validity_days" class="form-control">
                        <small class="text-muted">Si se emite hoy, caduca el {{ $expiresOn }}.</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Requisitos documentales --}}
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold mb-0">Requisitos documentales</h6>
                    <button type="button" wire:click="addRequirement" class="btn btn-outline-secondary btn-sm">
                        <i class="ti ti-plus"></i> Agregar requisito
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="pc-thead">
                            <tr>
                                <th>Orden</th>
                                <th>Documento</th>
                                <th>Instrucción para el ciudadano</th>
                                <th class="text-center">Oblig.</th>
                                <th>Formatos</th>
                                <th class="text-center">Original físico</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requirements as $i => $req)
                                <tr wire:key="req-{{ $i }}" @class(['table-light' => $req['is_fixed']])>
                                    <td class="text-nowrap">
                                        <span class="fw-semibold me-1">{{ $i + 1 }}</span>
                                        <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1" wire:click="move({{ $i }}, -1)"
                                            @disabled($req['is_fixed'] || $i <= 1)><i class="ti ti-arrow-up"></i></button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1" wire:click="move({{ $i }}, 1)"
                                            @disabled($req['is_fixed'] || $i === count($requirements) - 1)><i class="ti ti-arrow-down"></i></button>
                                    </td>
                                    @if ($req['is_fixed'])
                                        <td>
                                            <span class="fw-semibold"><i class="ti ti-lock"></i> {{ $req['name'] }}</span>
                                            <small class="d-block text-muted">Precargado en todos los trámites</small>
                                        </td>
                                        <td><small>{{ $req['instructions'] }}</small></td>
                                    @else
                                        <td><input type="text" wire:model.live.debounce.300ms="requirements.{{ $i }}.name" class="form-control form-control-sm" placeholder="Ej. Identificación oficial"></td>
                                        <td><input type="text" wire:model.live.debounce.300ms="requirements.{{ $i }}.instructions" class="form-control form-control-sm" placeholder="Qué debe subir y cómo"></td>
                                    @endif
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input" wire:model.live="requirements.{{ $i }}.is_required" @disabled($req['is_fixed'])>
                                    </td>
                                    <td class="text-nowrap">
                                        @foreach (['pdf', 'jpg', 'png'] as $format)
                                            <button type="button" wire:click="toggleFormat({{ $i }}, '{{ $format }}')" @disabled($req['is_fixed'])
                                                @class(['btn btn-sm rounded-pill py-0 px-2 text-uppercase', 'btn-dark' => in_array($format, $req['formats']), 'btn-outline-secondary' => ! in_array($format, $req['formats'])])>
                                                {{ $format }}
                                            </button>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input" wire:model.live="requirements.{{ $i }}.requires_original" @disabled($req['is_fixed'])>
                                    </td>
                                    <td class="text-end">
                                        @unless ($req['is_fixed'])
                                            <button type="button" class="btn btn-link btn-sm text-danger p-0" wire:click="removeRequirement({{ $i }})"
                                                wire:confirm="¿Quitar este requisito?" title="Quitar"><i class="ti ti-trash"></i></button>
                                        @endunless
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
