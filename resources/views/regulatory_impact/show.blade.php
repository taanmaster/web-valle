@extends('layouts.master')
@section('title') {{ $regulatoryImpact->folio }} @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Desarrollo Institucional @endslot
        @slot('li_3') <a href="{{ route('institucional_development.regulatory_impact.index') }}">Impacto Regulatorio</a> @endslot
        @slot('title') {{ $regulatoryImpact->folio }} @endslot
    @endcomponent

    <div class="container-fluid py-4">

        @php $dictamenFinal = in_array($regulatoryImpact->dictamen_status, ['aprobado', 'rechazado']); @endphp

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-lock me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">

            {{-- ============================================================ --}}
            {{-- COL PRINCIPAL (8) --}}
            {{-- ============================================================ --}}
            <div class="col-lg-8">

                {{-- Card principal con datos del formulario --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header {{ $regulatoryImpact->isAir() ? 'bg-warning' : 'bg-secondary' }} text-{{ $regulatoryImpact->isAir() ? 'dark' : 'white' }} d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-{{ $regulatoryImpact->isAir() ? 'file-alt' : 'file-excel' }} fa-lg me-3"></i>
                            <div>
                                <h5 class="mb-0 fw-bold">{{ $regulatoryImpact->type_label }}</h5>
                                <small class="opacity-75">Folio: <strong>{{ $regulatoryImpact->folio }}</strong></small>
                            </div>
                        </div>
                        @unless($dictamenFinal)
                        <div class="text-end">
                            <a href="{{ route('institucional_development.regulatory_impact.edit', $regulatoryImpact) }}"
                            class="btn btn-sm btn-light">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                        </div>
                        
                        @endunless
                    </div>
                    <div class="card-body p-4">

                        @if($regulatoryImpact->isAir())
                            {{-- Campos AIR --}}
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <small class="text-muted d-block">Nombre de la Propuesta Regulatoria</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->nombre_propuesta ?? '—' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Fecha de Vigencia</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->fecha_vigencia ? $regulatoryImpact->fecha_vigencia->format('d/m/Y') : '—' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Autoridad o autoridades que la emiten</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->autoridad_emisora ?? '—' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Dependencia que la aplica</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->dependency->name ?? '—' }}</p>
                                </div>
                            </div>

                            <h6 class="border-bottom pb-2 mb-3 mt-4 text-muted">Detalles de la Regulación</h6>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <small class="text-muted d-block">Objeto del Programa</small>
                                    <p class="mb-0">{{ $regulatoryImpact->objeto_programa ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Tipo de Ordenamiento</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->tipo_ordenamiento ?? '—' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Materias Reguladas</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->materias_reguladas ?? '—' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Sectores Regulados</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->sectores_regulados ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <small class="text-muted d-block">Sujetos Regulados</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->sujetos_regulados ?? '—' }}</p>
                                </div>
                            </div>

                            <h6 class="border-bottom pb-2 mb-3 mt-4 text-muted">Contenido</h6>
                            <div class="mb-3">
                                <small class="text-muted d-block">Índice de la Regulación</small>
                                <p class="mb-0" style="white-space: pre-line;">{{ $regulatoryImpact->indice_regulacion ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Trámites y servicios relacionados con la regulación</small>
                                <p class="mb-0" style="white-space: pre-line;">{{ $regulatoryImpact->tramites_relacionados ?? '—' }}</p>
                            </div>

                        @else
                            {{-- Campos Exención --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Dependencia que la aplica</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->dependency->name ?? '—' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Fecha de Envío</small>
                                    <p class="fw-semibold mb-0">{{ $regulatoryImpact->fecha_envio ? $regulatoryImpact->fecha_envio->format('d/m/Y') : '—' }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Título de la Regulación</small>
                                <p class="fw-semibold mb-0">{{ $regulatoryImpact->titulo_regulacion ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Nombre y Cargo</small>
                                <p class="fw-semibold mb-0">{{ $regulatoryImpact->nombre_cargo ?? '—' }}</p>
                            </div>
                        @endif

                        {{-- Formato de Solicitud --}}
                        <h6 class="border-bottom pb-2 mb-3 mt-4 text-muted">Formato de Solicitud</h6>
                        @if($regulatoryImpact->formato_solicitud_s3_url)
                            <a href="{{ $regulatoryImpact->formato_solicitud_s3_url }}" target="_blank"
                               class="btn btn-outline-info">
                                <i class="fas fa-file-download me-2"></i> Ver Documento Adjunto
                            </a>
                        @else
                            <p class="text-muted fst-italic mb-0">No se ha adjuntado ningún formato.</p>
                        @endif

                    </div>
                </div>

                {{-- ======================================================== --}}
                {{-- Observaciones internas (admin) --}}
                {{-- ======================================================== --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-comments me-2 text-primary"></i> Observaciones
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @hasanyrole('des_Institucional|all')
                        <form action="{{ route('institucional_development.regulatory_impact.comment', $regulatoryImpact) }}"
                              method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="content" rows="3" class="form-control @error('content') is-invalid @enderror"
                                          placeholder="Deja un comentario...">{{ old('content') }}</textarea>
                                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-sm px-4">
                                    <i class="fas fa-paper-plane me-1"></i> Publicar
                                </button>
                            </div>
                        </form>
                        @endhasanyrole

                        @if($adminComments->count() > 0)
                            <hr>
                            <div class="d-flex flex-column gap-3 mt-3">
                                @foreach($adminComments as $comment)
                                    <div class="d-flex gap-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 flex-shrink-0" style="width:40px;height:40px;display:flex!important;align-items:center;justify-content:center;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong class="small">{{ $comment->user->name ?? 'Usuario' }}</strong>
                                                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            <p class="mb-0 small" style="white-space:pre-line;">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted fst-italic small mt-3 mb-0">Aún no hay observaciones.</p>
                        @endif
                    </div>
                </div>

                {{-- ======================================================== --}}
                {{-- Consulta Pública (comentarios ciudadanos) --}}
                {{-- ======================================================== --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-users me-2 text-success"></i> Consulta Pública
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @if($publicComments->count() > 0)
                            <div class="d-flex flex-column gap-3">
                                @foreach($publicComments as $comment)
                                    <div class="d-flex gap-3 p-3 bg-light rounded">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-user-circle fa-2x text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong class="small text-success">Comentario ciudadano</strong>
                                                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            <p class="mb-0 small" style="white-space:pre-line;">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted fst-italic small mb-0">No hay comentarios ciudadanos en este registro.</p>
                        @endif
                    </div>
                </div>

            </div>{{-- /col-lg-8 --}}

            {{-- ============================================================ --}}
            {{-- SIDEBAR (4) --}}
            {{-- ============================================================ --}}
            <div class="col-lg-4">

                {{-- Resumen --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Resumen</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Tipo</small>
                            <span class="badge bg-{{ $regulatoryImpact->isAir() ? 'warning text-dark' : 'secondary' }} fs-6">
                                {{ $regulatoryImpact->isAir() ? 'AIR' : 'Exención' }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Dependencia Solicitante</small>
                            <strong>{{ $regulatoryImpact->dependency->name ?? '—' }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Creado por</small>
                            <strong>{{ $regulatoryImpact->user->name ?? '—' }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Fecha de registro</small>
                            <strong>{{ $regulatoryImpact->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Dictamen</small>
                            <span class="badge bg-{{ $regulatoryImpact->dictamen_badge_class }} fs-6">
                                {{ ucfirst($regulatoryImpact->dictamen_status) }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Visible en front</small>
                            @if($regulatoryImpact->show_in_front)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </div>
                        @if($regulatoryImpact->dictamen_s3_url)
                            <div>
                                <small class="text-muted d-block">Dictamen Final</small>
                                <a href="{{ $regulatoryImpact->dictamen_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                    <i class="fas fa-file-download me-1"></i> Descargar
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Card Dictamen (solo roles: des_Institucional, all) --}}
                @hasanyrole('des_Institucional|all')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header {{ $dictamenFinal ? ($regulatoryImpact->dictamen_status === 'aprobado' ? 'bg-success' : 'bg-danger') : 'bg-dark' }} text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-gavel me-2"></i> Dictamen</h6>
                        @if($dictamenFinal)
                            <span class="badge bg-white {{ $regulatoryImpact->dictamen_status === 'aprobado' ? 'text-success' : 'text-danger' }} small">
                                <i class="fas fa-lock me-1"></i> Resolución final
                            </span>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        @if($dictamenFinal)
                            {{-- Vista bloqueada: dictamen ya resuelto --}}
                            <div class="alert {{ $regulatoryImpact->dictamen_status === 'aprobado' ? 'alert-success' : 'alert-danger' }} d-flex align-items-center gap-2 mb-3">
                                <i class="fas fa-{{ $regulatoryImpact->dictamen_status === 'aprobado' ? 'check-circle' : 'times-circle' }} fa-lg"></i>
                                <div>
                                    <strong>Dictamen {{ $regulatoryImpact->dictamen_status === 'aprobado' ? 'Aprobado' : 'Rechazado' }}</strong><br>
                                    <small>Este registro ya tiene una resolución final y no puede modificarse.</small>
                                </div>
                            </div>

                            {{-- Toggle show_in_front siempre editable --}}
                            <form action="{{ route('institucional_development.regulatory_impact.dictamen', $regulatoryImpact) }}"
                                  method="POST" class="mb-3">
                                @csrf
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="show_in_front" id="show_in_front"
                                           value="1" {{ $regulatoryImpact->show_in_front ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="form-check-label fw-semibold small" for="show_in_front">
                                        Mostrar en el Front <span class="text-muted fw-normal">(visible para ciudadanos)</span>
                                    </label>
                                </div>
                            </form>

                            @if($regulatoryImpact->dictamen_s3_url)
                                <div>
                                    <small class="text-muted d-block mb-1">Documento de Dictamen</small>
                                    <a href="{{ $regulatoryImpact->dictamen_s3_url }}" target="_blank"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-file-download me-1"></i> Descargar Dictamen
                                    </a>
                                </div>
                            @endif
                        @else
                            {{-- Formulario activo: dictamen pendiente --}}
                            <form action="{{ route('institucional_development.regulatory_impact.dictamen', $regulatoryImpact) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Switch mostrar en front --}}
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="show_in_front" id="show_in_front"
                                               value="1" {{ $regulatoryImpact->show_in_front ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold small" for="show_in_front">
                                            Mostrar en el Front <span class="text-muted fw-normal">(visible para ciudadanos)</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Status del dictamen --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Resultado del Dictamen <span class="text-danger">*</span></label>
                                    <select name="dictamen_status" class="form-select form-select-sm" required>
                                        <option value="pendiente" {{ $regulatoryImpact->dictamen_status === 'pendiente' ? 'selected' : '' }}>
                                            ⏳ Pendiente
                                        </option>
                                        <option value="rechazado" {{ $regulatoryImpact->dictamen_status === 'rechazado' ? 'selected' : '' }}>
                                            ✗ Rechazar
                                        </option>
                                        <option value="aprobado" {{ $regulatoryImpact->dictamen_status === 'aprobado' ? 'selected' : '' }}>
                                            ✓ Aprobar
                                        </option>
                                    </select>
                                </div>

                                {{-- Adjunto dictamen --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Adjunto de Dictamen Final</label>
                                    @if($regulatoryImpact->dictamen_s3_url)
                                        <div class="alert alert-secondary py-2 px-3 mb-2 small">
                                            <i class="fas fa-file me-1"></i> Ya existe un dictamen adjunto.
                                            <a href="{{ $regulatoryImpact->dictamen_s3_url }}" target="_blank" class="ms-1">Ver</a>
                                        </div>
                                    @endif
                                    <input type="file" name="dictamen_file" accept=".pdf,.doc,.docx"
                                           class="form-control form-control-sm">
                                    <div class="form-text">PDF, DOC o DOCX. Máx 10 MB.</div>
                                </div>

                                <button type="submit" class="btn btn-dark btn-sm w-100">
                                    <i class="fas fa-save me-2"></i> Guardar Dictamen
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endhasanyrole

                {{-- Botones de navegación --}}
                <div class="d-grid gap-2">
                    @unless($dictamenFinal)
                    <a href="{{ route('institucional_development.regulatory_impact.edit', $regulatoryImpact) }}"
                       class="btn btn-{{ $regulatoryImpact->isAir() ? 'warning text-dark' : 'secondary' }}">
                        <i class="fas fa-edit me-2"></i> Editar Registro
                    </a>
                    @endunless
                    <a href="{{ route('institucional_development.regulatory_impact.index') }}"
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                    </a>
                    <form action="{{ route('institucional_development.regulatory_impact.destroy', $regulatoryImpact) }}"
                          method="POST" onsubmit="return confirm('¿Eliminar este registro permanentemente?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i> Eliminar
                        </button>
                    </form>
                </div>

            </div>{{-- /col-lg-4 --}}

        </div>
    </div>
@endsection
