@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4 justify-content-center">
        <div class="col-lg-9">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('front.regulatory_impact.index') }}">Impacto Regulatorio</a></li>
                    <li class="breadcrumb-item active">{{ $record->folio }}</li>
                </ol>
            </nav>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Card encabezado --}}
            <div class="card card-normal wow fadeInUp mb-4">
                <div class="card-body w-100">
                    <div class="d-flex align-items-start w-100 justify-content-between">
                        <div>
                            <span class="badge bg-secondary fs-6 fw-bold">{{ $record->folio }}</span>
                            <div class="mt-4">
                                <h4 class="fw-bold mb-1">{{ $record->titulo_regulacion }}</h4>
                                <p class="text-muted mb-0 small">Solicitud de Exención de AIR · {{ $record->dependency->name ?? '' }}</p>
                            </div>
                        </div>
                        
                        <span class="ms-auto badge bg-{{ $record->dictamen_badge_class }} align-self-start">
                            {{ ucfirst($record->dictamen_status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Formato de Solicitud --}}
            <div class="card card-normal wow fadeInUp mb-4">
                <div class="card-body w-100">
                    <h5 class="fw-bold mb-3">
                        <ion-icon name="document-outline" class="me-2"></ion-icon> Formato de Solicitud
                    </h5>

                    @if($record->formato_solicitud_s3_url)
                        <object data="{{ $record->formato_solicitud_s3_url }}" type="application/pdf"
                                width="100%" style="height: 720px; border-radius: .5rem;">
                            <div class="alert alert-secondary d-flex align-items-center gap-3">
                                <ion-icon name="document-outline" style="font-size:2rem;"></ion-icon>
                                <div>
                                    <p class="mb-2">Tu navegador no puede mostrar el PDF directamente.</p>
                                    <a href="{{ $record->formato_solicitud_s3_url }}" target="_blank"
                                       class="btn btn-secondary btn-sm">
                                        <i class="fas fa-file-download me-1"></i> Descargar Formato de Solicitud
                                    </a>
                                </div>
                            </div>
                        </object>

                        <div class="mt-3 d-flex gap-2 flex-wrap">
                            <a href="{{ $record->formato_solicitud_s3_url }}" target="_blank"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i> Abrir en nueva pestaña
                            </a>
                            @if($record->dictamen_s3_url)
                                <a href="{{ $record->dictamen_s3_url }}" target="_blank"
                                   class="btn btn-outline-dark btn-sm">
                                    <i class="fas fa-gavel me-1"></i> Dictamen Final
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <ion-icon name="document-outline" style="font-size:3rem;"></ion-icon>
                            <p class="mt-2">El formato de solicitud aún no está disponible.</p>
                        </div>

                        @if($record->dictamen_s3_url)
                            <div class="text-center">
                                <a href="{{ $record->dictamen_s3_url }}" target="_blank"
                                   class="btn btn-outline-dark btn-sm">
                                    <i class="fas fa-gavel me-1"></i> Dictamen Final
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Consulta Pública --}}
            <div class="card card-normal wow fadeInUp mb-4" id="consulta-publica">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <ion-icon name="chatbubbles-outline" class="me-2"></ion-icon> Consulta Pública
                    </h5>

                    @forelse($publicComments as $comment)
                        <div class="d-flex gap-3 mb-3 p-3 bg-light rounded">
                            <div class="flex-shrink-0">
                                <ion-icon name="person-circle-outline" style="font-size:2rem;color:#198754;"></ion-icon>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="small text-success">Ciudadano</strong>
                                    <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <p class="mb-0 small" style="white-space:pre-line;">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted fst-italic small">Aún no hay comentarios públicos. ¡Sé el primero!</p>
                    @endforelse

                    <hr>
                    @if($hasCommented)
                        <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                            <ion-icon name="checkmark-circle-outline" style="font-size:1.5rem;"></ion-icon>
                            <span>Ya dejaste un comentario en este registro.</span>
                        </div>
                    @else
                        <h6 class="fw-bold mb-3">Deja tu comentario</h6>
                        <form action="{{ route('front.regulatory_impact.public_comment', $record->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="content" rows="3"
                                          class="form-control @error('content') is-invalid @enderror"
                                          placeholder="Escribe tu comentario u observación...">{{ old('content') }}</textarea>
                                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Captcha <span class="text-danger">*</span></label>
                                <div class="captcha d-flex align-items-center gap-2 mb-2">
                                    <span>{!! captcha_img('flat') !!}</span>
                                    <button type="button" class="btn btn-danger btn-sm reload">&#x21bb; Cambiar captcha</button>
                                </div>
                                <input type="text"
                                       class="form-control @error('captcha') is-invalid @enderror"
                                       name="captcha"
                                       placeholder="Escribe los caracteres del captcha"
                                       required>
                                @error('captcha')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">
                                <ion-icon name="send-outline" class="me-1"></ion-icon> Enviar comentario
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <a href="{{ route('front.regulatory_impact.index') }}" class="btn btn-outline-secondary">
                    <ion-icon name="arrow-back-outline" class="me-1"></ion-icon> Volver al listado
                </a>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<!-- Captcha Reload -->
<script>
    $('.reload').on('click', function(){
        event.preventDefault();
        $.ajax({
            type: 'GET',
            url: "{{ route('reload.captcha') }}",
            success: function(response){
                $('.captcha span').html(response.captcha);
            }
        });
    });
</script>
@endpush
@endsection
