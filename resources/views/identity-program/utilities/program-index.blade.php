<div>
@push('stylesheets')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,650&display=swap" rel="stylesheet">
<style>
    .ip-portal { --ip-brick: #551312; --ip-cream: #FAF6EF; --ip-amber: #F5C842; --ip-ink: #2b2118; }

    .ip-hero { text-align: center; padding: 2.5rem 0 1.5rem; }
    .ip-hero .ip-overline { font-size: .78rem; letter-spacing: .35em; text-transform: uppercase; color: var(--ip-brick); font-weight: 600; }
    .ip-hero h1 { font-family: 'Fraunces', serif; font-weight: 650; font-size: clamp(2rem, 4vw, 3rem); color: var(--ip-ink); letter-spacing: .02em; margin: .25rem 0 0; }
    .ip-hero .ip-rule { width: 64px; height: 4px; background: var(--ip-amber); border-radius: 2px; margin: 1rem auto 0; }

    /* Bandas de valores */
    .ip-value-band { display: flex; align-items: stretch; gap: 1.5rem; margin-bottom: 1.25rem; }
    .ip-value-pill { flex: 0 0 42%; display: flex; align-items: center; justify-content: center; padding: 2.2rem 1.5rem; border-radius: 18px 60px 18px 60px; transition: transform .35s ease, box-shadow .35s ease; }
    .ip-value-pill h2 { font-family: 'Fraunces', serif; font-weight: 650; letter-spacing: .14em; font-size: clamp(1.1rem, 2vw, 1.6rem); margin: 0; text-transform: uppercase; }
    .ip-value-band:hover .ip-value-pill { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(43, 33, 24, .18); }
    .ip-value-pill--brick { background: linear-gradient(135deg, #551312 0%, #7a2422 100%); }
    .ip-value-pill--brick h2 { color: var(--ip-cream); }
    .ip-value-pill--amber { background: linear-gradient(135deg, #F5C842 0%, #f0d57e 100%); }
    .ip-value-pill--amber h2 { color: var(--ip-ink); }
    .ip-value-text { flex: 1; display: flex; align-items: center; color: #5b5247; font-size: .98rem; line-height: 1.65; }

    /* Cards */
    .ip-card { display: block; text-decoration: none; color: inherit; background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 10px rgba(43, 33, 24, .08); transition: transform .3s ease, box-shadow .3s ease; height: 100%; }
    .ip-card:hover { transform: translateY(-5px); box-shadow: 0 16px 32px rgba(43, 33, 24, .16); color: inherit; }
    .ip-card-img { height: 210px; background: #e7e2d9; overflow: hidden; }
    .ip-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
    .ip-card:hover .ip-card-img img { transform: scale(1.06); }
    .ip-card-body { padding: 1.1rem 1.25rem 1.35rem; }
    .ip-card-date { font-size: .78rem; color: #9a9183; letter-spacing: .04em; }
    .ip-card-title { font-family: 'Fraunces', serif; font-weight: 650; font-size: 1.15rem; color: var(--ip-ink); margin: .3rem 0 .35rem; }
    .ip-card-desc { font-size: .88rem; color: #6f665a; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .ip-card-cta { margin-top: .8rem; font-size: .8rem; font-weight: 600; color: var(--ip-brick); letter-spacing: .06em; text-transform: uppercase; }
    .ip-card-cta i { transition: transform .3s ease; vertical-align: middle; }
    .ip-card:hover .ip-card-cta i { transform: translateX(5px); }

    /* Animaciones de entrada */
    @keyframes ipFadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    .ip-reveal { animation: ipFadeUp .55s ease both; }
    .ip-grid > div:nth-child(1) .ip-card { animation: ipFadeUp .5s ease .05s both; }
    .ip-grid > div:nth-child(2) .ip-card { animation: ipFadeUp .5s ease .12s both; }
    .ip-grid > div:nth-child(3) .ip-card { animation: ipFadeUp .5s ease .19s both; }
    .ip-grid > div:nth-child(4) .ip-card { animation: ipFadeUp .5s ease .26s both; }
    .ip-grid > div:nth-child(5) .ip-card { animation: ipFadeUp .5s ease .33s both; }
    .ip-grid > div:nth-child(6) .ip-card { animation: ipFadeUp .5s ease .40s both; }

    @media (prefers-reduced-motion: reduce) {
        .ip-reveal, .ip-grid > div .ip-card { animation: none; }
        .ip-card, .ip-value-pill, .ip-card-img img { transition: none; }
    }

    @media (max-width: 767.98px) {
        .ip-value-band { flex-direction: column; gap: .75rem; }
        .ip-value-pill { flex-basis: auto; padding: 1.5rem 1rem; }
    }
</style>
@endpush

<div class="ip-portal">

    {{-- Hero --}}
    <div class="ip-hero ip-reveal">
        <div class="ip-overline">Valle de Santiago</div>
        <h1>Programa de Identidad</h1>
        <div class="ip-rule"></div>
    </div>

    {{-- Filtros --}}
    <div class="row g-3 mb-4 align-items-end justify-content-center ip-reveal" style="animation-delay: .1s;">
        <div class="col-md-3 col-6">
            <label class="form-label small text-muted">Fecha</label>
            <input type="date" class="form-control rounded-pill" wire:model.live="filter_fecha">
        </div>
        <div class="col-md-3 col-6">
            <label class="form-label small text-muted">Título</label>
            <input type="text" class="form-control rounded-pill" placeholder="Buscar por título"
                wire:model.live.debounce.300ms="filter_titulo">
        </div>
        @if ($this->hasFilters)
            <div class="col-md-2 col-12 text-center text-md-start">
                <button wire:click="resetFilters" class="btn btn-link text-danger p-0 mb-2">Limpiar filtros</button>
            </div>
        @endif
    </div>

    {{-- Valores institucionales — se ocultan al aplicar filtros --}}
    @if (!$this->hasFilters)
        <div class="mb-5" wire:transition.origin.top.duration.500ms>
            <div class="ip-value-band ip-reveal" style="animation-delay: .18s;">
                <div class="ip-value-pill ip-value-pill--brick">
                    <h2>Responsabilidad</h2>
                </div>
                <p class="ip-value-text mb-0">
                    Rendir cuentas por las acciones y decisiones tomadas y asumir la
                    responsabilidad por los errores.
                </p>
            </div>
            <div class="ip-value-band ip-reveal" style="animation-delay: .26s;">
                <div class="ip-value-pill ip-value-pill--amber">
                    <h2>Integridad</h2>
                </div>
                <p class="ip-value-text mb-0">
                    Actuar con honestidad y ética en todas las interacciones, y evitar
                    conflictos de intereses.
                </p>
            </div>
        </div>
    @endif

    {{-- Grid de entradas --}}
    <div class="row g-4 ip-grid">
        @forelse ($entries as $entry)
            <div class="col-md-6" wire:key="ip-entry-{{ $entry->id }}">
                <a href="{{ route('identity_program.admin.detail', $entry->slug) }}" class="ip-card">
                    <div class="ip-card-img">
                        @if ($entry->hero_img)
                            <img src="{{ $entry->hero_img }}" alt="{{ $entry->title }}">
                        @endif
                    </div>
                    <div class="ip-card-body">
                        <div class="ip-card-date">
                            {{ $entry->published_at ? $entry->published_at->translatedFormat('M d, Y') : $entry->created_at->translatedFormat('M d, Y') }}
                        </div>
                        <div class="ip-card-title">{{ $entry->title }}</div>
                        <p class="ip-card-desc">{{ $entry->description }}</p>
                        <div class="ip-card-cta">Leer entrada <i class="bx bx-right-arrow-alt"></i></div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bx bx-search-alt fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">No se encontraron entradas con los filtros aplicados.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $entries->links() }}</div>

</div>
</div>
