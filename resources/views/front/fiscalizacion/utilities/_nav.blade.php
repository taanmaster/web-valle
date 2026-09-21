<nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded-pill shadow mb-4">
    <div class="container-fluid px-4">
        <!-- Navbar brand o logo (opcional) -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('fiscalizacion.index') }}">
            <ion-icon name="shield-checkmark-outline"></ion-icon> Fiscalización
        </a>

        <!-- Botón para móvil -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1  d-flex align-items-center gap-2
                              {{ request()->routeIs('fiscalizacion.index') ? 'bg-white bg-opacity-25' : '' }}"
                       href="{{ route('fiscalizacion.index') }}">
                        <ion-icon name="home-outline"></ion-icon>
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1  d-flex align-items-center gap-2
                              {{ request()->routeIs('fiscalizacion.directory') ? 'bg-white bg-opacity-25' : '' }}"
                       href="{{ route('fiscalizacion.directory') }}">
                        <ion-icon name="people-outline"></ion-icon>
                        Directorio
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
