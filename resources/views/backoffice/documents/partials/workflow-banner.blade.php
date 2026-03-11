{{--
    Partial: workflow-banner
    Muestra el stepper visual del flujo (Borrador → Revisión → Validaciones → Firmado → Enviado)
    y la sección de Avisos y Notificaciones según el estado y el rol del usuario actual.

    Variables heredadas del padre (scope @include):
        $document, $lastCorrectionRequest, $isCreatorViewing, $isAssignedViewing
--}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <!-- Flujo de Trabajo -->
        <div class="row align-items-center mb-4">
            <div class="col-12">
                <h6 class="text-muted mb-3"><i class="fas fa-stream me-2"></i> Flujo del Oficio</h6>
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

                    <!-- Paso 1: Borrador -->
                    <div class="text-center flex-fill">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->status == 'borrador' ? 'bg-warning' : 'bg-success' }}" style="width: 50px; height: 50px;">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                        <small class="d-block mt-2 {{ $document->status == 'borrador' ? 'fw-bold text-warning' : 'text-success' }}">Borrador</small>
                    </div>

                    <div class="text-muted"><i class="fas fa-arrow-right"></i></div>

                    <!-- Paso 2: En Revisión -->
                    <div class="text-center flex-fill">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->status == 'revision' ? 'bg-info' : ($document->status == 'borrador' ? 'bg-secondary' : 'bg-success') }}" style="width: 50px; height: 50px;">
                            <i class="fas fa-search text-white"></i>
                        </div>
                        <small class="d-block mt-2 {{ $document->status == 'revision' ? 'fw-bold text-info' : ($document->status == 'borrador' ? 'text-muted' : 'text-success') }}">En Revisión</small>
                    </div>

                    <div class="text-muted"><i class="fas fa-arrow-right"></i></div>

                    <!-- Paso 3: Validaciones -->
                    <div class="text-center flex-fill">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->validations_count >= 2 ? 'bg-success' : ($document->status == 'revision' ? 'bg-primary' : 'bg-secondary') }}" style="width: 50px; height: 50px;">
                            <span class="text-white fw-bold">{{ $document->validations_count }}{{ $document->validations_count >= 2 ? '✓' : '' }}</span>
                        </div>
                        <small class="d-block mt-2 {{ $document->validations_count >= 2 ? 'text-success fw-bold' : ($document->status == 'revision' ? 'text-primary' : 'text-muted') }}">Validaciones (mín. 2)</small>
                    </div>

                    <div class="text-muted"><i class="fas fa-arrow-right"></i></div>

                    <!-- Paso 4: Firmado -->
                    <div class="text-center flex-fill">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->status == 'firmado' ? ($document->sent_to_user_id ? 'bg-success' : 'bg-warning') : 'bg-secondary' }}" style="width: 50px; height: 50px;">
                            <i class="fas fa-signature text-white"></i>
                        </div>
                        <small class="d-block mt-2 {{ $document->status == 'firmado' ? ($document->sent_to_user_id ? 'text-success' : 'fw-bold text-warning') : 'text-muted' }}">Firmado</small>
                    </div>

                    <div class="text-muted"><i class="fas fa-arrow-right"></i></div>

                    <!-- Paso 5: Enviado -->
                    <div class="text-center flex-fill">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->sent_to_user_id ? 'bg-success' : 'bg-secondary' }}" style="width: 50px; height: 50px;">
                            <i class="fas fa-paper-plane text-white"></i>
                        </div>
                        <small class="d-block mt-2 {{ $document->sent_to_user_id ? 'fw-bold text-success' : 'text-muted' }}">Enviado</small>
                    </div>

                </div>
            </div>
        </div>

        <hr>

        <!-- Avisos Importantes -->
        <div class="row">
            <div class="col-12">
                <h6 class="text-muted mb-3"><i class="fas fa-bell me-2"></i> Avisos y Notificaciones</h6>

                @if($document->status == 'firmado' && $document->sent_to_user_id)
                    <div class="alert alert-success mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-double fa-lg me-3"></i>
                            <div>
                                <strong>Oficio Enviado</strong><br>
                                <small>Este oficio ha sido firmado y enviado a <strong>{{ $document->sentToUser->name ?? 'Destinatario' }}</strong> el {{ $document->sent_at ? $document->sent_at->format('d/m/Y H:i') : '' }}.</small>
                            </div>
                        </div>
                    </div>
                @elseif($document->status == 'firmado' && !$document->sent_to_user_id)
                    <div class="alert alert-warning mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-paper-plane fa-lg me-3"></i>
                            <div>
                                <strong>Pendiente de Envío</strong><br>
                                <small>Este oficio ha sido firmado. Falta enviarlo a un contacto de la dependencia destino.</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if($lastCorrectionRequest && $document->status == 'borrador' && $isCreatorViewing)
                    <div class="alert alert-warning mb-2">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle fa-lg me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <strong>Corrección Solicitada</strong><br>
                                <small class="text-muted">Por {{ $lastCorrectionRequest->modifiedByUser->name ?? 'Usuario' }} - {{ $lastCorrectionRequest->created_at->format('d/m/Y H:i') }}</small>
                                <p class="mb-0 mt-2">{{ Str::limit($lastCorrectionRequest->activity_detail, 200) }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($document->status == 'borrador' && $isCreatorViewing && !$lastCorrectionRequest)
                    <div class="alert alert-info mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-lg me-3"></i>
                            <div>
                                <strong>Oficio en Borrador</strong><br>
                                <small>Puedes editar este oficio. Cuando esté listo, envíalo para revisión a un colaborador de tu dependencia.</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if($document->status == 'revision' && $isAssignedViewing)
                    <div class="alert alert-primary mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-tasks fa-lg me-3"></i>
                            <div>
                                <strong>Pendiente de tu Revisión</strong><br>
                                <small>Este oficio te fue asignado para revisión. Puedes validarlo, solicitar correcciones o firmarlo (si tiene 3 validaciones).</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if($document->status == 'revision' && $isCreatorViewing && !$isAssignedViewing)
                    <div class="alert alert-secondary mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hourglass-half fa-lg me-3"></i>
                            <div>
                                <strong>En Revisión por {{ $document->assignedUser->name ?? 'Colaborador' }}</strong><br>
                                <small>Tu oficio está siendo revisado. Recibirás una notificación cuando sea validado o si se solicitan correcciones.</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if($document->canBeSigned() && $isAssignedViewing)
                    <div class="alert alert-success mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-pen-fancy fa-lg me-3"></i>
                            <div>
                                <strong>¡Listo para Firmar!</strong><br>
                                <small>Este oficio ha alcanzado las validaciones mínimas requeridas (2). Ya puedes proceder a firmarlo.</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if($document->validations->count() == 0 && $document->status != 'borrador' && $document->status != 'firmado')
                    <div class="alert alert-light border mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock fa-lg me-3 text-muted"></i>
                            <div>
                                <strong class="text-muted">Sin Validaciones Aún</strong><br>
                                <small class="text-muted">Este oficio aún no ha recibido validaciones. Se requieren mínimo 2 para poder firmarse.</small>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
