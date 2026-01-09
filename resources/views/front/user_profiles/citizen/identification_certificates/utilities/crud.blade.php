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
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bx bx-info-circle"></i> Todos los documentos deben ser legibles y en formato PDF, JPG
                        o PNG. Tamano maximo: 5MB por archivo.
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="birth_certificate_file" class="form-label">Acta de Nacimiento <span
                                    class="text-danger">*</span></label>
                            <input type="file" wire:model="birth_certificate_file" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <div wire:loading wire:target="birth_certificate_file" class="text-info mt-1">
                                <i class="bx bx-loader-alt bx-spin"></i> Subiendo...
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="proof_of_address_file" class="form-label">Comprobante de Domicilio <span
                                    class="text-danger">*</span></label>
                            <input type="file" wire:model="proof_of_address_file" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="text-muted">No mayor a 3 meses de antiguedad</small>
                            <div wire:loading wire:target="proof_of_address_file" class="text-info mt-1">
                                <i class="bx bx-loader-alt bx-spin"></i> Subiendo...
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="photo_file" class="form-label">Fotografia</label>
                            <input type="file" wire:model="photo_file" class="form-control"
                                accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Foto reciente, fondo blanco (opcional)</small>
                            <div wire:loading wire:target="photo_file" class="text-info mt-1">
                                <i class="bx bx-loader-alt bx-spin"></i> Subiendo...
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
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Acta de Nacimiento</label>
                                @if ($certificate->birth_certificate_file)
                                    <div class="d-flex align-items-center">
                                        <a href="{{ $certificate->birth_certificate_file }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-download"></i> Ver
                                        </a>
                                        @if ($certificate->birth_certificate_approved)
                                            <span class="badge bg-success ms-2"><i class="bx bx-check"></i>
                                                Aprobado</span>
                                        @else
                                            <span class="badge bg-warning ms-2">Pendiente</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Comprobante de Domicilio</label>
                                @if ($certificate->proof_of_address_file)
                                    <div class="d-flex align-items-center">
                                        <a href="{{ $certificate->proof_of_address_file }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-download"></i> Ver
                                        </a>
                                        @if ($certificate->proof_of_address_approved)
                                            <span class="badge bg-success ms-2"><i class="bx bx-check"></i>
                                                Aprobado</span>
                                        @else
                                            <span class="badge bg-warning ms-2">Pendiente</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Fotografia</label>
                                @if ($certificate->photo_file)
                                    <div class="d-flex align-items-center">
                                        <a href="{{ $certificate->photo_file }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-download"></i> Ver
                                        </a>
                                        @if ($certificate->photo_approved)
                                            <span class="badge bg-success ms-2"><i class="bx bx-check"></i>
                                                Aprobado</span>
                                        @else
                                            <span class="badge bg-warning ms-2">Pendiente</span>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-muted">No subida</p>
                                @endif
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
