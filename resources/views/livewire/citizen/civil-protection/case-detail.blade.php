<div>
    <nav class="small mb-2">
        <a href="{{ route('citizen.civil_protection.index') }}">Mis trámites</a> › {{ $case->folio }}
    </nav>
    <p class="text-muted small mb-1">{{ $case->procedure->type_label }} · {{ $case->procedure->name }}</p>
    <h4 class="d-flex align-items-center gap-2 mb-1">
        {{ $case->folio }}
        <span class="badge rounded-pill bg-{{ $case->status_color }}-subtle text-{{ $case->status_color }} fs-6">{{ \App\Models\CivilProtectionCase::STATUSES[$case->status][1] }}</span>
        @if ($validity = $case->validity)
            <span class="badge rounded-pill bg-{{ $validity[1] }}-subtle text-{{ $validity[1] }} fs-6">{{ str_replace(' d', ' días', $validity[0]) }}</span>
        @endif
    </h4>
    <p>{{ $headline }}</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Datos del solicitante (sólo lectura) --}}
    <div class="card mb-3">
        <div class="card-body">
            <p class="small mb-2"><ion-icon name="person-outline"></ion-icon> {{ $case->person_type_label }}</p>
            <div class="row g-3">
                <div class="col-12">
                    <small class="text-muted text-uppercase">{{ $case->person_type === 'moral' ? 'Razón social' : 'Nombre completo' }}</small>
                    <p class="mb-0 fw-semibold">{{ $case->applicant_name }}</p>
                </div>
                <div class="col-md-6">
                    <small class="text-muted text-uppercase">Teléfono</small>
                    <p class="mb-0">{{ $case->phone }}</p>
                </div>
                <div class="col-md-6">
                    <small class="text-muted text-uppercase">Correo electrónico</small>
                    <p class="mb-0">{{ $case->email ?: '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            {{-- Entero / documento emitido --}}
            @if ($case->payment_order_folio)
                <div class="card mb-3 border-warning">
                    <div class="card-body d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <h6 class="mb-1">Entero de pago</h6>
                            <p class="font-monospace fw-semibold mb-0">{{ $case->payment_order_folio }}</p>
                            <small class="text-muted">{{ $case->payment_order_concept }}</small>
                            @if ($case->payment_confirmed_at)
                                <small class="d-block text-success"><ion-icon name="checkmark-outline"></ion-icon> Pago confirmado el {{ ($case->payment_date ?? $case->payment_confirmed_at)->format('d/m/Y') }}</small>
                            @endif
                        </div>
                        <div class="text-end flex-shrink-0">
                            <p class="fw-semibold mb-1">${{ number_format($case->payment_order_amount, 2) }}</p>
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showPaymentOrder', true)">Ver entero</button>
                        </div>
                    </div>
                </div>
            @endif

            @if ($case->document_number)
                <div class="card mb-3 border-success">
                    <div class="card-body d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <h6 class="mb-1">{{ $case->procedure->type_label }} emitida</h6>
                            <p class="font-monospace fw-semibold mb-0">{{ $case->document_number }}</p>
                            <small class="text-muted">Emitida el {{ $case->issued_at->format('d/m/Y') }} · vence el {{ $case->expires_at->format('d/m/Y') }}</small>
                        </div>
                        <a href="{{ $case->document_s3_url }}" target="_blank" rel="noopener" class="btn btn-success btn-sm flex-shrink-0">Descargar PDF</a>
                    </div>
                </div>
            @endif

            {{-- Mis documentos --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Mis documentos</h6>
                    @foreach ($case->documents as $doc)
                        @php
                            $label = ['sin_entregar' => 'Sin entregar', 'por_revisar' => 'En revisión', 'aceptado' => 'Aceptado', 'rechazado' => 'Rechazado'][$doc->status];
                            $canUpload = in_array($doc->status, ['rechazado', 'sin_entregar']) && ! in_array($case->status, \App\Models\CivilProtectionCase::FINAL_STATUSES);
                        @endphp
                        <div class="py-2 border-bottom" wire:key="cdoc-{{ $doc->id }}">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <p class="fw-semibold mb-0">{{ $doc->name }} @if ($doc->is_required)<span class="text-danger">*</span>@endif</p>
                                    @if ($doc->latestVersion)
                                        <small class="text-muted">{{ $doc->latestVersion->filename }} · v{{ $doc->latestVersion->version }} · {{ $doc->latestVersion->created_at->format('d/m/Y H:i') }}</small>
                                    @else
                                        <small class="text-muted">{{ $doc->instructions }} · {{ $doc->formats_label }}</small>
                                    @endif
                                </div>
                                <span class="badge rounded-pill bg-{{ $doc->status_color }}-subtle text-{{ $doc->status_color }}">{{ $label }}</span>
                            </div>
                            @if ($doc->status === 'rechazado' && $doc->rejection_reason)
                                <small class="d-block text-danger">Motivo del rechazo: {{ $doc->rejection_reason }}</small>
                            @endif
                            @if ($canUpload)
                                <label class="btn btn-sm btn-outline-primary mt-2 mb-0">
                                    {{ $doc->status === 'rechazado' ? 'Subir corrección' : 'Subir archivo' }}
                                    <input type="file" class="d-none" wire:model="uploads.{{ $doc->id }}"
                                        accept="{{ collect($doc->formats)->map(fn ($f) => '.'.$f)->implode(',') }}">
                                </label>
                                <span wire:loading wire:target="uploads.{{ $doc->id }}" class="small text-muted ms-2">Subiendo...</span>
                                @error('uploads.'.$doc->id)<small class="text-danger d-block">{{ $message }}</small>@enderror
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="mb-3">Avance</h6>
                    @foreach ($case->logs as $log)
                        <div class="border-start border-2 ps-3 pb-3 position-relative">
                            <p class="fw-semibold small mb-0"><span class="text-{{ $log->status_color }}">●</span> {{ \App\Models\CivilProtectionCase::STATUSES[$log->status][1] ?? $log->status }}</p>
                            <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body small">
                    <p class="text-uppercase fw-semibold text-danger mb-1">Protección Civil</p>
                    <p class="mb-1">Coordinación Municipal de Protección Civil · Av. Juárez 210, Zona Centro, Valle de Santiago, Gto.</p>
                    <p class="mb-1">Atención lunes a viernes de 9:00 a 15:00</p>
                    <p class="mb-0">Tel. 456 643 0012</p>
                </div>
            </div>

            @if ($canCancel)
                <button type="button" class="btn btn-outline-danger w-100" wire:click="cancel"
                    wire:confirm="¿Seguro que quieres cancelar este trámite? No podrás reactivarlo.">Cancelar trámite</button>
            @endif
        </div>
    </div>

    @if ($showPaymentOrder && $case->payment_order_folio)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="d-flex justify-content-end gap-2 p-2 pc-no-print">
                        <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">Imprimir o guardar PDF</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showPaymentOrder', false)">Cerrar</button>
                    </div>
                    @include('proteccion_civil._payment_order')
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
