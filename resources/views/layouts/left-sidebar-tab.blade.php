<div class="leftbar-tab-menu">
    <div class="main-icon-menu">
        <a href="{{ route('dashboard') }}" class="logo logo-metrica d-block text-center">
            <span>
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
            </span>
        </a>
        <div class="main-icon-menu-body">
            <div class="position-reletive h-100" data-simplebar style="overflow-x: hidden;">
                <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                    @if(auth()->user()->can('dashboard_view') || auth()->user()->can('all_access'))
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Vistas Generales" data-bs-trigger="hover">
                        <a href="#valleDashboard" id="dashboard-tab" class="nav-link">
                            <i class="ti ti-smart-home menu-icon"></i>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->can('dashboard_view') || auth()->user()->can('all_access'))
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Comunicación Social" data-bs-trigger="hover">
                        <a href="#valleComunicacion" id="comunicacion-tab" class="nav-link">
                            <i class="ti ti-smart-home menu-icon"></i>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->can('transparency_view') || auth()->user()->can('all_access'))
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Transparencia" data-bs-trigger="hover">
                        <a href="#valleTransparency" id="apps-tab" class="nav-link">
                            <i class="ti ti-apps menu-icon"></i>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->can('financial_support_view') || auth()->user()->can('all_access'))
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Apoyos Económicos" data-bs-trigger="hover">
                        <a href="#valleFinancialSupport" id="uikit-tab" class="nav-link">
                            <i class="ti ti-planet menu-icon"></i>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->can('gazette_view') || auth()->user()->can('all_access'))
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Gaceta Municipal" data-bs-trigger="hover">
                        <a href="#valleDocuments" id="pages-tab" class="nav-link">
                            <i class="ti ti-files menu-icon"></i>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->can('configuration_view') || auth()->user()->can('all_access'))
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Configuraciones" data-bs-trigger="hover">
                        <a href="#valleConfiguration" id="authentication-tab" class="nav-link">
                            <i class="ti ti-shield-lock menu-icon"></i>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="pro-metrica-end">
            <a href="{{ route('admin.profile') }}" class="profile">
                <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( Auth::user()->email ?? 'N/A'))) . '?d=retro&s=150' }}" alt="profile-user" class="rounded-circle thumb-sm">
            </a>
        </div>
    </div>

    <div class="main-menu-inner">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="{{ route('dashboard') }}" class="logo">
                <span>
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo-large" class="logo-lg logo-light">
                </span>
            </a>
        </div>

        <div class="menu-body navbar-vertical tab-content" data-simplebar>
            @if(auth()->user()->can('dashboard_view') || auth()->user()->can('all_access'))
            <div id="valleDashboard" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="dasboard-tab">
                <div class="title-box">
                    <h6 class="menu-title">Vistas Generales</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ul>
            </div>
            @endif

            @if(auth()->user()->can('dashboard_view') || auth()->user()->can('all_access'))
            <div id="valleComunicacion" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="comunicacion-tab">
                <div class="title-box">
                    <h6 class="menu-title">Comunicación Social</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('banners.index') }}">Banners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('headerbands.index') }}">Cintillos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('popups.index') }}">Popups</a>
                    </li>
                </ul>
            </div>
            @endif

            @if(auth()->user()->can('transparency_view') || auth()->user()->can('all_access'))
            <div id="valleTransparency" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="apps-tab">
                <div class="title-box">
                    <h6 class="menu-title">Transparencia</h6>
                </div>
                <ul class="nav flex-column">
                    @if(auth()->user()->can('transparency_dependencies') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transparency_dependencies.index') }}">Dependencias</a>
                    </li>
                    @endif

                    @if(auth()->user()->can('transparency_obligations') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transparency_obligations.index') }}">Obligaciones</a>
                    </li>
                    @endif

                    @if(auth()->user()->can('transparency_files') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transparency_files.index') }}">Repositorio de Archivos (Links)</a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            @if(auth()->user()->can('financial_support_view') || auth()->user()->can('all_access'))
            <div id="valleFinancialSupport" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="uikit-tab">
                <div class="title-box">
                    <h6 class="menu-title">Apoyos Económicos</h6>
                </div>
                <ul class="nav flex-column">
                    @if(auth()->user()->can('financial_support_citizens') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citizens.index') }}">Particulares</a>
                    </li>
                    @endif

                    @if(auth()->user()->can('financial_support_supports') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('financial_supports.index') }}">Apoyos</a>
                    </li>
                    @endif

                    @if(auth()->user()->can('financial_support_reports') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kpi.query') }}">Reporte de Apoyos</a>
                    </li>
                    @endif

                    @if(auth()->user()->can('financial_support_types') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('financial_support_types.index') }}">Tipos de Apoyo</a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            @if(auth()->user()->can('gazette_view') || auth()->user()->can('all_access'))
            <div id="valleDocuments" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="pages-tab">
                <div class="title-box">
                    <h6 class="menu-title">Gaceta</h6>
                </div>
                <ul class="nav flex-column">
                    @if(auth()->user()->can('gazette_municipal') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gazettes.index') }}">Gaceta Municipal</a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            @if(auth()->user()->can('configuration_view') || auth()->user()->can('all_access'))
            <div id="valleConfiguration" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="authentication-tab">
                <div class="title-box">
                    <h6 class="menu-title">Configuraciones</h6>
                </div>
                <ul class="nav flex-column">
                    @if(auth()->user()->can('configuration_users') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                    </li>
                    @endif

                    @if(auth()->user()->can('configuration_legals') || auth()->user()->can('all_access'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('legals.index') }}">Textos Legales</a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>