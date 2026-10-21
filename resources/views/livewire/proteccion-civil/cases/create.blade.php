<div>
    <form wire:submit="save">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 1. Trámite --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="d-flex align-items-center gap-2 mb-3"><span class="pc-step">1</span> Trámite</h5>
                <select wire:model.live="procedureId" class="form-select">
                    <option value="">Selecciona el trámite del catálogo...</option>
                    @foreach ($procedures as $procedure)
                        <option value="{{ $procedure->id }}">{{ $procedure->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 2. Datos del solicitante --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="d-flex align-items-center gap-2 mb-3"><span class="pc-step">2</span> Datos del solicitante</h5>
                <div class="mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model.live="person_type" value="fisica" id="pt-fisica">
                        <label class="form-check-label" for="pt-fisica">Persona física</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model.live="person_type" value="moral" id="pt-moral">
                        <label class="form-check-label" for="pt-moral">Persona moral</label>
                    </div>
                </div>
                <label class="pc-label">{{ $person_type === 'moral' ? 'Razón social' : 'Nombre completo' }} *</label>
                <input type="text" wire:model="applicant_name" class="form-control mb-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="pc-label">Teléfono *</label>
                        <input type="tel" wire:model="phone" maxlength="10" class="form-control" placeholder="10 dígitos">
                    </div>
                    <div class="col-md-4">
                        <label class="pc-label">Correo electrónico</label>
                        <input type="email" wire:model="email" class="form-control" placeholder="Para vincular con su cuenta">
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Documentos recibidos --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="d-flex align-items-center gap-2 mb-3"><span class="pc-step">3</span> Documentos recibidos en ventanilla</h5>
                @if ($requirements->isEmpty())
                    <p class="text-muted mb-0">Selecciona un trámite para ver sus requisitos.</p>
                @else
                    @foreach ($requirements as $i => $requirement)
                        <div class="border rounded-3 p-3 mb-2 d-flex justify-content-between align-items-center gap-3" wire:key="req-{{ $requirement->id }}">
                            <div>
                                <p class="fw-semibold mb-0">
                                    {{ $i + 1 }}. {{ $requirement->name }}
                                    @if ($requirement->is_required)<span class="text-danger">*</span>@endif
                                </p>
                                <small class="text-muted">{{ $requirement->instructions }} · {{ strtoupper(implode(' / ', $requirement->formats)) }}</small>
                                @if ($file = $files[$requirement->id] ?? null)
                                    <small class="d-block text-success"><i class="ti ti-check"></i> {{ $file->getClientOriginalName() }} · {{ round($file->getSize() / 1024) }} KB</small>
                                @endif
                                <div wire:loading wire:target="files.{{ $requirement->id }}"><small class="text-muted">Subiendo...</small></div>
                            </div>
                            <label class="btn btn-outline-secondary btn-sm mb-0 flex-shrink-0">
                                {{ isset($files[$requirement->id]) ? 'Reemplazar' : 'Subir' }}
                                <input type="file" class="d-none" wire:model="files.{{ $requirement->id }}"
                                    accept="{{ collect($requirement->formats)->map(fn ($f) => '.'.$f)->implode(',') }}">
                            </label>
                        </div>
                    @endforeach
                    <small class="text-muted">Los requisitos que no se reciban hoy quedan pendientes en el expediente.</small>
                @endif
            </div>
        </div>

        {{-- 4. Guardar --}}
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="pc-step">4</span>
                    <div>
                        <h5 class="mb-0">Guardar</h5>
                        <small class="text-muted">Se genera el folio {{ $nextFolio }} con origen «Presencial».</small>
                    </div>
                </div>
                <button type="submit" class="btn pc-btn" wire:loading.attr="disabled">Guardar y generar folio</button>
            </div>
        </div>
    </form>
</div>
