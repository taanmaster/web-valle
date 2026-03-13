{{--
    Partial: actions-reviewer
    Visible solo para el colaborador asignado cuando el oficio está en revisión.
    Muestra la barra de progreso de validaciones y los tres botones de acción:
    Solicitar Corrección, Validar y Firmar.

    Variables heredadas del padre (scope @include):
        $document
--}}
@if($document->assigned_to == Auth::id() && $document->status == 'revision')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h5 class="mb-4"><i class="fas fa-tasks me-2"></i> Acciones Disponibles</h5>

        <!-- Barra de progreso de validaciones -->
        <div class="mb-4">
            <label class="form-label">Validaciones: {{ $document->validations_count }} (mínimo 2 requeridas)</label>
            <div class="progress validation-progress">
                <div class="progress-bar bg-{{ $document->canBeSigned() ? 'success' : 'primary' }}"
                     role="progressbar"
                     style="width: {{ min(($document->validations_count / 2) * 100, 100) }}%"
                     aria-valuenow="{{ $document->validations_count }}"
                     aria-valuemin="0"
                     aria-valuemax="2">
                    {{ $document->validations_count }}{{ $document->canBeSigned() ? ' ✓' : '' }}
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Solicitar Corrección -->
            <div class="col-md-4">
                <button type="button" class="btn btn-outline-danger w-100 py-3" data-bs-toggle="modal" data-bs-target="#correctionModal">
                    <i class="fas fa-undo fa-2x d-block mb-2"></i>
                    Solicitar Corrección
                </button>
            </div>

            <!-- Validar -->
            @if(!$document->hasBeenValidatedBy(Auth::id()) && $document->user_id != Auth::id())
                <div class="col-md-4">
                    <button type="button" class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#validateModal">
                        <i class="fas fa-check-circle fa-2x d-block mb-2"></i>
                        Validar
                    </button>
                </div>
            @else
                <div class="col-md-4">
                    <button type="button" class="btn btn-secondary w-100 py-3" disabled>
                        <i class="fas fa-check-circle fa-2x d-block mb-2"></i>
                        @if($document->user_id == Auth::id())
                            No puedes validar tu oficio
                        @else
                            Ya validaste
                        @endif
                    </button>
                </div>
            @endif

            <!-- Firmar -->
            <div class="col-md-4">
                @if($document->canBeSigned())
                    <button type="button" class="btn btn-outline-success w-100 py-3" id="initSignBtn">
                        <i class="fas fa-signature fa-2x d-block mb-2"></i>
                        Firmar
                    </button>
                @else
                    <button type="button" class="btn btn-secondary w-100 py-3" disabled>
                        <i class="fas fa-lock fa-2x d-block mb-2"></i>
                        Firmar (Requiere mín. 2 validaciones)
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
