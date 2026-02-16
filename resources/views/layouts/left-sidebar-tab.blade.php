{{-- La libreria de iconos es TABLER ICONS https://tablericons.com/ --}}
{{-- Usar nomeclatura ti ti-[NOMBRE DEL ARCHIVO DE TABLER ICONS] --}}

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
                    @if (auth()->user()->hasRole('dashboard') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Vistas Generales"
                            data-bs-trigger="hover">
                            <a href="#valleDashboard" id="dashboard-tab" class="nav-link">
                                <i class="ti ti-smart-home menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Citas para Trámites" data-bs-trigger="hover">
                            <a href="#valleCitas" id="citas-tab" class="nav-link">
                                <i class="ti ti-calendar-event menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('des_Institucional') ||
                            auth()->user()->hasRole('private_secretary') ||
                            auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Desarrollo Institucional" data-bs-trigger="hover">
                            <a href="#valleInstitutionalDevelopment" id="institutional-development-tab"
                                class="nav-link">
                                <i class="ti ti-notebook menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('all') || auth()->user()->email == 'denunciascontraloria@valledesantiago.gob.mx')
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Denuncias Ciudadanas" data-bs-trigger="hover">
                            <a href="#valleDenunciaNet" id="denuncianet-tab" class="nav-link">
                                <i class="ti ti-forms menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('dashboard') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Comunicación Social" data-bs-trigger="hover">
                            <a href="#valleComunicacion" id="comunicacion-tab" class="nav-link">
                                <i class="ti ti-messages menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('des_Institucional') ||
                            auth()->user()->hasRole('transparency') ||
                            auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Transparencia"
                            data-bs-trigger="hover">
                            <a href="#valleTransparency" id="apps-tab" class="nav-link">
                                <i class="ti ti-apps menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @hasanyrole(['financial_support', 'financial_support_helper', 'all', 'tesoreria_caja',
                        'cto_admin', 'cto_helper'])
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Tesorería"
                            data-bs-trigger="hover">
                            <a href="#valleTreasury" id="uikit-tab" class="nav-link">
                                <i class="ti ti-archive menu-icon"></i>
                            </a>
                        </li>
                    @endhasanyrole

                    @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Secretaría Particular" data-bs-trigger="hover">
                            <a href="#vallePrivateSecretary" id="uikit-tab" class="nav-link">
                                <i class="ti ti-bookmark menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('sare') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="SARE"
                            data-bs-trigger="hover">
                            <a href="#valleSARE" id="sare-tab" class="nav-link">
                                <i class="ti ti-box-multiple menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('urban_dev') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Desarrollo Urbano" data-bs-trigger="hover">
                            <a href="#valleUrbanDev" id="urban-dev-tab" class="nav-link">
                                <i class="ti ti-map-pin menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('acquisitions') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Adquisiciones"
                            data-bs-trigger="hover">
                            <a href="#valleAcquisitions" id="acquisitions-tab" class="nav-link">
                                <i class="ti ti-shopping-cart menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('dif') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="DIF"
                            data-bs-trigger="hover">
                            <a href="#valleDIF" id="dif-tab" class="nav-link">
                                <i class="ti ti-heart menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('implan') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="IMPLAN"
                            data-bs-trigger="hover">
                            <a href="#valleImplan" id="implan-tab" class="nav-link">
                                <i class="ti ti-bulb menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Secretaría Particular" data-bs-trigger="hover">
                        <a href="#valleSecretary" id="authentication-tab" class="nav-link">
                            <i class="ti ti-briefcase menu-icon"></i>
                        </a>
                    </li>

                    @if (auth()->user()->hasRole('configuration') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Configuraciones" data-bs-trigger="hover">
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
                <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email ?? 'N/A'))) . '?d=retro&s=150' }}"
                    alt="profile-user" class="rounded-circle thumb-sm">
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
            <div id="valleDashboard" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="dasboard-tab">
                <div class="title-box">
                    <h6 class="menu-title">Vistas Generales</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ul>

                <div class="title-box">
                    <h6 class="menu-title">Citas para Trámites</h6>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('appointment-bookings.dependency') }}">Citas de Mi Dependencia</a>
                    </li>
                </ul>

                <div class="title-box">
                    <h6 class="menu-title">Oficios</h6>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backoffice.documents.index') }}">Tus Oficios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backoffice.documents.received') }}">Recibidos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backoffice.documents.notifications') }}">Notificaciones</a>
                    </li>

                    @hasanyrole(['webmaster', 'all'])
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backoffice.documents.repository') }}">Repositorio</a>
                    </li>
                    @endhasanyrole
                </ul>

                @hasanyrole(['human_resources', 'all'])
                <div class="title-box">
                    <h6 class="menu-title">Recursos Humanos</h6>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backoffice.dependencies.index') }}">Dependencias</a>
                    </li>
                </ul>
                @endhasanyrole

                @if(auth()->user()->hasRole('all'))
                <div class="mt-3 px-3">
                    <small class="text-muted d-block mb-1">Roles con acceso general:</small>
                    <span class="badge bg-primary me-1 mb-1">dashboard</span>
                    <span class="badge bg-primary me-1 mb-1">all</span>
                    <small class="text-muted d-block mb-1">Roles con acceso Recursos Humanos:</small>
                    <span class="badge bg-primary me-1 mb-1">human_resources</span>
                    <span class="badge bg-primary me-1 mb-1">all</span>
                </div>
                @endif
            </div>

            @if (auth()->user()->hasRole('des_Institucional') || auth()->user()->hasRole('all'))
                <div id="valleInstitutionalDevelopment" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="institutional-development-tab">

                    @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                        <div class="title-box">
                            <h6 class="menu-title">Desarrollo Institucional</h6>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('agenda_dependencies.index') }}">Agendas</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('municipal_inspections.index') }}" class="nav-link">
                                    Registro Municipal de Inspecciones
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('council_minutes.index') }}" class="nav-link">
                                    Actas de Consejo
                                </a>
                            </li>
                        </ul>
                    @endif

                    <div class="title-box">
                        <h6 class="menu-title">Mejora Regulatoria</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('institucional_development.regulations.index') }}">Normativa
                                Municipal</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('institucional_development.requests.index') }}">Trámites y
                                Servicios</a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Comunicación</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('institucional_development.banners.index') }}">Banners</a>
                        </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">des_Institucional</span>
                        <span class="badge bg-primary me-1 mb-1">private_secretary</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('dashboard') || auth()->user()->hasRole('all'))
                <div id="valleDenunciaNet" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="denuncianet-tab">
                    <div class="title-box">
                        <h6 class="menu-title">DenunciaNET</h6>
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citizen_complain.index') }}">Denuncias ciudadanas</a>
                    </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                        <span class="badge bg-secondary me-1 mb-1">denunciascontraloria@...</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('dashboard') || auth()->user()->hasRole('all'))
                <div id="valleComunicacion" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="comunicacion-tab">
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

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.admin.index') }}">Blog</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('events.index') }}">Eventos</a>
                        </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">dashboard</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('des_Institucional') ||
                    auth()->user()->hasRole('transparency') ||
                    auth()->user()->hasRole('all'))
                <div id="valleTransparency" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="apps-tab">

                    <div class="title-box">
                        <h6 class="menu-title">Transparencia</h6>
                    </div>
                    <ul class="nav flex-column">
                        @if (auth()->user()->hasRole('transparency') || auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('transparency_dependencies.index') }}">Dependencias</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transparency_obligations.index') }}">Obligaciones</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transparency_files.index') }}">Repositorio de
                                Archivos (Links)</a>
                        </li>
                    </ul>

                    @if (auth()->user()->hasRole('transparency') || auth()->user()->hasRole('all'))
                        <div class="title-box">
                            <h6 class="menu-title">Gaceta</h6>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gazettes.index') }}">Gaceta Municipal</a>
                            </li>
                        </ul>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('trn_proposals.index') }}">Convocatorias</a>
                            </li>
                        </ul>
                    @endif

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">des_Institucional</span>
                        <span class="badge bg-primary me-1 mb-1">transparency</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @hasanyrole(['financial_support', 'financial_support_helper', 'all', 'tesoreria_caja', 'cto_admin',
                'cto_helper'])
                <div id="valleTreasury" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="uikit-tab">

                    <div class="title-box mt-5">
                        <h6 class="menu-title">Predial</h6>
                    </div>

                    <ul class="nav flex-column">
                        @hasanyrole(['all', 'financial_support', 'financial_support_helper', 'cto_admin', 'cto_helper'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('properties.index') }}">Predios</a>
                            </li>
                        @endhasanyrole

                        @hasanyrole(['all', 'financial_support', 'financial_support_helper', 'tesoreria_caja'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('property_taxes.index') }}">Recibos</a>
                            </li>
                        @endhasanyrole
                    </ul>

                    @hasanyrole(['all', 'financial_support', 'financial_support_helper'])
                        <div class="title-box">
                            <h6 class="menu-title">Cuentas por Pagar</h6>
                        </div>

                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account_payable.index') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('treasury_account_payable_suppliers.index') }}">Proveedores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('treasury_account_payable_contractors.index') }}">Contratistas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('treasury_account_payable_checklists.index') }}">Checklists</a>
                            </li>
                        </ul>

                        <div class="title-box mt-5">
                            <h6 class="menu-title">Cuentas por Cobrar</h6>
                        </div>

                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account_due.dashboard') }}">Dashboard</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account_due_profiles.index') }}">Perfiles cuentas
                                    por
                                    cobrar</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account_due_provisional_integers.index') }}">Registro
                                    de Enteros</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account_due.cashbox') }}">Caja</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account_due_incomes.index') }}">Ingresos a
                                    cobro</a>
                            </li>
                        </ul>

                        <div class="title-box mt-5">
                            <h6 class="menu-title">Tarífas</h6>
                        </div>

                        <ul class="nav flex-column mt-4">
                            <li class="nav-item mb-3">
                                <a class="nav-link" href="{{ route('trs_admin_revenue_collection.index') }}">Listado
                                    de
                                    disposiciones administrativas de recaudación</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('revenue_law.index') }}">Ley
                                    de Ingresos</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rates_and_costs.index') }}">Tarifas y Costos</a>
                            </li>
                        </ul>
                    @endhasanyrole

                    @hasanyrole(['all', 'financial_support', 'financial_support_helper'])
                        <div class="title-box mt-5">
                            <h6 class="menu-title">Documentos y Dependencias</h6>
                        </div>

                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('treasury_dependencies.index') }}">Dependencias</a>
                            </li>
                        </ul>
                    @endhasanyrole

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">financial_support</span>
                        <span class="badge bg-primary me-1 mb-1">financial_support_helper</span>
                        <span class="badge bg-primary me-1 mb-1">tesoreria_caja</span>
                        <span class="badge bg-primary me-1 mb-1">cto_admin</span>
                        <span class="badge bg-primary me-1 mb-1">cto_helper</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endhasanyrole

            @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                <div id="vallePrivateSecretary" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="uikit-tab">
                    <div class="title-box">
                        <h6 class="menu-title">Apoyos Económicos</h6>
                    </div>
                    <ul class="nav flex-column">
                        @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('citizens.index') }}">Particulares</a>
                            </li>
                        @endif

                        @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('financial_supports.index') }}">Apoyos</a>
                            </li>
                        @endif

                        @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kpi.query') }}">Reporte de Apoyos</a>
                            </li>
                        @endif

                        @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('financial_support_types.index') }}">Tipos de
                                    Apoyo</a>
                            </li>
                        @endif
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">private_secretary</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('sare') || auth()->user()->hasRole('all'))
                <div id="valleSARE" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="sare-tab">
                    <div class="title-box">
                        <h6 class="menu-title">Solicitudes</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sare.request.index') }}">Solicitudes</a>
                        </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">sare</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('urban_dev') || auth()->user()->hasRole('all'))
                <div id="valleUrbanDev" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="urban-dev-tab">
                    <div class="title-box">
                        <h6 class="menu-title">Trámites</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.requests.index') }}">Expedientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.inspectors.requests') }}">Vista
                                Inspector</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('summons.index') }}" class="nav-link">
                                Citatorios
                            </a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Usuarios</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.workers.inspectors') }}">Inspectores</a>
                        </li>
                    </ul>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.workers.experts') }}">Peritos</a>
                        </li>
                    </ul>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.workers.auditors') }}">Fiscalización</a>
                        </li>
                    </ul>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.workers.civil_defense') }}">Protección
                                Civil</a>
                        </li>
                    </ul>

                    @if (Auth::user()->email == 'webmaster@valle.com')
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal"
                                    data-bs-target="#importEmployees" class="btn btn-outline-primary">Importar
                                    Excel</a>
                            </li>
                        </ul>
                    @endif

                    <div class="title-box">
                        <h6 class="menu-title">Indicadores y KPI's</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.kpis.index') }}">Gráficas</a>
                        </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">urban_dev</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('dif') || auth()->user()->hasRole('all'))
                <div id="valleDIF" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="dif-tab"
                    style="padding-bottom: 120px;">
                    <div class="title-box">
                        <h6 class="menu-title">Perfiles</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.doctors.index') }}">Doctores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.specialties.index') }}">Especialidades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.consult_types.index') }}">Tipos de Consulta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.services.index') }}">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.payment_concepts.index') }}">Conceptos de
                                Cobro</a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Pacientes</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.medical_profiles.index') }}">Pacientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.coordinations.index') }}">Coordinaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.programs.index') }}">Programas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.socio_economic_tests.index') }}">Estudio
                                Socioeconómmico</a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Generales</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.social_assistances.index') }}">Asistencia
                                Social</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.expenses.index') }}">Salidas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.incomes.index') }}">Ingresos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.legal_processes.index') }}">Procesos
                                Jurídicos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.locations.index') }}">Locaciones</a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Inventario</h6>
                    </div>

                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.medications.index') }}">Medicamentos</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.medication_variants.index') }}">Variantes</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.stock_movements.index') }}">Movimientos</a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Comunicación</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dif.banners.index') }}">Banners</a>
                        </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">dif</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('acquisitions') || auth()->user()->hasRole('all'))
                <div id="valleAcquisitions" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="dif-tab" style="padding-bottom: 120px;">
                    <div class="title-box">
                        <h6 class="menu-title">Adquisiciones Municipal</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.suppliers.index') }}">Solicitudes a
                                Proveedor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.suppliers.sin_padron') }}">Proveedores
                                Sin Padrón</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.suppliers.con_padron') }}">Padrones
                                Activos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.endorsements.index') }}">Refrendos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.biddings.index') }}">Licitaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.bidding.contract') }}">Contratos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.bidding.contract_closed') }}">Contratos
                                cerrados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.materials.index') }}">Materiales y
                                servicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.inventory.index') }}">Inventario</a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Indicadores y KPI's</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('acquisitions.kpis.index') }}">Gráficas</a>
                        </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">acquisitions</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            @if (auth()->user()->hasRole('implan') || auth()->user()->hasRole('all'))
                <div id="valleImplan" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="implan-tab">
                    <div class="title-box">
                        <h6 class="menu-title">IMPLAN</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('implan.projects.index') }}">Proyectos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('implan.achievements.index') }}">Logros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('implan.blog.index') }}">Blog</a>
                        </li>
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Comunicación</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('implan.banners.index') }}">Banners</a>
                        </li>
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">implan</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif

            <div id="valleSecretary" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="authentication-tab">
                <div class="title-box">
                    <h6 class="menu-title">Secretaría Publica</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('identification_certificates.index') }}">Constancias de
                            Identificación</a>
                    </li>
                </ul>

                @if(auth()->user()->hasRole('all'))
                <div class="mt-3 px-3">
                    <small class="text-muted d-block mb-1">Roles con acceso:</small>
                    <span class="badge bg-success me-1 mb-1">Todos los usuarios</span>
                </div>
                @endif
            </div>

            @if (auth()->user()->hasRole('all'))
                <div id="valleCitas" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="citas-tab">
                    <div class="title-box">
                        <h6 class="menu-title">Citas para Trámites</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointments.index') }}">Trámites (Config.)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointment-bookings.index') }}">Citas Agendadas</a>
                        </li>
                    </ul>

                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasRole('configuration') || auth()->user()->hasRole('all'))
                <div id="valleConfiguration" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="authentication-tab">
                    <div class="title-box">
                        <h6 class="menu-title">Configuraciones</h6>
                    </div>
                    <ul class="nav flex-column">
                        @if (auth()->user()->hasRole('configuration') || auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                            </li>
                        @endif

                        @if (auth()->user()->hasRole('configuration') || auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('legals.index') }}">Textos Legales</a>
                            </li>
                        @endif

                        @if (auth()->user()->hasRole('all'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('roles.index') }}">Roles y Permisos</a>
                            </li>
                        @endif
                    </ul>

                    @if(auth()->user()->hasRole('all'))
                    <div class="mt-3 px-3">
                        <small class="text-muted d-block mb-1">Roles con acceso:</small>
                        <span class="badge bg-primary me-1 mb-1">configuration</span>
                        <span class="badge bg-primary me-1 mb-1">all</span>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@if (Auth::user()->email == 'webmaster@valle.com')
    <!-- Modal -->
    <div class="modal fade" id="importEmployees" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Importar Excel de Empleados</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('urban_dev.workers.import') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Selecciona tu Archivo <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="import_file" />
                        </div>

                        <div class="mb-3">
                            <label for="dependency_category" class="form-label">Dependencia del Trabajador <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" id="dependency_category" name="dependency_category"
                                required>
                                <option value="">Seleccionar...</option>
                                <option value="Peritos">Peritos</option>
                                <option value="Inspectores">Inspectores</option>
                                <option value="Fiscalización">Fiscalización</option>
                                <option value="Protección Civil">Protección Civil</option>
                            </select>

                            <small>Al seleccionar la dependencia, se aplicarán los permisos correspondientes a los
                                trabajadores de esa área. Agrupa los exceles por dependencia y subcategoria de
                                dependencia.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Procesar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
