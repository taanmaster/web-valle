<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($mode == 0)
        {{-- ======================== MODO CREAR ======================== --}}

        <form wire:submit.prevent="save">

            {{-- Datos del Solicitante --}}
            <div class="mb-4">
                <h6 class="fw-semibold border-bottom pb-2 mb-3">Datos del solicitante</h6>
                <div class="card border">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    wire:model.blur="full_name" placeholder="Nombre completo del solicitante">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    wire:model.blur="phone" placeholder="10 dígitos">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    wire:model.blur="email" placeholder="correo@ejemplo.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Domicilio <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    wire:model.blur="address" placeholder="Calle, número, colonia, municipio">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Documento a Certificar --}}
            <div class="mb-4">
                <h6 class="fw-semibold border-bottom pb-2 mb-3">Documento a certificar</h6>
                <div class="card border">
                    <div class="card-body">
                        <label class="form-label">Nombre del documento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('filename') is-invalid @enderror"
                            wire:model.blur="filename"
                            placeholder="Ej. Acta de matrimonio, Poder notarial...">
                        @error('filename')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Solicitud --}}
            <div class="mb-4">
                <h6 class="fw-semibold border-bottom pb-2 mb-3">Solicitud</h6>
                <div class="card border">
                    <div class="card-body">
                        <p class="text-muted small mb-2">Escribe a continuación la solicitud del documento que deseas certificar.</p>
                        <textarea class="form-control @error('request') is-invalid @enderror"
                            wire:model.blur="request" rows="5"
                            placeholder="Describe tu solicitud..."></textarea>
                        @error('request')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Interés Legítimo --}}
            <div class="mb-4">
                <h6 class="fw-semibold border-bottom pb-2 mb-3">Acreditar el interés legítimo</h6>
                <div class="card border">
                    <div class="card-body">
                        <p class="text-muted small mb-2">Escribe a continuación el uso que le darás al documento que deseas certificar.</p>
                        <textarea class="form-control @error('request_intent') is-invalid @enderror"
                            wire:model.blur="request_intent" rows="5"
                            placeholder="Describe el uso o interés legítimo..."></textarea>
                        @error('request_intent')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning btn-lg px-5 rounded-pill fw-semibold"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">ENVIAR SOLICITUD</span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin me-1"></i> Enviando...
                    </span>
                </button>
            </div>
        </form>

    @else
        {{-- ======================== MODO VER ======================== --}}

        {{-- Badge de estatus --}}
        <div class="text-center mb-4">
            @php
                $statusColors = [
                    'Solicitud nueva'       => 'secondary',
                    'En revisión'           => 'info',
                    'Documentos pendientes' => 'warning',
                    'Pago pendiente'        => 'warning',
                    'Pago recibido'         => 'primary',
                    'Aprobada'              => 'success',
                    'Rechazada'             => 'danger',
                    'Completada'            => 'dark',
                ];
                $color = $statusColors[$certificate->status] ?? 'secondary';
            @endphp
            <span class="badge bg-{{ $color }} fs-6 px-4 py-2">{{ $certificate->status }}</span>
        </div>

        {{-- Datos del solicitante --}}
        <div class="mb-4">
            <h6 class="fw-semibold border-bottom pb-2 mb-3">Datos del solicitante</h6>
            <div class="card border">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Nombre Completo</label>
                            <p class="fw-semibold mb-0">{{ $certificate->full_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Teléfono</label>
                            <p class="fw-semibold mb-0">{{ $certificate->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Correo Electrónico</label>
                            <p class="fw-semibold mb-0">{{ $certificate->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Domicilio</label>
                            <p class="fw-semibold mb-0">{{ $certificate->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Documento --}}
        <div class="mb-4">
            <h6 class="fw-semibold border-bottom pb-2 mb-3">Documento a certificar</h6>
            <div class="card border">
                <div class="card-body">
                    <label class="form-label text-muted small">Nombre del documento</label>
                    <p class="fw-semibold mb-0">{{ $certificate->filename }}</p>
                </div>
            </div>
        </div>

        {{-- Solicitud --}}
        <div class="mb-4">
            <h6 class="fw-semibold border-bottom pb-2 mb-3">Solicitud</h6>
            <div class="card border">
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $certificate->request }}</p>
                </div>
            </div>
        </div>

        {{-- Interés Legítimo --}}
        <div class="mb-4">
            <h6 class="fw-semibold border-bottom pb-2 mb-3">Acreditar el interés legítimo</h6>
            <div class="card border">
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $certificate->request_intent }}</p>
                </div>
            </div>
        </div>

        {{-- Notas del admin (si existen) --}}
        @if ($certificate->admin_notes)
            <div class="mb-4">
                <h6 class="fw-semibold border-bottom pb-2 mb-3">Notas</h6>
                <div class="card border border-warning">
                    <div class="card-body">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $certificate->admin_notes }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Información del pago (si existe) --}}
        @if ($certificate->payment)
            <div class="mb-4">
                <h6 class="fw-semibold border-bottom pb-2 mb-3">Información de Pago</h6>
                <div class="card border">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Folio de Pago</label>
                                <p class="fw-semibold mb-0">{{ $certificate->payment->folio }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Estatus</label>
                                <p class="fw-semibold mb-0">{{ $certificate->payment->status }}</p>
                            </div>
                            @if ($certificate->payment->receipt_number)
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Número de Recibo</label>
                                    <p class="fw-semibold mb-0">{{ $certificate->payment->receipt_number }}</p>
                                </div>
                            @endif
                            @if ($certificate->payment->payment_date)
                                <div class="col-md-6">
                                    <label class="form-label text-muted small">Fecha de Pago</label>
                                    <p class="fw-semibold mb-0">
                                        {{ \Carbon\Carbon::parse($certificate->payment->payment_date)->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endif
                            @if ($certificate->payment->proof_filename)
                                <div class="col-12">
                                    <a href="{{ $certificate->payment->proof_filename }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-file-download"></i> Ver Comprobante
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endif
</div>
