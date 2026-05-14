@php
    $userRole = null;
    if (auth()->check()) {
        $userRole = auth()->user()->roles->first()?->name ?? 'citizen';
    }

    $currentRoute = request()->route()->getName();

    // Active group detection — citizen role
    $iniGroupActive =
        in_array($currentRoute, [
            'citizen.profile.index',
            'citizen.summons.index',
            'citizen.profile.edit',
            'citizen.profile.settings',
        ]) ||
        str_starts_with($currentRoute, 'citizen.appointments') ||
        str_starts_with($currentRoute, 'citizen.orders');

    $group2Active =
        request()->segment(4) === 'secretaria-de-ayuntamiento' ||
        request()->segment(4) === 'economia' ||
        request()->segment(4) === 'tramites' ||
        $currentRoute === 'citizen.profile.urban_dev_requests' ||
        str_starts_with($currentRoute, 'citizen.profile.applications') ||
        str_starts_with($currentRoute, 'citizen.sare') ||
        str_starts_with($currentRoute, 'citizen.third_party') ||
        str_starts_with($currentRoute, 'citizen.profile.identification_certificates');

    $group3Active = $currentRoute === 'citizen.services.index';
@endphp

@switch($userRole)
    @case('citizen')
        <style>
            .pnav-chevron {
                display: block;
                transition: transform .25s ease;
            }

            .pnav-toggle:not(.collapsed) .pnav-chevron {
                transform: rotate(180deg);
            }

            .pnav-header-link {
                border-right: 1px solid rgba(255, 255, 255, .3) !important;
            }
        </style>

        <div class="card profile-sidebar-nav">
            {{-- Mobile toggle --}}
            <div class="card-header d-md-none py-2">
                <button class="btn btn-outline-secondary btn-sm w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="#profileSidebarNav" aria-expanded="false" aria-controls="profileSidebarNav">
                    <ion-icon name="menu-outline"></ion-icon> Menú de navegación
                </button>
            </div>

            <div class="collapse d-md-block" id="profileSidebarNav">
                <div class="p-2 d-flex flex-column gap-2">

                    {{-- ── GROUP 1: INICIO (always expanded) ─────────────── --}}
                    <div>
                        <a href="{{ route('citizen.profile.index') }}"
                            class="btn btn-danger fw-bold text-uppercase w-100 mb-1 {{ $iniGroupActive ? 'shadow-sm' : 'opacity-75' }}">
                            <ion-icon name="home-outline"></ion-icon> Inicio
                        </a>
                        <div class="list-group list-group-flush rounded overflow-hidden">
                            <a href="{{ route('citizen.summons.index') }}"
                                class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.summons.index' ? 'active' : '' }}">
                                <ion-icon name="document-text-outline"></ion-icon> Citatorios
                            </a>
                            <a href="{{ route('citizen.appointments.index') }}"
                                class="list-group-item list-group-item-action {{ str_starts_with($currentRoute, 'citizen.appointments') ? 'active' : '' }}">
                                <ion-icon name="calendar-outline"></ion-icon> Mis Citas a Trámites
                            </a>
                            <a href="{{ route('citizen.orders.index') }}"
                                class="list-group-item list-group-item-action {{ str_starts_with($currentRoute, 'citizen.orders') ? 'active' : '' }}">
                                <ion-icon name="receipt-outline"></ion-icon> Mis Órdenes / Pagos
                            </a>
                            <a href="{{ route('citizen.profile.edit') }}"
                                class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.edit' ? 'active' : '' }}">
                                <ion-icon name="create-outline"></ion-icon> Editar Perfil
                            </a>
                            <a href="{{ route('citizen.profile.settings') }}"
                                class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.settings' ? 'active' : '' }}">
                                <ion-icon name="cog-outline"></ion-icon> Configuraciones
                            </a>
                        </div>
                    </div>

                    {{-- ── GROUP 2: TRÁMITES 100% EN LÍNEA ───────────────── --}}
                    <div>
                        <div class="d-flex mb-1">
                            {{-- TODO: update href with the group overview route --}}
                            <a href="#"
                                class="btn btn-success fw-bold text-uppercase text-start flex-grow-1 rounded-end-0 pnav-header-link {{ $group2Active ? 'shadow-sm' : 'opacity-75' }}"
                                style="font-size:.78rem; line-height:1.3;">
                                Trámites Digitales<br>100% en Línea
                            </a>
                            <button type="button"
                                class="btn btn-success rounded-start-0 px-3 pnav-toggle {{ $group2Active ? '' : 'collapsed' }}"
                                data-bs-toggle="collapse" data-bs-target="#navGroup2"
                                aria-expanded="{{ $group2Active ? 'true' : 'false' }}">
                                <ion-icon name="chevron-down-outline" class="pnav-chevron"></ion-icon>
                            </button>
                        </div>
                        <div class="collapse {{ $group2Active ? 'show' : '' }}" id="navGroup2">
                            <div class="list-group list-group-flush rounded overflow-hidden">
                                <a href="{{ route('citizen.my_requests', 'secretaria-de-ayuntamiento') }}"
                                    class="list-group-item list-group-item-action {{ request()->segment(4) === 'secretaria-de-ayuntamiento' || str_starts_with($currentRoute, 'citizen.profile.identification_certificates') ? 'active' : '' }}">
                                    <ion-icon name="business-outline"></ion-icon> Secretaría de Ayuntamiento
                                </a>
                                <a href="{{ route('citizen.my_requests', 'economia') }}"
                                    class="list-group-item list-group-item-action {{ request()->segment(4) === 'economia' || $currentRoute === 'citizen.profile.requests' || str_starts_with($currentRoute, 'citizen.sare') ? 'active' : '' }}">
                                    <ion-icon name="storefront-outline"></ion-icon> Economía
                                </a>
                                <a href="{{ route('citizen.my_requests', 'tramites') }}"
                                    class="list-group-item list-group-item-action {{ request()->segment(4) === 'tramites' || str_starts_with($currentRoute, 'citizen.third_party') ? 'active' : '' }}">
                                    <ion-icon name="earth-outline"></ion-icon> Turismo
                                </a>
                                <a href="{{ route('citizen.profile.urban_dev_requests') }}"
                                    class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.urban_dev_requests' ? 'active' : '' }}">
                                    <ion-icon name="business-outline"></ion-icon> Desarrollo Urbano
                                </a>
                                <a href="{{ route('citizen.profile.applications') }}"
                                    class="list-group-item list-group-item-action {{ str_starts_with($currentRoute, 'citizen.profile.applications') ? 'active' : '' }}">
                                    <ion-icon name="briefcase-outline"></ion-icon> Solicitudes Vacantes
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- ── GROUP 3: TRÁMITES CON PAGO EN LÍNEA ───────────── --}}
                    <div>
                        <div class="d-flex mb-1">
                            <a href="{{ route('citizen.services.index') }}"
                                class="btn btn-warning fw-bold text-uppercase text-start flex-grow-1 rounded-end-0 pnav-header-link {{ $group3Active ? 'shadow-sm' : 'opacity-75' }}"
                                style="font-size:.78rem; line-height:1.3;">
                                Trámites Digitales con<br>Pago en Línea
                            </a>
                            <button type="button"
                                class="btn btn-warning rounded-start-0 px-3 pnav-toggle {{ $group3Active ? '' : 'collapsed' }}"
                                data-bs-toggle="collapse" data-bs-target="#navGroup3"
                                aria-expanded="{{ $group3Active ? 'true' : 'false' }}">
                                <ion-icon name="chevron-down-outline" class="pnav-chevron"></ion-icon>
                            </button>
                        </div>
                        <div class="collapse {{ $group3Active ? 'show' : '' }}" id="navGroup3">
                            <div class="list-group list-group-flush rounded overflow-hidden">
                                <a href="{{ route('citizen.my_requests', 'economia') }}"
                                    class="list-group-item list-group-item-action {{ request()->segment(4) === 'economia' || $currentRoute === 'citizen.profile.requests' || str_starts_with($currentRoute, 'citizen.sare') ? 'active' : '' }}">
                                    <ion-icon name="storefront-outline"></ion-icon> Economía
                                </a>
                                <a href="{{ route('citizen.my_requests', 'tramites') }}"
                                    class="list-group-item list-group-item-action {{ request()->segment(4) === 'tramites' || str_starts_with($currentRoute, 'citizen.third_party') ? 'active' : '' }}">
                                    <ion-icon name="earth-outline"></ion-icon> Turismo
                                </a>
                                <a href="{{ route('citizen.profile.urban_dev_requests') }}"
                                    class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.urban_dev_requests' ? 'active' : '' }}">
                                    <ion-icon name="business-outline"></ion-icon> Desarrollo Urbano
                                </a>
                                <a href="{{ route('citizen.services.index') }}"
                                    class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.services.index' ? 'active' : '' }}">
                                    <ion-icon name="storefront-outline"></ion-icon> Catálogo de Trámites
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- ── STANDALONE: MI CARRITO ─────────────────────────── --}}
                    <a href="{{ route('citizen.cart.index') }}"
                        class="btn btn-primary fw-bold w-100 {{ $currentRoute === 'citizen.cart.index' ? 'shadow-sm' : 'opacity-75' }}">
                        <ion-icon name="cart-outline"></ion-icon> Mi Carrito
                    </a>

                </div>
            </div>
        </div>
    @break

    @case('supplier')
        <div class="card profile-sidebar-nav">
            <div class="card-header d-md-none py-2">
                <button class="btn btn-outline-secondary btn-sm w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="#profileSidebarNav" aria-expanded="false" aria-controls="profileSidebarNav">
                    <ion-icon name="menu-outline"></ion-icon> Menú de navegación
                </button>
            </div>
            <div class="collapse d-md-block" id="profileSidebarNav">
                <div class="list-group list-group-flush wow fadeInUp">
                    <a href="{{ route('supplier.profile.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'supplier.profile.index' ? 'active' : '' }}">
                        <ion-icon name="home-outline"></ion-icon> Inicio
                    </a>
                    <a href="{{ route('supplier.profile.edit') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'supplier.profile.edit' ? 'active' : '' }}">
                        <ion-icon name="create-outline"></ion-icon> Editar Perfil
                    </a>
                    <a href="{{ route('citizen.profile.identification_certificates') }}"
                        class="list-group-item list-group-item-action {{ str_starts_with($currentRoute, 'citizen.profile.identification_certificates') ? 'active' : '' }}">
                        <ion-icon name="id-card-outline"></ion-icon> Constancias de Identificación
                    </a>
                    <a href="{{ route('supplier.alta.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'supplier.alta.index' || $currentRoute === 'supplier.alta.form' || $currentRoute === 'supplier.alta.show' ? 'active' : '' }}">
                        <ion-icon name="document-attach-outline"></ion-icon> Altas Proveedor
                    </a>
                    <a href="{{ route('supplier.bidding.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'supplier.bidding.index' || $currentRoute === 'supplier.bidding.show' ? 'active' : '' }}">
                        <ion-icon name="document-attach-outline"></ion-icon> Mis Licitaciones
                    </a>
                    <a href="{{ route('supplier.endorsement.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'supplier.endorsement.index' ? 'active' : '' }}">
                        <ion-icon name="receipt-outline"></ion-icon> Refrendo
                    </a>
                    <a href="{{ route('supplier.profile.notifications') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'supplier.profile.notifications' ? 'active' : '' }}">
                        <ion-icon name="notifications-outline"></ion-icon> Notificaciones
                    </a>
                    <a href="{{ route('supplier.profile.settings') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'supplier.profile.settings' ? 'active' : '' }}">
                        <ion-icon name="cog-outline"></ion-icon> Configuraciones
                    </a>
                </div>
            </div>
        </div>
    @break

    @default
        <div class="card profile-sidebar-nav">
            <div class="collapse d-md-block show" id="profileSidebarNav">
                <div class="list-group list-group-flush wow fadeInUp">
                    <a href="{{ route('citizen.profile.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.index' ? 'active' : '' }}">
                        <ion-icon name="home-outline"></ion-icon> Inicio
                    </a>
                    <a href="{{ route('citizen.profile.settings') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.settings' ? 'active' : '' }}">
                        <ion-icon name="cog-outline"></ion-icon> Configuraciones
                    </a>
                </div>
            </div>
        </div>
@endswitch
