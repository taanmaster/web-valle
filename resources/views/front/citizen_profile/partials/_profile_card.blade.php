<!-- Header del perfil -->
<div class="card profile-header-card wow fadeInUp mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="citizen-avatar me-3">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="mb-1" style="color: #2d3748; font-weight: 600;">{{ Auth::user()->name }}</h4>
                        <p class="text-muted mb-1">
                            <i class="bx bx-envelope me-1"></i>{{ Auth::user()->email }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="bx bx-user me-1"></i>Ciudadano registrado
                            <span class="status-badge ms-2">Activo</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="member-since">
                    <p class="text-muted mb-1" style="font-size: 12px;">Miembro desde:</p>
                    <h6 class="mb-0 date">{{ Auth::user()->created_at->format('d/m/Y') }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>