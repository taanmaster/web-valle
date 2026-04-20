@php
    $userRole = null;
    if (auth()->check()) {
        $userRole = auth()->user()->roles->first()?->name ?? 'citizen';
    }

    // Obtener la ruta actual para marcar el item activo
    $currentRoute = request()->route()->getName();
@endphp

@switch($userRole)
    @case('citizen')
        <div class="card profile-sidebar-nav">
            {{-- Botón visible solo en móvil --}}
            <div class="card-header d-md-none py-2">
                <button class="btn btn-outline-secondary btn-sm w-100" type="button"
                    data-bs-toggle="collapse" data-bs-target="#profileSidebarNav" aria-expanded="false"
                    aria-controls="profileSidebarNav">
                    <ion-icon name="menu-outline"></ion-icon> Menú de navegación
                </button>
            </div>
            <div class="collapse d-md-block" id="profileSidebarNav">
                <div class="list-group list-group-flush wow fadeInUp">
                    <a href="{{ route('citizen.profile.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.index' ? 'active' : '' }}">
                        <ion-icon name="home-outline"></ion-icon> Inicio
                    </a>
                    
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

                    {{--  
                    <a href="{{ route('citizen.profile.identification_certificates') }}"
                        class="list-group-item list-group-item-action {{ str_starts_with($currentRoute, 'citizen.profile.identification_certificates') ? 'active' : '' }}">
                        <ion-icon name="id-card-outline"></ion-icon> Constancias de Identificación
                    </a>
                    <a href="{{ route('citizen.my_requests') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.my_requests' || $currentRoute === 'citizen.profile.requests' || str_starts_with($currentRoute, 'citizen.third_party') ? 'active' : '' }}">
                        <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes
                    </a>
                    --}}

                    <a href="{{ route('citizen.profile.urban_dev_requests') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.profile.urban_dev_requests' ? 'active' : '' }}">
                        <ion-icon name="business-outline"></ion-icon> Trámites Desarrollo Urbano
                    </a>
                    <a href="{{ route('citizen.profile.applications') }}"
                        class="list-group-item list-group-item-action {{ str_starts_with($currentRoute, 'citizen.profile.applications') ? 'active' : '' }}">
                        <ion-icon name="briefcase-outline"></ion-icon> Solicitudes Vacantes
                    </a>
                    <a href="{{ route('citizen.summons.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.summons.index' ? 'active' : '' }}">
                        <ion-icon name="document-text-outline"></ion-icon> Citatorios
                    </a>
                    <a href="{{ route('citizen.appointments.index') }}"
                        class="list-group-item list-group-item-action {{ str_starts_with($currentRoute, 'citizen.appointments') ? 'active' : '' }}">
                        <ion-icon name="calendar-outline"></ion-icon> Mis Citas a Trámites
                    </a>

                    <div class="list-group-item bg-light fw-semibold text-muted small py-1 px-3">
                        <ion-icon name="card-outline"></ion-icon> Servicios en Línea
                    </div>
                    <a href="{{ route('citizen.services.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.services.index' ? 'active' : '' }}">
                        <ion-icon name="storefront-outline"></ion-icon> Servicios Municipales
                    </a>
                    <a href="{{ route('citizen.cart.index') }}"
                        class="list-group-item list-group-item-action {{ $currentRoute === 'citizen.cart.index' ? 'active' : '' }}">
                        <ion-icon name="cart-outline"></ion-icon> Mi Carrito
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
        </div>
    @break

    @case('supplier')
        <div class="card profile-sidebar-nav">
            {{-- Botón visible solo en móvil --}}
            <div class="card-header d-md-none py-2">
                <button class="btn btn-outline-secondary btn-sm w-100" type="button"
                    data-bs-toggle="collapse" data-bs-target="#profileSidebarNav" aria-expanded="false"
                    aria-controls="profileSidebarNav">
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
        {{-- Navegación por defecto si no tiene rol o no está autenticado --}}
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
