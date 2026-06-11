<div>
@push('stylesheets')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,650&display=swap" rel="stylesheet">
<style>
    .bf-portal { --bf-brick: #551312; --bf-cream: #FAF6EF; --bf-amber: #F5C842; --bf-ink: #2b2118; }

    .bf-hero { text-align: center; padding: 2.5rem 0 1.5rem; }
    .bf-hero .bf-overline { font-size: .78rem; letter-spacing: .35em; text-transform: uppercase; color: var(--bf-brick); font-weight: 600; }
    .bf-hero h1 { font-family: 'Fraunces', serif; font-weight: 650; font-size: clamp(2rem, 4vw, 3rem); color: var(--bf-ink); letter-spacing: .02em; margin: .25rem 0 0; }
    .bf-hero .bf-rule { width: 64px; height: 4px; background: var(--bf-amber); border-radius: 2px; margin: 1rem auto 0; }

    /* Cards */
    .bf-card { display: block; text-decoration: none; color: inherit; background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 10px rgba(43, 33, 24, .08); transition: transform .3s ease, box-shadow .3s ease; height: 100%; }
    .bf-card:hover { transform: translateY(-5px); box-shadow: 0 16px 32px rgba(43, 33, 24, .16); color: inherit; }
    .bf-card-img { height: 210px; background: #e7e2d9; overflow: hidden; }
    .bf-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
    .bf-card:hover .bf-card-img img { transform: scale(1.06); }
    .bf-card-body { padding: 1.1rem 1.25rem 1.35rem; }
    .bf-card-date { font-size: .78rem; color: #9a9183; letter-spacing: .04em; }
    .bf-card-title { font-family: 'Fraunces', serif; font-weight: 650; font-size: 1.15rem; color: var(--bf-ink); margin: .3rem 0 .35rem; }
    .bf-card-desc { font-size: .88rem; color: #6f665a; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .bf-card-cta { margin-top: .8rem; font-size: .8rem; font-weight: 600; color: var(--bf-brick); letter-spacing: .06em; text-transform: uppercase; }
    .bf-card-cta i { transition: transform .3s ease; vertical-align: middle; }
    .bf-card:hover .bf-card-cta i { transform: translateX(5px); }

    /* Animaciones de entrada */
    @keyframes bfFadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    .bf-reveal { animation: bfFadeUp .55s ease both; }
    .bf-grid > div:nth-child(1) .bf-card { animation: bfFadeUp .5s ease .05s both; }
    .bf-grid > div:nth-child(2) .bf-card { animation: bfFadeUp .5s ease .12s both; }
    .bf-grid > div:nth-child(3) .bf-card { animation: bfFadeUp .5s ease .19s both; }
    .bf-grid > div:nth-child(4) .bf-card { animation: bfFadeUp .5s ease .26s both; }
    .bf-grid > div:nth-child(5) .bf-card { animation: bfFadeUp .5s ease .33s both; }
    .bf-grid > div:nth-child(6) .bf-card { animation: bfFadeUp .5s ease .40s both; }

    @media (prefers-reduced-motion: reduce) {
        .bf-reveal, .bf-grid > div .bf-card { animation: none; }
        .bf-card, .bf-card-img img { transition: none; }
    }
</style>
@endpush

<div class="bf-portal">

    {{-- Hero --}}
    <div class="bf-hero bf-reveal">
        <div class="bf-overline">Valle de Santiago</div>
        <h1>Conoce tus Beneficios</h1>
        <div class="bf-rule"></div>
    </div>

    {{-- Filtros --}}
    <div class="row g-3 mb-4 align-items-end justify-content-center bf-reveal" style="animation-delay: .1s;">
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

    {{-- Grid de entradas --}}
    <div class="row g-4 bf-grid">
        @forelse ($entries as $entry)
            <div class="col-md-6" wire:key="bf-entry-{{ $entry->id }}">
                <a href="{{ route('benefits.admin.detail', $entry->slug) }}" class="bf-card">
                    <div class="bf-card-img">
                        @if ($entry->hero_img)
                            <img src="{{ $entry->hero_img }}" alt="{{ $entry->title }}">
                        @endif
                    </div>
                    <div class="bf-card-body">
                        <div class="bf-card-date">
                            {{ $entry->published_at ? $entry->published_at->translatedFormat('M d, Y') : $entry->created_at->translatedFormat('M d, Y') }}
                        </div>
                        <div class="bf-card-title">{{ $entry->title }}</div>
                        <p class="bf-card-desc">{{ $entry->description }}</p>
                        <div class="bf-card-cta">Leer entrada <i class="bx bx-right-arrow-alt"></i></div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bx bx-search-alt fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">No se encontraron beneficios con los filtros aplicados.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $entries->links() }}</div>

</div>
</div>
