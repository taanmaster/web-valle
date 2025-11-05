@php
    // Obtener rol del usuario
    // Si el usuario no tiene un rol asignado, se considera 'citizen' por defecto
    $userRole = auth()->user()->roles->first()?->name ?? 'citizen';
    
    // Obtener información adicional del usuario
    $userInfo = App\Models\UserInfo::where('user_id', auth()->id())->first();
    $additionalData = $userInfo->additional_data ?? [];
    
    // Determinar el nombre a mostrar según el tipo de usuario
    $displayName = auth()->user()->name;
    if ($userRole === 'supplier' && isset($additionalData['person_type'])) {
        // Si es persona moral, mostrar el nombre de la empresa
        if ($additionalData['person_type'] === 'moral' && !empty($additionalData['company_name'])) {
            $displayName = $additionalData['company_name'];
        }
        // Si es persona física, se muestra el nombre del usuario por defecto
    }
    
    // Configuración dinámica según el rol
    // Se puede expandir para otros roles si es necesario, agregando más casos al arreglo
    $profileConfig = [
        'citizen' => [
            'label' => 'Ciudadano Registrado',
            'icon' => 'bx-user',
            'badge_color' => 'bg-success',
            'avatar_color' => '#4299e1',
        ],
        'supplier' => [
            'label' => 'Proveedor Registrado',
            'icon' => 'bx-briefcase',
            'badge_color' => 'bg-primary',
            'avatar_color' => '#805ad5',
        ]
    ];
    
    // Obtener configuración actual o usar ciudadano por defecto
    $config = $profileConfig[$userRole] ?? $profileConfig['citizen'];
    
    // Información adicional específica por rol
    $extraInfo = '';
    switch ($userRole) {
        case 'supplier':
            $padronStatus = $additionalData['padron_status'] ?? null;
            if ($padronStatus === 'con_padron') {
                $extraInfo = '<span class="badge bg-success ms-2"><i class="bx bx-check-circle"></i> Con Padrón</span>';
            } elseif ($padronStatus === 'sin_padron') {
                $extraInfo = '<span class="badge bg-warning ms-2"><i class="bx bx-info-circle"></i> Sin Padrón</span>';
            }
            break;
        
        /* Los siguientes son ejemplos de cómo se podría expandir para otros roles */
         case 'inspector':
            $extraInfo = '<span class="badge bg-info ms-2"><i class="bx bx-shield"></i> Inspector</span>';
            break;
        case 'economist':
            $extraInfo = '<span class="badge bg-info ms-2"><i class="bx bx-line-chart"></i> Área Económica</span>';
            break;
        
        case 'admin':
            $extraInfo = '<span class="badge bg-danger ms-2"><i class="bx bx-shield-alt-2"></i> Admin</span>';
            break;
        /* Fin de Ejemplos */
    }
@endphp

<!-- Header del perfil -->
<div class="card profile-header-card wow fadeInUp mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="citizen-avatar me-3" style="background-color: {{ $config['avatar_color'] }};">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="mb-1" style="color: #2d3748; font-weight: 600;">{{ $displayName }}</h4>
                        <p class="text-muted mb-1">
                            <i class="bx bx-envelope me-1"></i>{{ Auth::user()->email }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="{{ $config['icon'] }} me-1"></i>{{ $config['label'] }}
                            <span class="status-badge {{ $config['badge_color'] }} ms-2">Activo</span>
                            {!! $extraInfo !!}
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

<style>
    .citizen-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>