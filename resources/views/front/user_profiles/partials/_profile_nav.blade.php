@php
    $userRole = null;
    if (auth()->check()) {
        $userRole = auth()->user()->roles->first()?->name ?? 'citizen';
    }

    // Obtener la ruta actual para marcar el tab activo
    $currentRoute = request()->route()->getName();
@endphp

@switch($userRole)
    @case('citizen')
        <ul class="nav nav-tabs card-header-tabs" id="citizenProfileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.profile.index' ? 'active' : '' }}"
                    href="{{ route('citizen.profile.index') }}" id="inicio-tab" role="tab">
                    <ion-icon name="home-outline"></ion-icon> Inicio
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.profile.edit' ? 'active' : '' }}"
                    href="{{ route('citizen.profile.edit') }}" id="perfil-tab" role="tab">
                    <ion-icon name="create-outline"></ion-icon> Editar Perfil
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ str_starts_with($currentRoute, 'citizen.profile.identification_certificates') ? 'active' : '' }}"
                    href="{{ route('citizen.profile.identification_certificates') }}" id="constancias-tab" role="tab">
                    <ion-icon name="id-card-outline"></ion-icon> Constancias de Identificación
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.my_requests' || $currentRoute === 'citizen.profile.requests' || str_starts_with($currentRoute, 'citizen.third_party') ? 'active' : '' }}"
                    href="{{ route('citizen.my_requests') }}" id="solicitudes-tab" role="tab">
                    <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.profile.urban_dev_requests' ? 'active' : '' }}"
                    href="{{ route('citizen.profile.urban_dev_requests') }}" id="solicitudes-tab" role="tab">
                    <ion-icon name="file-tray-full-outline"></ion-icon> Trámites Desarrollo Urbano
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.profile.applications' ? 'active' : '' }}"
                    href="{{ route('citizen.profile.applications') }}" id="citas-tab" role="tab">
                    <ion-icon name="briefcase-outline"></ion-icon> Solicitudes Vacantes
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.summons.index' ? 'active' : '' }}"
                    href="{{ route('citizen.summons.index') }}" id="citatorios-tab" role="tab">
                    <ion-icon name="document-text-outline"></ion-icon> Citatorios
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.profile.settings' ? 'active' : '' }}"
                    href="{{ route('citizen.profile.settings') }}" id="configuraciones-tab" role="tab">
                    <ion-icon name="cog-outline"></ion-icon> Configuraciones
                </a>
            </li>
        </ul>
    @break

    @case('supplier')
        <ul class="nav nav-tabs card-header-tabs" id="supplierProfileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'supplier.profile.index' ? 'active' : '' }}"
                    href="{{ route('supplier.profile.index') }}" id="inicio-tab" role="tab">
                    <ion-icon name="home-outline"></ion-icon> Inicio
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'supplier.profile.edit' ? 'active' : '' }}"
                    href="{{ route('supplier.profile.edit') }}" id="perfil-tab" role="tab">
                    <ion-icon name="create-outline"></ion-icon> Editar Perfil
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ str_starts_with($currentRoute, 'citizen.profile.identification_certificates') ? 'active' : '' }}"
                    href="{{ route('citizen.profile.identification_certificates') }}" id="constancias-tab" role="tab">
                    <ion-icon name="id-card-outline"></ion-icon> Constancias de Identificación
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'supplier.alta.index' || $currentRoute === 'supplier.alta.form' || $currentRoute === 'supplier.alta.show' ? 'active' : '' }}"
                    href="{{ route('supplier.alta.index') }}" id="altas-tab" role="tab">
                    <ion-icon name="document-attach-outline"></ion-icon> Altas Proveedor
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'supplier.bidding.index' || $currentRoute === 'supplier.bidding.show' ? 'active' : '' }}"
                    href="{{ route('supplier.bidding.index') }}" id="altas-tab" role="tab">
                    <ion-icon name="document-attach-outline"></ion-icon> Mis Licitaciones
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'supplier.endorsement.index' ? 'active' : '' }}"
                    href="{{ route('supplier.endorsement.index') }}" id="refrendo-tab" role="tab">
                    <ion-icon name="receipt-outline"></ion-icon> Refrendo
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'supplier.profile.notifications' ? 'active' : '' }}"
                    href="{{ route('supplier.profile.notifications') }}" id="notificaciones-tab" role="tab">
                    <ion-icon name="notifications-outline"></ion-icon> Notificaciones
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'supplier.profile.settings' ? 'active' : '' }}"
                    href="{{ route('supplier.profile.settings') }}" id="configuraciones-tab" role="tab">
                    <ion-icon name="cog-outline"></ion-icon> Configuraciones
                </a>
            </li>
        </ul>
    @break

    @default
        {{-- Navegación por defecto si no tiene rol o no está autenticado --}}
        <ul class="nav nav-tabs card-header-tabs" id="defaultProfileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.profile.index' ? 'active' : '' }}"
                    href="{{ route('citizen.profile.index') }}" id="inicio-tab" role="tab">
                    <ion-icon name="home-outline"></ion-icon> Inicio
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $currentRoute === 'citizen.profile.settings' ? 'active' : '' }}"
                    href="{{ route('citizen.profile.settings') }}" id="configuraciones-tab" role="tab">
                    <ion-icon name="cog-outline"></ion-icon> Configuraciones
                </a>
            </li>
        </ul>
@endswitch
