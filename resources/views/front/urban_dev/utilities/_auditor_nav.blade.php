<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-pill shadow mb-4">
    <div class="container-fluid px-4">
        <!-- Navbar brand o logo (opcional) -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('urban_dev.contacts', 'auditors') }}">
            <ion-icon name="document-text-outline"></ion-icon> Fiscalización
        </a>

        <!-- Botón para móvil -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1  d-flex align-items-center gap-2
                              {{ request()->routeIs('urban_dev.index') ? 'bg-white bg-opacity-25' : '' }}" 
                       href="{{ route('urban_dev.contacts', 'auditors') }}">
                        <ion-icon name="home-outline"></ion-icon>
                        Directorio
                    </a>
                </li>
        </div>
    </div>
</nav>

<style>
    /* Solo estilos necesarios con Bootstrap */
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.8);
    }

    .form-control:focus {
        background-color: var(--bs-primary) !important;
        border-color: rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25) !important;
        color: white !important;
    }

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