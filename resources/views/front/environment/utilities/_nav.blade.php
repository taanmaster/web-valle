<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-pill shadow mb-4">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2"
            href="{{ route('environment.index') }}">
            <ion-icon name="leaf-outline"></ion-icon> Medio Ambiente
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#environmentNav" aria-controls="environmentNav" aria-expanded="false"
            aria-label="Abrir navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="environmentNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1 d-flex align-items-center gap-2
                              {{ request()->routeIs('environment.index') ? 'bg-white bg-opacity-25' : '' }}"
                        href="{{ route('environment.index') }}">
                        <ion-icon name="home-outline"></ion-icon>
                        Inicio
                    </a>
                </li>

                @foreach (config('medio_ambiente.procedures') as $slug => $procedure)
                    <li class="nav-item">
                        <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1 d-flex align-items-center gap-2
                                  {{ request()->routeIs('environment.procedure') && request()->route('slug') === $slug ? 'bg-white bg-opacity-25' : '' }}"
                            href="{{ route('environment.procedure', $slug) }}">
                            <ion-icon name="{{ $procedure['icon'] }}"></ion-icon>
                            {{ $procedure['short_title'] }}
                        </a>
                    </li>
                @endforeach

                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1 d-flex align-items-center gap-2
                              {{ request()->routeIs('environment.list') || request()->routeIs('environment.detail') ? 'bg-white bg-opacity-25' : '' }}"
                        href="{{ route('environment.list') }}">
                        <ion-icon name="newspaper-outline"></ion-icon>
                        Artículos
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
    }

    @media (max-width: 991.98px) {
        .navbar {
            border-radius: 1rem !important;
            margin: 0.5rem !important;
        }
    }
</style>
