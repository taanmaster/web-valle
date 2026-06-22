<div>
    @php
        $isAdmin = $this->context === 'admin';
        $showRoute = $isAdmin ? 'ayuda.admin.guia.show' : 'ayuda.front.show';
    @endphp

    {{-- Hero --}}
    <div class="rounded-4 p-5 mb-4 text-center"
        style="background: grey; min-height: 160px; display:flex; flex-direction:column; justify-content:center;">
        <small class="opacity-75 mb-1 text-white">Bienvenidos al</small>
        <h3 class="fw-bold mb-0 text-white">Módulo de ayuda y guía para<br>ciudadanos y servidores públicos</h3>
    </div>

    <p class="text-center text-muted mb-4" style="max-width:680px; margin:auto;">
        Este módulo ha sido diseñado para brindar una experiencia sencilla y accesible que ayude a ciudadanos y
        servidores públicos a comprender cómo realizar trámites, servicios, pagos, citas y distintos procesos
        municipales de manera digital.
    </p>

    {{-- Filtros --}}
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-center mb-4">
        <span class="fw-semibold text-muted me-1">Filtrar por</span>
        <select class="form-select form-select-sm rounded-pill" style="width:auto;" wire:model.live="filter_dependencia">
            <option value="">DEPENDENCIA</option>
            @foreach ($dependencias as $dep)
                <option value="{{ $dep->name }}">{{ $dep->name }}</option>
            @endforeach
        </select>
        <input type="text" class="form-control form-control-sm rounded-pill" style="width:180px;"
            placeholder="TÍTULO" wire:model.live="filter_titulo">
    </div>

    {{-- Categorías --}}
    <div class="mb-5">
        <h6 class="fw-bold mb-3">Categorías</h6>
        <div class="d-flex flex-wrap gap-2">
            @foreach ($categorias as $cat)
                <button type="button" wire:click="setCategoria({{ $cat->id }})"
                    class="btn btn-sm rounded-pill px-3 fw-semibold text-uppercase"
                    style="background: {{ $filter_categoria == $cat->id ? '#2d3a8c' : '#e8eaff' }};
                           color: {{ $filter_categoria == $cat->id ? '#fff' : '#2d3a8c' }};">
                    {{ $cat->nombre }}
                </button>
            @endforeach
            @if ($filter_categoria || $filter_dependencia || $filter_titulo)
                <button type="button"
                    wire:click="$set('filter_categoria','');$set('filter_dependencia','');$set('filter_titulo','')"
                    class="btn btn-sm btn-link text-danger p-0 ms-2">
                    Limpiar
                </button>
            @endif
        </div>
    </div>

    {{-- Guías destacadas --}}
    @if ($destacadas->count() > 0)
        <h5 class="fw-bold mb-1" style="color:#2d3a8c;">Consulta nuestras guías destacadas</h5>
        <hr style="border-color:#2d3a8c; border-width:2px; opacity:1;" class="mb-4">

        <div class="row g-3 mb-5">
            @foreach ($destacadas as $guia)
                <div class="col-md-6">
                    @include('ayuda.utilities._guia-card', ['guia' => $guia, 'showRoute' => $showRoute])
                </div>
            @endforeach
        </div>
    @endif

    {{-- Guías recientes --}}
    @if ($recientes->count() > 0)
        <h5 class="fw-bold mb-1" style="color:#2d3a8c;">Consulta nuestras guías recientes</h5>
        <hr style="border-color:#2d3a8c; border-width:2px; opacity:1;" class="mb-4">

        <div class="row g-3">
            @foreach ($recientes as $guia)
                <div class="col-md-6">
                    @include('ayuda.utilities._guia-card', ['guia' => $guia, 'showRoute' => $showRoute])
                </div>
            @endforeach
        </div>
    @endif

    @if ($destacadas->count() === 0 && $recientes->count() === 0)
        <div class="text-center py-5 text-muted">No hay guías disponibles.</div>
    @endif
</div>
