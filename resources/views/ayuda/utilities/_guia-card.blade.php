<a href="{{ route($showRoute, $guia->slug) }}" class="text-decoration-none text-dark">
    <div class="card border-0 shadow-sm h-100" style="border-radius:14px; overflow:hidden;">
        <div style="height:180px; background:#d9d9d9; overflow:hidden;">
            @if ($guia->imagen_portada)
                <img src="{{ \Storage::disk('s3')->url($guia->imagen_portada) }}"
                    class="w-100 h-100" style="object-fit:cover;" alt="{{ $guia->titulo }}">
            @endif
        </div>
        <div class="card-body p-3">
            <small class="text-muted d-block mb-1">
                {{ ($guia->fecha_entrada ?? $guia->created_at)->translatedFormat('M d, Y') }}
            </small>
            <h6 class="fw-bold mb-1">{{ $guia->titulo }}</h6>
            <p class="text-muted small mb-2"
                style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                {{ $guia->descripcion }}
            </p>
            <div class="d-flex align-items-center gap-2 mt-auto">
                <div class="rounded-circle bg-secondary" style="width:24px;height:24px;flex-shrink:0;"></div>
                <small class="text-muted">{{ $guia->categoria?->nombre ?? '—' }}</small>
            </div>
        </div>
    </div>
</a>
