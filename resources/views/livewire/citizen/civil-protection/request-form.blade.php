<div>
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h5 class="mb-0">Folio de solicitud: <span class="badge bg-secondary-subtle text-dark">{{ $case?->folio ?? '00000' }}</span></h5>
        <span class="badge bg-info-subtle text-dark px-3 py-2">{{ $case ? 'Borrador' : 'Nueva' }}</span>
    </div>

    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <span class="badge bg-danger-subtle text-danger mb-2">{{ $procedure->type_label }}</span>
            <h4 class="mb-1">{{ $procedure->name }}</h4>
            <p class="text-muted mb-0">{{ $procedure->description }}</p>
        </div>
        <a href="{{ route('citizen.civil_protection.hub') }}" class="small text-nowrap">Cambiar de trámite</a>
    </div>

    {{-- Datos del solicitante --}}
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="mb-3">Datos del solicitante</h6>
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
            <label class="form-label small text-uppercase text-muted fw-semibold">{{ $person_type === 'moral' ? 'Razón social' : 'Nombre completo' }} *</label>
            <input type="text" wire:model="applicant_name" class="form-control mb-3">
            @error('applicant_name')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small text-uppercase text-muted fw-semibold">Teléfono *</label>
                    <input type="tel" wire:model="phone" maxlength="10" class="form-control" placeholder="10 dígitos">
                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-uppercase text-muted fw-semibold">Correo electrónico</label>
                    <input type="email" wire:model="email" class="form-control">
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Requisitos --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="mb-1">Requisitos</h6>
                <small class="fw-semibold text-warning">{{ $required - $missing }} de {{ $required }} obligatorios cargados</small>
            </div>
            <div class="progress mb-2" role="progressbar" aria-valuenow="{{ $required ? round(($required - $missing) / $required * 100) : 100 }}" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar bg-warning w-{{ $required ? (int) (floor(($required - $missing) / $required * 4) * 25) : 100 }}"></div>
            </div>
            <small class="text-muted">Tu avance se guarda al subir el primer documento.</small>
        </div>
    </div>

    @foreach ($requirements as $i => $requirement)
        @php $doc = $documents[$requirement->id] ?? null; $version = $doc?->latestVersion; @endphp
        <div class="card mb-2" wire:key="req-{{ $requirement->id }}">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="badge rounded-circle border text-dark">{{ $i + 1 }}</span>
                <div class="flex-grow-1">
                    <p class="fw-semibold mb-0">
                        {{ $requirement->name }}
                        @if ($requirement->is_required)<span class="text-danger">*</span>@else<small class="text-muted fw-normal">· opcional</small>@endif
                    </p>
                    <small class="d-block">{{ $requirement->instructions }}</small>
                    <small class="text-muted">
                        {{ strtoupper(implode(', ', $requirement->formats)) }}
                        @if ($requirement->requires_original) · deberás entregar el original en oficinas @endif
                    </small>
                    @if ($version)
                        <small class="d-block text-success"><i class="ti ti-check"></i> {{ $version->filename }} · {{ $version->size_label }}</small>
                    @endif
                    <div wire:loading wire:target="uploads.{{ $requirement->id }}"><small class="text-muted">Subiendo...</small></div>
                    @error('uploads.'.$requirement->id)<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
                <label @class(['btn btn-sm mb-0 flex-shrink-0', 'btn-outline-secondary' => $version, 'btn-primary' => ! $version])>
                    {{ $version ? 'Reemplazar' : 'Subir archivo' }}
                    <input type="file" class="d-none" wire:model="uploads.{{ $requirement->id }}"
                        accept="{{ collect($requirement->formats)->map(fn ($f) => '.'.$f)->implode(',') }}">
                </label>
            </div>
        </div>
    @endforeach

    @error('documents')<div class="alert alert-danger mt-2">{{ $message }}</div>@enderror

    <div class="d-flex justify-content-between align-items-start border-top pt-3 mt-3">
        <button type="button" class="btn btn-outline-secondary" wire:click="saveDraft">Guardar y continuar después</button>
        <div class="text-end">
            <button type="button" class="btn btn-primary" wire:click="askSubmit" @disabled($missing > 0)>Enviar solicitud</button>
            @if ($missing > 0)
                <small class="d-block text-muted mt-1">Faltan {{ $missing }} documentos obligatorios</small>
            @endif
        </div>
    </div>

    @if ($confirmingSubmit)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <h6>¿Enviar tu solicitud?</h6>
                        <p class="small text-muted">Protección Civil revisará tus documentos. Recibirás un folio y te avisaremos de cada cambio en tus mensajes.</p>
                        <button type="button" class="btn btn-primary w-100 mb-2" wire:click="submit" wire:loading.attr="disabled">Sí, enviar solicitud</button>
                        <button type="button" class="btn btn-outline-secondary w-100" wire:click="$set('confirmingSubmit', false)">Volver</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
