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
            <button class="nav-link active" id="solicitud-tab" data-bs-toggle="tab" data-bs-target="#solicitud" type="button" role="tab">
                <i class="fas fa-file-alt"></i> Solicitud
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pago-tab" data-bs-toggle="tab" data-bs-target="#pago" type="button" role="tab">
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
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-user"></i> Datos del Solicitante</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Tipo de Constancia</label>
                                    <p class="fw-bold">{{ $certificate->certificate_type }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Folio</label>
                                    <p class="fw-bold">{{ $certificate->folio }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Nombre Completo</label>
                                    <p class="fw-bold">{{ $certificate->full_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Fecha de Nacimiento</label>
                                    <p class="fw-bold">{{ $certificate->birth_date ? \Carbon\Carbon::parse($certificate->birth_date)->format('d/m/Y') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">CURP</label>
                                    <p class="fw-bold">{{ $certificate->curp }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Telefono</label>
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

                    <!-- Documentos -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-file"></i> Documentos</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Acta de Nacimiento</label>
                                    @if($certificate->birth_certificate_file)
                                        <a href="{{ $certificate->birth_certificate_file }}" target="_blank" class="btn btn-outline-primary btn-sm d-block mb-2">
                                            <i class="fas fa-download"></i> Ver documento
                                        </a>
                                        <button type="button" wire:click="toggleApproval('birth_certificate_approved')"
                                            class="btn btn-sm w-100 {{ $birth_certificate_approved ? 'btn-success' : 'btn-outline-secondary' }}">
                                            <i class="fas {{ $birth_certificate_approved ? 'fa-check-circle' : 'fa-circle' }}"></i>
                                            {{ $birth_certificate_approved ? 'Aprobado' : 'Aprobar' }}
                                        </button>
                                    @else
                                        <p class="text-danger">No subido</p>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Comprobante de Domicilio</label>
                                    @if($certificate->proof_of_address_file)
                                        <a href="{{ $certificate->proof_of_address_file }}" target="_blank" class="btn btn-outline-primary btn-sm d-block mb-2">
                                            <i class="fas fa-download"></i> Ver documento
                                        </a>
                                        <button type="button" wire:click="toggleApproval('proof_of_address_approved')"
                                            class="btn btn-sm w-100 {{ $proof_of_address_approved ? 'btn-success' : 'btn-outline-secondary' }}">
                                            <i class="fas {{ $proof_of_address_approved ? 'fa-check-circle' : 'fa-circle' }}"></i>
                                            {{ $proof_of_address_approved ? 'Aprobado' : 'Aprobar' }}
                                        </button>
                                    @else
                                        <p class="text-danger">No subido</p>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Fotografia</label>
                                    @if($certificate->photo_file)
                                        <a href="{{ $certificate->photo_file }}" target="_blank" class="btn btn-outline-primary btn-sm d-block mb-2">
                                            <i class="fas fa-download"></i> Ver foto
                                        </a>
                                        <button type="button" wire:click="toggleApproval('photo_approved')"
                                            class="btn btn-sm w-100 {{ $photo_approved ? 'btn-success' : 'btn-outline-secondary' }}">
                                            <i class="fas {{ $photo_approved ? 'fa-check-circle' : 'fa-circle' }}"></i>
                                            {{ $photo_approved ? 'Aprobado' : 'Aprobar' }}
                                        </button>
                                    @else
                                        <p class="text-muted">No subida</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testigos -->
                    <div class="row">
                        <!-- Primer Testigo -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-user-check"></i> Primer Testigo</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Nombre Completo</label>
                                        <p class="fw-bold">{{ $certificate->first_witness_full_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Fecha de Nacimiento</label>
                                        <p class="fw-bold">{{ $certificate->first_witness_birth_date ? \Carbon\Carbon::parse($certificate->first_witness_birth_date)->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Domicilio</label>
                                        <p class="fw-bold">{{ $certificate->first_witness_address ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">INE</label>
                                        @if($certificate->first_witness_ine_file)
                                            <a href="{{ $certificate->first_witness_ine_file }}" target="_blank" class="btn btn-outline-primary btn-sm d-block mb-2">
                                                <i class="fas fa-download"></i> Ver INE
                                            </a>
                                            <button type="button" wire:click="toggleApproval('first_witness_ine_approved')"
                                                class="btn btn-sm w-100 {{ $first_witness_ine_approved ? 'btn-success' : 'btn-outline-secondary' }}">
                                                <i class="fas {{ $first_witness_ine_approved ? 'fa-check-circle' : 'fa-circle' }}"></i>
                                                {{ $first_witness_ine_approved ? 'Aprobado' : 'Aprobar' }}
                                            </button>
                                        @else
                                            <p class="text-danger">No subido</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Segundo Testigo -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-user-check"></i> Segundo Testigo</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Nombre Completo</label>
                                        <p class="fw-bold">{{ $certificate->second_witness_full_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Fecha de Nacimiento</label>
                                        <p class="fw-bold">{{ $certificate->second_witness_birth_date ? \Carbon\Carbon::parse($certificate->second_witness_birth_date)->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Domicilio</label>
                                        <p class="fw-bold">{{ $certificate->second_witness_address ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">INE</label>
                                        @if($certificate->second_witness_ine_file)
                                            <a href="{{ $certificate->second_witness_ine_file }}" target="_blank" class="btn btn-outline-primary btn-sm d-block mb-2">
                                                <i class="fas fa-download"></i> Ver INE
                                            </a>
                                            <button type="button" wire:click="toggleApproval('second_witness_ine_approved')"
                                                class="btn btn-sm w-100 {{ $second_witness_ine_approved ? 'btn-success' : 'btn-outline-secondary' }}">
                                                <i class="fas {{ $second_witness_ine_approved ? 'fa-check-circle' : 'fa-circle' }}"></i>
                                                {{ $second_witness_ine_approved ? 'Aprobado' : 'Aprobar' }}
                                            </button>
                                        @else
                                            <p class="text-danger">No subido</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha: Estatus y Notas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0"><i class="fas fa-cog"></i> Administracion</h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="updateStatus">
                                <div class="mb-3">
                                    <label class="form-label">Estatus</label>
                                    <select class="form-select" wire:model="status">
                                        <option value="Solicitud nueva">Solicitud nueva</option>
                                        <option value="En revision">En revision</option>
                                        <option value="Documentos pendientes">Documentos pendientes</option>
                                        <option value="Pago pendiente">Pago pendiente</option>
                                        <option value="Pago recibido">Pago recibido</option>
                                        <option value="Aprobada">Aprobada</option>
                                        <option value="Rechazada">Rechazada</option>
                                        <option value="Completada">Completada</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notas Administrativas</label>
                                    <textarea class="form-control" rows="4" wire:model="admin_notes" placeholder="Agregar notas..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Resumen de Aprobaciones -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-clipboard-check"></i> Documentos</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas {{ $birth_certificate_approved ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                    Acta de Nacimiento
                                </li>
                                <li class="mb-2">
                                    <i class="fas {{ $proof_of_address_approved ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                    Comprobante de Domicilio
                                </li>
                                <li class="mb-2">
                                    <i class="fas {{ $photo_approved ? 'fa-check-circle text-success' : 'fa-minus-circle text-muted' }}"></i>
                                    Fotografia
                                </li>
                                <li class="mb-2">
                                    <i class="fas {{ $first_witness_ine_approved ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                    INE Primer Testigo
                                </li>
                                <li>
                                    <i class="fas {{ $second_witness_ine_approved ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                    INE Segundo Testigo
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informacion</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Fecha de solicitud:</strong><br>{{ $certificate->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Ultima actualizacion:</strong><br>{{ $certificate->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Pago -->
        <div class="tab-pane fade" id="pago" role="tabpanel">
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-credit-card"></i> Informacion de Pago</h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="savePayment">
                                @if($payment)
                                    <div class="alert alert-info">
                                        <strong>Folio de pago:</strong> {{ $payment->folio }}
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Numero de Recibo</label>
                                        <input type="text" class="form-control" wire:model="receipt_number" placeholder="Ej: REC-2026-001">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha de Pago</label>
                                        <input type="date" class="form-control" wire:model="payment_date">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Estatus del Pago</label>
                                        <select class="form-select" wire:model="payment_status">
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="En proceso">En proceso</option>
                                            <option value="Pagado">Pagado</option>
                                            <option value="Rechazado">Rechazado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Comprobante de Pago</label>
                                        <input type="file" class="form-control" wire:model="proof_file" accept=".pdf,.jpg,.jpeg,.png">
                                        @if($payment && $payment->proof_filename)
                                            <a href="{{ $payment->proof_filename }}" target="_blank" class="btn btn-link btn-sm">
                                                <i class="fas fa-eye"></i> Ver comprobante actual
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Notas del Pago</label>
                                        <textarea class="form-control" rows="3" wire:model="payment_notes" placeholder="Notas adicionales sobre el pago..."></textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Guardar Informacion de Pago
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Resumen</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Solicitante:</strong><br>{{ $certificate->full_name }}</p>
                            <p><strong>Folio Solicitud:</strong><br>{{ $certificate->folio }}</p>
                            <p><strong>Estatus Solicitud:</strong><br>
                                @php
                                    $statusColors = [
                                        'Solicitud nueva' => 'warning',
                                        'En revision' => 'info',
                                        'Documentos pendientes' => 'secondary',
                                        'Pago pendiente' => 'primary',
                                        'Pago recibido' => 'info',
                                        'Aprobada' => 'success',
                                        'Rechazada' => 'danger',
                                        'Completada' => 'success',
                                    ];
                                    $color = $statusColors[$certificate->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $certificate->status }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
