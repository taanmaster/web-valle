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

                    @if (auth()->user()->hasRole('institutional_development') ||
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

                    @if (auth()->user()->hasRole('transparency') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Transparencia"
                            data-bs-trigger="hover">
                            <a href="#valleTransparency" id="apps-tab" class="nav-link">
                                <i class="ti ti-apps menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('financial_support') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Tesorería"
                            data-bs-trigger="hover">
                            <a href="#valleTreasury" id="uikit-tab" class="nav-link">
                                <i class="ti ti-archive menu-icon"></i>
                            </a>
                        </li>
                    @endif

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

                    @if (auth()->user()->hasRole('dif') || auth()->user()->hasRole('all'))
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="DIF"
                            data-bs-trigger="hover">
                            <a href="#valleDIF" id="dif-tab" class="nav-link">
                                <i class="ti ti-heart menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="IMPLAN"
                        data-bs-trigger="hover">
                        <a href="#valleImplan" id="implan-tab" class="nav-link">
                            <i class="ti ti-bulb menu-icon"></i>
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
            @if (auth()->user()->hasRole('dashboard') || auth()->user()->hasRole('all'))
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
                </div>
            @endif

            @if (auth()->user()->hasRole('institutional_development') || auth()->user()->hasRole('all'))
                <div id="valleInstitutionalDevelopment" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="institutional-development-tab">

                    @if (auth()->user()->hasRole('private_secretary') || auth()->user()->hasRole('all'))
                        <div class="title-box">
                            <h6 class="menu-title">Desarrollo Institucional</h6>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('regulatory_agenda.index') }}">Agenda
                                    Regulatoria</a>
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
                </div>
            @endif

            @if (auth()->user()->hasRole('transparency') || auth()->user()->hasRole('all'))
                <div id="valleTransparency" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="apps-tab">
                    @if (auth()->user()->hasRole('transparency') || auth()->user()->hasRole('all'))
                        <div class="title-box">
                            <h6 class="menu-title">Transparencia</h6>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('transparency_dependencies.index') }}">Dependencias</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('transparency_obligations.index') }}">Obligaciones</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('transparency_files.index') }}">Repositorio de
                                    Archivos (Links)</a>
                            </li>
                        </ul>
                    @endif

                    <div class="title-box">
                        <h6 class="menu-title">Gaceta</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gazettes.index') }}">Gaceta Municipal</a>
                        </li>
                    </ul>
                </div>
            @endif

            @if (auth()->user()->hasRole('financial_support') || auth()->user()->hasRole('all'))
                <div id="valleTreasury" class="main-icon-menu-pane tab-pane" role="tabpanel"
                    aria-labelledby="uikit-tab">
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
                            <a class="nav-link" href="{{ route('account_due_profiles.index') }}">Perfiles cuentas por
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
                            <a class="nav-link" href="{{ route('account_due_incomes.index') }}">Ingresos a cobro</a>
                        </li>
                    </ul>

                    <div class="title-box mt-5">
                        <h6 class="menu-title">Tarífas</h6>
                    </div>

                    <ul class="nav flex-column mt-4">
                        <li class="nav-item mb-3">
                            <a class="nav-link" href="{{ route('trs_admin_revenue_collection.index') }}">Listado de
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

                    <div class="title-box mt-5">
                        <h6 class="menu-title">Documentos y Dependencias</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('treasury_dependencies.index') }}">Dependencias</a>
                        </li>
                    </ul>
                </div>
            @endif

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
                    </ul>

                    <div class="title-box">
                        <h6 class="menu-title">Usuarios</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urban_dev.inspectors.index') }}">Inspectores</a>
                        </li>
                    </ul>
                </div>
            @endif

            @if (auth()->user()->hasRole('dif') || auth()->user()->hasRole('all'))
                <div id="valleDIF" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="dif-tab" style="padding-bottom: 120px;">
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
                </div>
            @endif

            <div id="valleImplan" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="implan-tab">
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
            </div>

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
                </div>
            @endif
        </div>
    </div>
</div>
