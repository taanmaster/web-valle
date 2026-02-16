<div class="d-flex align-items-center justify-content-between" style="padding: 18px 0;">
    <div class="d-flex align-items-center" style="gap:40px">
        <img src="{{ asset('front/img/logo-valle.png') }}" alt="" style="width: 140px">
    </div>

    <h1>Turismo</h1>
</div>

<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4 nav-tourism">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link @if (Request::routeIs('turismo.index')) active @endif" aria-current="page"
                        href="{{ route('turismo.index') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::routeIs('turismo.front.blog.list') || Request::routeIs('turismo.front.blog.detail')) active @endif"
                        href="{{ route('turismo.front.blog.list') }}">Blog de Turismo</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('styles')
    <style>
        .nav-tourism {
            background-color: #2e7d32 !important;
            border-radius: 8px;
            color: white;
        }

        .nav-tourism .nav-link {
            color: white !important;
        }

        .nav-tourism .nav-link:hover {
            color: #f8f9fa !important;
        }

        .nav-tourism .nav-link.active {
            color: #f8f9fa !important;
            background: #43a04772 !important;
            border-radius: 6px;
        }
    </style>
@endpush
