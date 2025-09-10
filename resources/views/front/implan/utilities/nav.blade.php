<div class="d-flex align-items-center justify-content-between" style="padding: 18px 0;">
    <div class="d-flex align-items-center" style="gap:40px">
        <img src="{{ asset('images/implan/implan-logo.png') }}" alt="" style="height: 140px;">
        <img src="{{ asset('front/img/logo-valle.png') }}" alt="" style="width: 140px">
    </div>

    <h1>Instituto Municipal de Planeación</h1>
</div>

<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4 nav-implan">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link @if (Request::routeIs('implan.index')) active @endif" aria-current="page"
                        href="{{ route('implan.index') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::routeIs('implan.who_we_are')) active @endif"
                        href="{{ route('implan.who_we_are') }}">¿Quiénes somos?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::routeIs('implan.front.blog') || Request::routeIs('implan.front.blog.detail')) active @endif"
                        href="{{ route('implan.front.blog') }}">Blog de Planeación Urbana y Territorial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::routeIs('implan.front.projects')) active @endif"
                        href="{{ route('implan.front.projects') }}">Proyectos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Participación Ciudadana</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" />
                <button class="btn btn-outline-light" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</nav>

@push('styles')
    <style>
        .nav-implan {
            background-color: #931917 !important;
            border-radius: 8px;
            color: white;
        }

        .nav-implan .nav-link {
            color: white !important;
        }

        .nav-implan .nav-link:hover {
            color: #f8f9fa !important;
        }

        .nav-implan .nav-link.active {
            color: #f8f9fa !important;
            background: #ca2f2d72 !important;
            border-radius: 6px;
        }
    </style>
@endpush
