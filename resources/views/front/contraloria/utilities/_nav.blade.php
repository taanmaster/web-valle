<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-pill shadow mb-4">
    <div class="container-fluid px-4">
        <!-- Navbar brand o logo (opcional) -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('contraloria.index') }}">
            <ion-icon name="library-outline"></ion-icon> Contraloría
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
                              {{ request()->routeIs('contraloria.index') ? 'bg-white bg-opacity-25' : '' }}" 
                       href="{{ route('contraloria.index') }}">
                        <ion-icon name="home-outline"></ion-icon>
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1  d-flex align-items-center gap-2
                              {{ request()->routeIs('contraloria.declaration') ? 'bg-white bg-opacity-25' : '' }}" 
                       href="{{ route('contraloria.declaration') }}">
                        <ion-icon name="document-text-outline"></ion-icon>
                        Declaración Patrimonial
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1  d-flex align-items-center gap-2
                              {{ request()->routeIs('contraloria.reception') ? 'bg-white bg-opacity-25' : '' }}" 
                       href="{{ route('contraloria.reception') }}">
                        <ion-icon name="grid-outline"></ion-icon>
                        Entrega-Recepción
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white fw-medium px-3 py-2 rounded-pill mx-1  d-flex align-items-center gap-2
                              {{ request()->routeIs('contraloria.suggestions') ? 'bg-white bg-opacity-25' : '' }}" 
                       href="{{ route('contraloria.suggestions') }}">
                        <ion-icon name="people-outline"></ion-icon>
                        
                        Quejas, Denuncias y Sugerencias
                    </a>
                </li>
            </ul>

            <!-- Buscador -->
            {{--  
            <div class="d-flex">
                <div class="input-group">
                    <input type="search" class="form-control bg-primary border-0 text-white rounded-pill ps-3" 
                           placeholder="Buscar Contactos o Trámites..." aria-label="Buscar">
                    <button class="btn btn-outline-light border-0 rounded-pill ms-2 d-flex align-items-center" type="submit">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div>
            </div>
            --}}
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

    .justify-p{
        text-align: justify !important
    }
</style>