{{--
    Partial: sidebar
    Panel lateral derecho (col-lg-4) con:
      - Card de estado del oficio
      - Lista de validaciones
      - Control de versiones (últimas 5)
      - Acciones rápidas (PDF, editar, historial, volver)

    Variables heredadas del padre (scope @include):
        $document
--}}
<div class="col-lg-4">

    <!-- Información del Estado -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Estado del Oficio</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span>Estado:</span>
                {!! $document->status_badge !!}
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span>Validaciones:</span>
                <span class="badge bg-{{ $document->validations_count >= 2 ? 'success' : 'secondary' }}">
                    {{ $document->validations_count }} (mín. 2)
                </span>
            </div>
            @if($document->assigned_to)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Asignado a:</span>
                    <strong>{{ $document->assignedUser->name ?? '-' }}</strong>
                </div>
            @endif
            @if($document->assignment_message)
                <hr>
                <small class="text-muted d-block">Mensaje:</small>
                <p class="mb-0 small">{{ $document->assignment_message }}</p>
            @endif
        </div>
    </div>

    <!-- Validaciones -->
    @if($document->validations->count() > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-check-double me-2"></i> Validaciones</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($document->validations as $validation)
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <div>
                                    <strong>{{ $validation->validator->name ?? 'Usuario' }}</strong>
                                    <small class="text-muted d-block">{{ $validation->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Control de Versiones -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-history me-2"></i> Control de Versiones</h6>
            <div>
                <a href="{{ route('backoffice.documents.versions', $document->id) }}" class="btn btn-sm btn-outline-primary">
                    Ver Todas
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @foreach($document->versions->take(5) as $version)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                {!! $version->activity_type_badge !!}
                                <small class="text-muted d-block mt-1">
                                    {{ $version->modifiedByUser->name ?? 'Sistema' }}
                                </small>
                            </div>
                            <small class="text-muted">{{ $version->created_at->format('d/m H:i') }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-bolt me-2"></i> Acciones</h6>
        </div>
        <div class="card-body">
            <div class="d-grid gap-2">
                @if($document->status == 'firmado')
                    @php
                        $downloadUrl = $document->efirma_merged_file
                            ? $document->efirma_merged_file
                            : route('backoffice.documents.pdf', $document->id);
                    @endphp
                    <a href="{{ $downloadUrl }}"
                       class="btn btn-danger"
                       target="_blank">
                        <i class="fas fa-file-pdf me-2"></i> Descargar Oficio
                    </a>
                @endif
                @if($document->user_id == Auth::id() && $document->status == 'borrador')
                    <a href="{{ route('backoffice.documents.edit', $document->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i> Editar Oficio
                    </a>
                @endif
                <a href="{{ route('backoffice.documents.versions', $document->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-history me-2"></i> Ver Historial
                </a>
                <a href="{{ route('backoffice.documents.index') }}" class="btn btn-outline-dark">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                </a>
            </div>
        </div>
    </div>

</div>
