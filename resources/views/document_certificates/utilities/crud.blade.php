<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="certificateTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="solicitud-tab" data-bs-toggle="tab" data-bs-target="#solicitud"
                type="button" role="tab">
                <i class="fas fa-file-alt"></i> Solicitud
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pago-tab" data-bs-toggle="tab" data-bs-target="#pago" type="button"
                role="tab">
                <i class="fas fa-credit-card"></i> Pago
            </button>
        </li>
    </ul>

    <div class="tab-content" id="certificateTabsContent">

        <!-- Tab Solicitud -->
        <div class="tab-pane fade show active" id="solicitud" role="tabpanel">
            <div class="row mt-4">

                <!-- Columna izquierda: Datos de la solicitud -->
                <div class="col-md-8">

                    <!-- Datos del Solicitante -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h6 class="mb-0 text-white"><i class="fas fa-user"></i> Datos del Solicitante</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Folio</label>
                                    <p class="fw-bold">{{ $certificate->folio }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Fecha de Solicitud</label>
                                    <p class="fw-bold">{{ $certificate->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Nombre Completo</label>
                                    <p class="fw-bold">{{ $certificate->full_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Teléfono</label>
                                    <p class="fw-bold">{{ $certificate->phone ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Email</label>
                                    <p class="fw-bold">{{ $certificate->email ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-muted">Domicilio</label>
                                    <p class="fw-bold">{{ $certificate->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documento a Certificar -->
                    <div class="card mb-4">
                        <div class="card-header bg-info">
                            <h6 class="mb-0 text-white"><i class="fas fa-file-certificate"></i> Documento a Certificar</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nombre del Documento</label>
                                <p class="fw-bold">{{ $certificate->filename ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Solicitud -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary">
                            <h6 class="mb-0 text-white"><i class="fas fa-pen"></i> Solicitud</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $certificate->request }}</p>
                        </div>
                    </div>

                    <!-- Interés Legítimo -->
                    <div class="card mb-4">
                        <div class="card-header" style="background-color: #6f42c1;">
                            <h6 class="mb-0 text-white"><i class="fas fa-balance-scale"></i> Acreditar el Interés Legítimo</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $certificate->request_intent }}</p>
                        </div>
                    </div>

                </div>

                <!-- Columna derecha: Administración -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0 text-white"><i class="fas fa-cog"></i> Administración</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Estatus</label>
                                <select class="form-select" wire:model.live="status">
                                    <option value="Solicitud nueva">Solicitud nueva</option>
                                    <option value="Pago realizado">Pago realizado</option>
                                    <option value="Aprobada">Aprobada</option>
                                    <option value="Rechazada">Rechazada</option>
                                    <option value="Entregado">Entregado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notas Administrativas</label>
                                <textarea class="form-control" rows="5" wire:model.blur="admin_notes"
                                    placeholder="Agregar notas..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0 text-dark"><i class="fas fa-info-circle"></i> Información</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Fecha de solicitud:</strong><br>{{ $certificate->created_at->format('d/m/Y H:i') }}</p>
                            <p class="mb-0"><strong>Última actualización:</strong><br>{{ $certificate->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Pago -->
        <div class="tab-pane fade" id="pago" role="tabpanel">
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h6 class="mb-0 text-white"><i class="fas fa-credit-card"></i> Registro de Pago</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Número de Recibo</label>
                                    <input type="text" class="form-control" wire:model.blur="receipt_number"
                                        placeholder="Ej. REC-2026-001">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Pago</label>
                                    <input type="date" class="form-control" wire:model.blur="payment_date">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Estatus del Pago</label>
                                    <select class="form-select" wire:model.live="payment_status">
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="En proceso">En proceso</option>
                                        <option value="Pagado">Pagado</option>
                                        <option value="Rechazado">Rechazado</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Comprobante de Pago</label>
                                    <input type="file" class="form-control" wire:model="proof_file"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    @error('proof_file')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notas del Pago</label>
                                    <textarea class="form-control" rows="3" wire:model.blur="payment_notes"
                                        placeholder="Agregar notas del pago..."></textarea>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary" wire:click="savePayment"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="savePayment">
                                        <i class="fas fa-save"></i> Guardar Pago
                                    </span>
                                    <span wire:loading wire:target="savePayment">
                                        <i class="fas fa-spinner fa-spin"></i> Guardando...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0 text-dark"><i class="fas fa-receipt"></i> Resumen del Pago</h6>
                        </div>
                        <div class="card-body">
                            @if ($payment)
                                <p><strong>Folio pago:</strong><br>{{ $payment->folio }}</p>
                                <p><strong>Número de recibo:</strong><br>{{ $payment->receipt_number ?? 'N/A' }}</p>
                                <p><strong>Fecha de pago:</strong><br>
                                    {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : 'N/A' }}
                                </p>
                                <p><strong>Estatus:</strong><br>
                                    @php
                                        $paymentColors = [
                                            'Pendiente'  => 'warning',
                                            'En proceso' => 'info',
                                            'Pagado'     => 'success',
                                            'Rechazado'  => 'danger',
                                        ];
                                        $pc = $paymentColors[$payment->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $pc }}">{{ $payment->status }}</span>
                                </p>
                                @if ($payment->proof_filename)
                                    <a href="{{ $payment->proof_filename }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm w-100 mt-2">
                                        <i class="fas fa-file-download"></i> Ver Comprobante
                                    </a>
                                @endif
                            @else
                                <p class="text-muted text-center py-3">
                                    <i class="fas fa-info-circle me-1"></i> Sin registro de pago
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
