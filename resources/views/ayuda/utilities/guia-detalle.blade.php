<div>
    @php
        $isAdmin = $this->context === 'admin';
        $indexRoute = $isAdmin ? 'ayuda.admin.guias' : 'ayuda.front.index';
    @endphp

    {{-- Cover hero --}}
    <div class="rounded-4 mb-4 position-relative overflow-hidden"
        style="min-height:220px; background:#d9d9d9;">
        @if ($guia->imagen_portada)
            <img src="{{ \Storage::disk('s3')->url($guia->imagen_portada) }}"
                class="w-100 h-100 position-absolute" style="object-fit:cover; top:0; left:0;">
        @endif
        <div class="position-absolute bottom-0 start-0 end-0 p-4"
            style="background:linear-gradient(transparent,rgba(0,0,0,.55));">
            <h3 class="fw-bold text-white mb-2 text-uppercase">{{ $guia->titulo }}</h3>
            <div class="d-flex gap-3">
                <span class="d-flex align-items-center gap-1 text-white-50 small">
                    <span class="rounded-circle bg-secondary d-inline-block" style="width:16px;height:16px;"></span>
                    {{ $guia->dependencia ?? '—' }}
                </span>
                <span class="d-flex align-items-center gap-1 text-white-50 small">
                    <span class="rounded-circle bg-secondary d-inline-block" style="width:16px;height:16px;"></span>
                    {{ $guia->categoria?->nombre ?? '—' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Descripción --}}
    @if ($guia->descripcion)
        <div class="border rounded-3 p-3 mb-4 text-muted" style="border-style:dashed !important;">
            {{ $guia->descripcion }}
        </div>
    @endif

    @if ($total > 0)
        {{-- Step tabs --}}
        <div class="d-flex mb-0" style="gap:2px;">
            @foreach ($guia->pasos as $i => $p)
                <button type="button"
                    wire:click="goToStep({{ $i }})"
                    class="btn btn-sm flex-fill fw-semibold"
                    style="border-radius:{{ $i === 0 ? '8px 0 0 0' : ($i === $total-1 ? '0 8px 0 0' : '0') }};
                           background:{{ $currentStepIndex === $i ? '#b8d8f0' : '#e0e0e0' }};
                           border:none; color:{{ $currentStepIndex === $i ? '#1a5276' : '#666' }};">
                    {{ $i + 1 }}
                </button>
            @endforeach
        </div>

        {{-- Step content --}}
        @if ($paso)
            <div class="border rounded-3 p-4 mb-4" style="border-color:#ccc;">
                <div class="row g-4">
                    <div class="col-md-8">
                        {{-- Step number sidebar --}}
                        <div class="d-flex gap-3">
                            <div class="text-muted fw-bold" style="font-size:1.2rem; min-width:24px;">
                                {{ $currentStepIndex + 1 }}
                            </div>
                            <div class="flex-grow-1">
                                <p class="fw-semibold mb-1">{{ $paso->titulo }}</p>
                                <p class="text-muted small mb-3">{{ $paso->descripcion }}</p>

                                {{-- Enlace --}}
                                @if ($paso->enlace_url)
                                    <div class="rounded-3 p-2 mb-2 d-flex align-items-center gap-2"
                                        style="background:#d4edda;">
                                        <i class="bx bx-link text-success"></i>
                                        <a href="{{ $paso->enlace_url }}" target="_blank"
                                            class="text-success small fw-semibold text-decoration-none">
                                            {{ $paso->enlace_texto ?: $paso->enlace_url }}
                                        </a>
                                    </div>
                                @endif

                                {{-- Pregunta frecuente --}}
                                @if ($paso->pregunta_frecuente)
                                    <div class="rounded-3 p-2 mb-2"
                                        style="background:#fff3cd;">
                                        <small class="d-block">{{ $paso->pregunta_frecuente }}</small>
                                    </div>
                                @endif

                                {{-- Advertencia --}}
                                @if ($paso->mensaje_advertencia)
                                    <div class="rounded-3 p-2 mb-2"
                                        style="background:#f8d7da;">
                                        <small class="d-block">{{ $paso->mensaje_advertencia }}</small>
                                    </div>
                                @endif

                                {{-- Archivo --}}
                                @if ($paso->archivo_adjunto)
                                    <div class="rounded-3 p-2 mb-2"
                                        style="background:#cce5ff;">
                                        <a href="{{ \Storage::disk('s3')->url($paso->archivo_adjunto) }}"
                                            target="_blank" class="small text-primary text-decoration-none">
                                            <i class="bx bx-file"></i> Descargar archivo adjunto
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Step image --}}
                    @if ($paso->imagen_apoyo)
                        <div class="col-md-4">
                            <img src="{{ \Storage::disk('s3')->url($paso->imagen_apoyo) }}"
                                class="img-fluid rounded-3" alt="Imagen de apoyo">
                        </div>
                    @else
                        <div class="col-md-4">
                            <div class="rounded-3 bg-light d-flex align-items-center justify-content-center"
                                style="min-height:160px;">
                                <span class="text-muted small">Imagen de apoyo</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Navigation --}}
            <div class="d-flex gap-2 mb-5">
                @if ($currentStepIndex > 0)
                    <button type="button" wire:click="prevStep"
                        class="btn btn-sm btn-outline-secondary">
                        <i class="bx bx-chevron-left"></i> Anterior
                    </button>
                @endif
                @if ($currentStepIndex < $total - 1)
                    <button type="button" wire:click="nextStep"
                        class="btn fw-semibold flex-grow-1"
                        style="background:#4caf50; color:#fff; border:none; border-radius:8px; padding:12px;">
                        VER SIGUIENTE
                    </button>
                    <div class="btn btn-secondary" style="min-width:60px; text-align:center;">
                        {{ $currentStepIndex + 2 }}
                    </div>
                @else
                    <div class="btn btn-success flex-grow-1 disabled">Última etapa completada ✓</div>
                @endif
            </div>
        @endif
    @else
        <div class="text-center py-4 text-muted">Esta guía no tiene pasos aún.</div>
    @endif

    <div class="mb-3">
        <a href="{{ route($indexRoute) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-arrow-back"></i> Volver al listado
        </a>
    </div>
</div>
