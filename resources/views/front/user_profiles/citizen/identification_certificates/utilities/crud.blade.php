<div>
    @if ($mode == 0)
        <!-- Formulario de creacion -->
        <form wire:submit.prevent="save">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Datos del Solicitante -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bx bx-user"></i> Datos del Solicitante</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="certificate_type" class="form-label">Tipo de Constancia <span
                                    class="text-danger">*</span></label>
                            <select wire:model="certificate_type" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <option value="Constancia de Identificacion">Constancia de Identificacion</option>
                                <option value="Constancia de Identidad">Constancia de Identidad</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Nombre Completo <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="full_name" class="form-control" required
                                placeholder="Nombre(s) y Apellidos">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="birth_date" class="form-label">Fecha de Nacimiento <span
                                    class="text-danger">*</span></label>
                            <input type="date" wire:model="birth_date" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="curp" class="form-label">CURP <span class="text-danger">*</span></label>
                            <input type="text" wire:model="curp" class="form-control" required maxlength="18"
                                placeholder="18 caracteres" style="text-transform: uppercase;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">Telefono de Contacto</label>
                            <input type="tel" wire:model="phone" class="form-control" placeholder="10 digitos">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electronico</label>
                            <input type="email" wire:model="email" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Domicilio Completo <span
                                    class="text-danger">*</span></label>
                            <textarea wire:model="address" class="form-control" rows="2" required
                                placeholder="Calle, numero, colonia, codigo postal, municipio"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bx bx-file"></i> Documentos Requeridos</h6>
                    <p class="mb-0 small">Todos los documentos deben ser legibles y en formato PDF, JPG o PNG. Tamaño
                        máximo: 5MB por archivo.</p>
                </div>
                <div class="card-body">
                    <!-- Acta de Nacimiento -->
                    <div class="document-item mb-4 pb-4 border-bottom">
                        <div class="d-flex align-items-start gap-3">
                            <!-- Icono de estado -->
                            <div class="flex-shrink-0">
                                @if ($birth_certificate_file)
                                    <div class="status-icon status-completed">
                                        <ion-icon name="checkmark-circle"
                                            style="font-size: 32px; color: #198754;"></ion-icon>
                                    </div>
                                @else
                                    <div class="status-icon status-pending">
                                        <ion-icon name="ellipse-outline"
                                            style="font-size: 32px; color: #ffc107;"></ion-icon>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1 {{ $birth_certificate_file ? 'text-success' : '' }}">
                                            Acta de Nacimiento <span class="text-danger">*</span>
                                        </h6>
                                        <small class="text-muted">
                                            @if ($birth_certificate_file)
                                                <span class="text-success">
                                                    <i class="bx bx-check"></i> Documento cargado exitosamente
                                                </span>
                                            @else
                                                <span class="text-warning">
                                                    <i class="bx bx-time-five"></i> Pendiente de subir
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="document.getElementById('birth_certificate_input').click()">
                                            <i class="bx bx-cloud-upload"></i> Subir Archivo
                                        </button>
                                    </div>
                                    <input type="file" wire:model="birth_certificate_file"
                                        id="birth_certificate_input" class="d-none" accept=".pdf,.jpg,.jpeg,.png"
                                        required>
                                </div>
                                <div wire:loading wire:target="birth_certificate_file" class="alert alert-info py-2">
                                    <i class="bx bx-loader-alt bx-spin"></i> Subiendo archivo...
                                </div>
                                @if ($birth_certificate_file)
                                    <div class="file-card">
                                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border">
                                            <i class="bx bx-file text-primary" style="font-size: 24px;"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">Acta de Nacimiento</div>
                                                <small
                                                    class="text-muted">{{ $birth_certificate_file->getClientOriginalName() }}</small>
                                            </div>
                                            <button type="button" wire:click="$set('birth_certificate_file', null)"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Comprobante de Domicilio -->
                    <div class="document-item mb-4 pb-4 border-bottom">
                        <div class="d-flex align-items-start gap-3">
                            <!-- Icono de estado -->
                            <div class="flex-shrink-0">
                                @if ($proof_of_address_file)
                                    <div class="status-icon status-completed">
                                        <ion-icon name="checkmark-circle"
                                            style="font-size: 32px; color: #198754;"></ion-icon>
                                    </div>
                                @else
                                    <div class="status-icon status-pending">
                                        <ion-icon name="ellipse-outline"
                                            style="font-size: 32px; color: #ffc107;"></ion-icon>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1 {{ $proof_of_address_file ? 'text-success' : '' }}">
                                            Comprobante de Domicilio <span class="text-danger">*</span>
                                        </h6>
                                        <small class="text-muted">
                                            @if ($proof_of_address_file)
                                                <span class="text-success">
                                                    <i class="bx bx-check"></i> Documento cargado exitosamente
                                                </span>
                                            @else
                                                <span class="text-warning">
                                                    <i class="bx bx-time-five"></i> Pendiente de subir (no mayor a 3
                                                    meses)
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="document.getElementById('proof_of_address_input').click()">
                                            <i class="bx bx-cloud-upload"></i> Subir Archivo
                                        </button>
                                    </div>
                                    <input type="file" wire:model="proof_of_address_file"
                                        id="proof_of_address_input" class="d-none" accept=".pdf,.jpg,.jpeg,.png"
                                        required>
                                </div>
                                <div wire:loading wire:target="proof_of_address_file" class="alert alert-info py-2">
                                    <i class="bx bx-loader-alt bx-spin"></i> Subiendo archivo...
                                </div>
                                @if ($proof_of_address_file)
                                    <div class="file-card">
                                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border">
                                            <i class="bx bx-file text-primary" style="font-size: 24px;"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">Comprobante de Domicilio</div>
                                                <small
                                                    class="text-muted">{{ $proof_of_address_file->getClientOriginalName() }}</small>
                                            </div>
                                            <button type="button" wire:click="$set('proof_of_address_file', null)"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Fotografía -->
                    <div class="document-item">
                        <div class="d-flex align-items-start gap-3">
                            <!-- Icono de estado -->
                            <div class="flex-shrink-0">
                                @if ($photo_file)
                                    <div class="status-icon status-completed">
                                        <ion-icon name="checkmark-circle"
                                            style="font-size: 32px; color: #198754;"></ion-icon>
                                    </div>
                                @else
                                    <div class="status-icon status-pending">
                                        <ion-icon name="ellipse-outline"
                                            style="font-size: 32px; color: #ffc107;"></ion-icon>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1 {{ $photo_file ? 'text-success' : '' }}">
                                            Fotografía <span class="badge bg-secondary">Opcional</span>
                                        </h6>
                                        <small class="text-muted">
                                            @if ($photo_file)
                                                <span class="text-success">
                                                    <i class="bx bx-check"></i> Documento cargado exitosamente
                                                </span>
                                            @else
                                                <span>
                                                    <i class="bx bx-info-circle"></i> Foto reciente, fondo blanco
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="document.getElementById('photo_input').click()">
                                            <i class="bx bx-cloud-upload"></i> Subir Archivo
                                        </button>
                                    </div>
                                    <input type="file" wire:model="photo_file" id="photo_input" class="d-none"
                                        accept=".jpg,.jpeg,.png">
                                </div>
                                <div wire:loading wire:target="photo_file" class="alert alert-info py-2">
                                    <i class="bx bx-loader-alt bx-spin"></i> Subiendo archivo...
                                </div>
                                @if ($photo_file)
                                    <div class="file-card">
                                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border">
                                            <i class="bx bx-image text-success" style="font-size: 24px;"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">Fotografía</div>
                                                <small
                                                    class="text-muted">{{ $photo_file->getClientOriginalName() }}</small>
                                            </div>
                                            <button type="button" wire:click="$set('photo_file', null)"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Primer Testigo -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bx bx-user-check"></i> Primer Testigo</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" wire:model="first_witness_full_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" wire:model="first_witness_birth_date" class="form-control"
                                required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Domicilio <span class="text-danger">*</span></label>
                            <textarea wire:model="first_witness_address" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">INE del Testigo (ambos lados) <span
                                    class="text-danger">*</span></label>
                            <input type="file" wire:model="first_witness_ine_file" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="text-muted">Formatos: PDF, JPG, PNG. Max: 5MB</small>
                            <div wire:loading wire:target="first_witness_ine_file" class="text-info mt-1">
                                <i class="bx bx-loader-alt bx-spin"></i> Subiendo...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segundo Testigo -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bx bx-user-check"></i> Segundo Testigo</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" wire:model="second_witness_full_name" class="form-control"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" wire:model="second_witness_birth_date" class="form-control"
                                required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Domicilio <span class="text-danger">*</span></label>
                            <textarea wire:model="second_witness_address" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">INE del Testigo (ambos lados) <span
                                    class="text-danger">*</span></label>
                            <input type="file" wire:model="second_witness_ine_file" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="text-muted">Formatos: PDF, JPG, PNG. Max: 5MB</small>
                            <div wire:loading wire:target="second_witness_ine_file" class="text-info mt-1">
                                <i class="bx bx-loader-alt bx-spin"></i> Subiendo...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terminos y envio -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="accept_terms" required>
                        <label class="form-check-label" for="accept_terms">
                            Declaro bajo protesta de decir verdad que la informacion proporcionada es veridica y acepto
                            los terminos y condiciones del tramite.
                        </label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('citizen.profile.identification_certificates') }}"
                            class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                <i class="bx bx-check"></i> Enviar Solicitud
                            </span>
                            <span wire:loading wire:target="save">
                                <i class="bx bx-loader-alt bx-spin"></i> Enviando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <!-- Vista de detalle -->
        <div class="row">
            <div class="col-md-8">
                <!-- Estatus -->
                <div
                    class="alert alert-{{ $certificate->status == 'Completada' || $certificate->status == 'Aprobada' ? 'success' : ($certificate->status == 'Rechazada' ? 'danger' : 'info') }} mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Folio:</strong> {{ $certificate->folio }}
                        </div>
                        <div>
                            <strong>Estatus:</strong>
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
                        </div>
                    </div>
                </div>

                <!-- Datos del Solicitante -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bx bx-user"></i> Datos del Solicitante</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Tipo de Constancia</label>
                                <p class="fw-bold">{{ $certificate->certificate_type }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Nombre Completo</label>
                                <p class="fw-bold">{{ $certificate->full_name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Fecha de Nacimiento</label>
                                <p class="fw-bold">
                                    {{ \Carbon\Carbon::parse($certificate->birth_date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">CURP</label>
                                <p class="fw-bold">{{ $certificate->curp }}</p>
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
                        <h6 class="mb-0"><i class="bx bx-file"></i> Documentos</h6>
                    </div>
                    <div class="card-body">
                        <!-- Acta de Nacimiento -->
                        <div class="document-item mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-start gap-3">
                                <!-- Icono de estado -->
                                <div class="flex-shrink-0">
                                    @if ($certificate->birth_certificate_approved)
                                        <div class="status-icon status-completed">
                                            <ion-icon name="checkmark-circle"
                                                style="font-size: 32px; color: #198754;"></ion-icon>
                                        </div>
                                    @else
                                        <div class="status-icon status-pending">
                                            <ion-icon name="ellipse-outline"
                                                style="font-size: 32px; color: #ffc107;"></ion-icon>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6
                                                class="mb-1 {{ $certificate->birth_certificate_approved ? 'text-success' : '' }}">
                                                Acta de Nacimiento
                                            </h6>
                                            <small class="text-muted">
                                                @if ($certificate->birth_certificate_approved)
                                                    <span class="text-success">
                                                        <i class="bx bx-check"></i> Documento aprobado
                                                    </span>
                                                @elseif($certificate->birth_certificate_file)
                                                    <span class="text-warning">
                                                        <i class="bx bx-time-five"></i> Pendiente de revision
                                                    </span>
                                                @else
                                                    <span class="text-danger">
                                                        <i class="bx bx-x"></i> No subido
                                                    </span>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @if ($certificate->birth_certificate_file)
                                                <a href="{{ $certificate->birth_certificate_file }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show"></i> Ver
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comprobante de Domicilio -->
                        <div class="document-item mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-start gap-3">
                                <!-- Icono de estado -->
                                <div class="flex-shrink-0">
                                    @if ($certificate->proof_of_address_approved)
                                        <div class="status-icon status-completed">
                                            <ion-icon name="checkmark-circle"
                                                style="font-size: 32px; color: #198754;"></ion-icon>
                                        </div>
                                    @else
                                        <div class="status-icon status-pending">
                                            <ion-icon name="ellipse-outline"
                                                style="font-size: 32px; color: #ffc107;"></ion-icon>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6
                                                class="mb-1 {{ $certificate->proof_of_address_approved ? 'text-success' : '' }}">
                                                Comprobante de Domicilio
                                            </h6>
                                            <small class="text-muted">
                                                @if ($certificate->proof_of_address_approved)
                                                    <span class="text-success">
                                                        <i class="bx bx-check"></i> Documento aprobado
                                                    </span>
                                                @elseif($certificate->proof_of_address_file)
                                                    <span class="text-warning">
                                                        <i class="bx bx-time-five"></i> Pendiente de revision
                                                    </span>
                                                @else
                                                    <span class="text-danger">
                                                        <i class="bx bx-x"></i> No subido
                                                    </span>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @if ($certificate->proof_of_address_file)
                                                <a href="{{ $certificate->proof_of_address_file }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show"></i> Ver
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fotografía -->
                        <div class="document-item">
                            <div class="d-flex align-items-start gap-3">
                                <!-- Icono de estado -->
                                <div class="flex-shrink-0">
                                    @if ($certificate->photo_approved)
                                        <div class="status-icon status-completed">
                                            <ion-icon name="checkmark-circle"
                                                style="font-size: 32px; color: #198754;"></ion-icon>
                                        </div>
                                    @else
                                        <div class="status-icon status-pending">
                                            <ion-icon name="ellipse-outline"
                                                style="font-size: 32px; color: #ffc107;"></ion-icon>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 {{ $certificate->photo_approved ? 'text-success' : '' }}">
                                                Fotografía
                                            </h6>
                                            <small class="text-muted">
                                                @if ($certificate->photo_approved)
                                                    <span class="text-success">
                                                        <i class="bx bx-check"></i> Documento aprobado
                                                    </span>
                                                @elseif($certificate->photo_file)
                                                    <span class="text-warning">
                                                        <i class="bx bx-time-five"></i> Pendiente de revision
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="bx bx-minus"></i> Opcional - No subido
                                                    </span>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @if ($certificate->photo_file)
                                                <a href="{{ $certificate->photo_file }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show"></i> Ver
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testigos -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0"><i class="bx bx-user-check"></i> Primer Testigo</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Nombre:</strong> {{ $certificate->first_witness_full_name }}</p>
                                <p><strong>Fecha de Nacimiento:</strong>
                                    {{ \Carbon\Carbon::parse($certificate->first_witness_birth_date)->format('d/m/Y') }}
                                </p>
                                <p><strong>Domicilio:</strong> {{ $certificate->first_witness_address }}</p>
                                @if ($certificate->first_witness_ine_file)
                                    <div class="d-flex align-items-center">
                                        <a href="{{ $certificate->first_witness_ine_file }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-download"></i> Ver INE
                                        </a>
                                        @if ($certificate->first_witness_ine_approved)
                                            <span class="badge bg-success ms-2"><i class="bx bx-check"></i>
                                                Aprobado</span>
                                        @else
                                            <span class="badge bg-warning ms-2">Pendiente</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0"><i class="bx bx-user-check"></i> Segundo Testigo</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Nombre:</strong> {{ $certificate->second_witness_full_name }}</p>
                                <p><strong>Fecha de Nacimiento:</strong>
                                    {{ \Carbon\Carbon::parse($certificate->second_witness_birth_date)->format('d/m/Y') }}
                                </p>
                                <p><strong>Domicilio:</strong> {{ $certificate->second_witness_address }}</p>
                                @if ($certificate->second_witness_ine_file)
                                    <div class="d-flex align-items-center">
                                        <a href="{{ $certificate->second_witness_ine_file }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-download"></i> Ver INE
                                        </a>
                                        @if ($certificate->second_witness_ine_approved)
                                            <span class="badge bg-success ms-2"><i class="bx bx-check"></i>
                                                Aprobado</span>
                                        @else
                                            <span class="badge bg-warning ms-2">Pendiente</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Informacion -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bx bx-info-circle"></i> Informacion</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Fecha de solicitud:</strong><br>{{ $certificate->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p><strong>Ultima
                                actualizacion:</strong><br>{{ $certificate->updated_at->format('d/m/Y H:i') }}</p>
                        @if ($certificate->admin_notes)
                            <hr>
                            <p><strong>Notas:</strong><br>{{ $certificate->admin_notes }}</p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('citizen.profile.identification_certificates') }}"
                    class="btn btn-outline-secondary w-100">
                    <i class="bx bx-arrow-back"></i> Volver al listado
                </a>
            </div>
        </div>
    @endif
</div>
