@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="notifications-outline" class="align-middle"></ion-icon> 
                                Notificaciones y Mensajes
                            </h5>
                            <div>
                                @if($messages->where('status', 'unread')->count() > 0)
                                    <span class="badge bg-danger">
                                        {{ $messages->where('status', 'unread')->count() }} nuevos
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <ion-icon name="checkmark-circle-outline" class="align-middle me-2"></ion-icon>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Acordeón de Mensajes -->
                        <div class="accordion" id="messagesAccordion">
                            <!-- Mensajes Activos -->
                            <div class="accordion-item border rounded-3 mb-3 shadow-sm">
                                <h2 class="accordion-header" id="headingActive">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActive" aria-expanded="true" aria-controls="collapseActive">
                                        <ion-icon name="mail-outline" class="me-2"></ion-icon>
                                        <strong>Mensajes Activos</strong>
                                        <span class="badge bg-primary ms-2">{{ $messages->count() }}</span>
                                        @if($messages->where('status', 'unread')->count() > 0)
                                            <span class="badge bg-danger ms-2">
                                                {{ $messages->where('status', 'unread')->count() }} sin leer
                                            </span>
                                        @endif
                                    </button>
                                </h2>
                                <div id="collapseActive" class="accordion-collapse collapse show" aria-labelledby="headingActive" data-bs-parent="#messagesAccordion">
                                    <div class="accordion-body p-0">
                                        @if($messages->count() > 0)
                                            <div class="list-group list-group-flush">
                                                @foreach($messages as $message)
                                                    <div class="list-group-item list-group-item-action message-item {{ $message->status === 'unread' ? 'message-unread' : '' }}" 
                                                         data-message-id="{{ $message->id }}">
                                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="message-icon me-3">
                                                                        <ion-icon name="business-outline" class="text-primary"></ion-icon>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-1 fw-bold">
                                                                            Administración - Alta de Proveedor
                                                                            @if($message->status === 'unread')
                                                                                <span class="badge bg-danger ms-2">Nuevo</span>
                                                                            @endif
                                                                        </h6>
                                                                        <small class="text-muted">
                                                                            <ion-icon name="time-outline" class="align-middle"></ion-icon>
                                                                            {{ $message->created_at->diffForHumans() }}
                                                                            <span class="mx-2">|</span>
                                                                            <ion-icon name="calendar-outline" class="align-middle"></ion-icon>
                                                                            {{ $message->created_at->format('d/m/Y H:i') }}
                                                                        </small>
                                                                    </div>
                                                                </div>

                                                                @if($message->supplier)
                                                                    <div class="mb-2 ps-5">
                                                                        <span class="badge bg-info bg-opacity-10 text-info">
                                                                            <ion-icon name="document-text-outline" class="align-middle"></ion-icon>
                                                                            Folio: {{ $message->supplier->registration_number }}
                                                                        </span>
                                                                        <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">
                                                                            <ion-icon name="pricetag-outline" class="align-middle"></ion-icon>
                                                                            Estado: 
                                                                            @switch($message->supplier->status)
                                                                                @case('solicitud')
                                                                                    Solicitud
                                                                                    @break
                                                                                @case('validacion')
                                                                                    Validación
                                                                                    @break
                                                                                @case('aprobacion')
                                                                                    Aprobación
                                                                                    @break
                                                                                @case('pago_pendiente')
                                                                                    Pago Pendiente
                                                                                    @break
                                                                                @case('padron_activo')
                                                                                    Padrón Activo
                                                                                    @break
                                                                                @default
                                                                                    {{ ucfirst($message->supplier->status) }}
                                                                            @endswitch
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                <div class="message-content ps-5">
                                                                    <p class="mb-0">{{ $message->message }}</p>
                                                                </div>
                                                            </div>

                                                            <div class="ms-3">
                                                                <form action="{{ route('supplier.messages.archive', $message->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" 
                                                                            class="btn btn-sm btn-outline-secondary" 
                                                                            data-bs-toggle="tooltip" 
                                                                            title="Archivar mensaje">
                                                                        <ion-icon name="archive-outline"></ion-icon>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <ion-icon name="mail-open-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                                <p class="text-muted mt-3 mb-0">No tienes mensajes activos</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Mensajes Archivados -->
                            <div class="accordion-item border rounded-3 shadow-sm">
                                <h2 class="accordion-header" id="headingArchived">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseArchived" aria-expanded="false" aria-controls="collapseArchived">
                                        <ion-icon name="archive-outline" class="me-2"></ion-icon>
                                        <strong>Mensajes Archivados</strong>
                                        <span class="badge bg-secondary ms-2">{{ $archivedMessages->count() }}</span>
                                    </button>
                                </h2>
                                <div id="collapseArchived" class="accordion-collapse collapse" aria-labelledby="headingArchived" data-bs-parent="#messagesAccordion">
                                    <div class="accordion-body p-0">
                                        @if($archivedMessages->count() > 0)
                                            <div class="list-group list-group-flush">
                                                @foreach($archivedMessages as $message)
                                                    <div class="list-group-item list-group-item-action message-archived">
                                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="message-icon me-3">
                                                                        <ion-icon name="business-outline" class="text-secondary"></ion-icon>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-1 fw-bold text-muted">
                                                                            Administración - Alta de Proveedor
                                                                            <span class="badge bg-secondary ms-2">Archivado</span>
                                                                        </h6>
                                                                        <small class="text-muted">
                                                                            <ion-icon name="time-outline" class="align-middle"></ion-icon>
                                                                            {{ $message->created_at->diffForHumans() }}
                                                                            <span class="mx-2">|</span>
                                                                            <ion-icon name="calendar-outline" class="align-middle"></ion-icon>
                                                                            {{ $message->created_at->format('d/m/Y H:i') }}
                                                                        </small>
                                                                    </div>
                                                                </div>

                                                                @if($message->supplier)
                                                                    <div class="mb-2 ps-5">
                                                                        <span class="badge bg-info bg-opacity-10 text-info">
                                                                            <ion-icon name="document-text-outline" class="align-middle"></ion-icon>
                                                                            Folio: {{ $message->supplier->registration_number }}
                                                                        </span>
                                                                        <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">
                                                                            <ion-icon name="pricetag-outline" class="align-middle"></ion-icon>
                                                                            Estado: 
                                                                            @switch($message->supplier->status)
                                                                                @case('solicitud')
                                                                                    Solicitud
                                                                                    @break
                                                                                @case('validacion')
                                                                                    Validación
                                                                                    @break
                                                                                @case('aprobacion')
                                                                                    Aprobación
                                                                                    @break
                                                                                @case('pago_pendiente')
                                                                                    Pago Pendiente
                                                                                    @break
                                                                                @case('padron_activo')
                                                                                    Padrón Activo
                                                                                    @break
                                                                                @default
                                                                                    {{ ucfirst($message->supplier->status) }}
                                                                            @endswitch
                                                                        </span>
                                                                    </div>
                                                                @endif

                                                                <div class="message-content ps-5">
                                                                    <p class="mb-0 text-muted">{{ $message->message }}</p>
                                                                </div>
                                                            </div>

                                                            <div class="ms-3">
                                                                <form action="{{ route('supplier.messages.unarchive', $message->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" 
                                                                            class="btn btn-sm btn-outline-primary" 
                                                                            data-bs-toggle="tooltip" 
                                                                            title="Restaurar mensaje">
                                                                        <ion-icon name="arrow-undo-outline"></ion-icon>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <ion-icon name="folder-open-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                                <p class="text-muted mt-3 mb-0">No tienes mensajes archivados</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
    /* Estilos personalizados para mensajes */
    .message-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .message-item:hover {
        background-color: #f8f9fa;
        border-left-color: #0d6efd;
        transform: translateX(3px);
    }

    .message-unread {
        background-color: #e7f3ff;
        border-left-color: #0d6efd;
    }

    .message-unread:hover {
        background-color: #d0e7ff;
    }

    .message-archived {
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .message-archived:hover {
        opacity: 1;
        background-color: #f8f9fa;
    }

    .message-icon {
        font-size: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
    }

    .message-archived .message-icon {
        background-color: rgba(108, 117, 125, 0.1);
    }

    .message-content {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 0.5rem;
        border-left: 3px solid #0d6efd;
    }

    .message-archived .message-content {
        border-left-color: #6c757d;
    }

    .accordion-button:not(.collapsed) {
        background-color: #e7f3ff;
        color: #0d6efd;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }

    .accordion-item {
        transition: all 0.3s ease;
    }

    .accordion-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .badge {
        font-weight: 500;
    }

    ion-icon {
        font-size: 1.2em;
        vertical-align: middle;
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }

    .list-group-item:last-child {
        border-bottom: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Marcar mensaje como leído al hacer clic
        document.querySelectorAll('.message-item.message-unread').forEach(function(item) {
            item.addEventListener('click', function(e) {
                // No marcar como leído si se hace clic en el botón de archivar
                if (e.target.closest('button')) {
                    return;
                }

                const messageId = this.dataset.messageId;
                
                // Hacer petición AJAX para marcar como leído
                fetch(`/proveedores/mensajes/${messageId}/marcar-leido`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remover la clase de no leído
                        this.classList.remove('message-unread');
                        
                        // Remover el badge de "Nuevo"
                        const newBadge = this.querySelector('.badge.bg-danger');
                        if (newBadge && newBadge.textContent === 'Nuevo') {
                            newBadge.remove();
                        }

                        // Actualizar contador en el acordeón
                        updateUnreadCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        function updateUnreadCount() {
            const unreadCount = document.querySelectorAll('.message-item.message-unread').length;
            const unreadBadges = document.querySelectorAll('.badge.bg-danger');
            
            unreadBadges.forEach(badge => {
                if (badge.textContent.includes('sin leer') || badge.textContent.includes('nuevos')) {
                    if (unreadCount > 0) {
                        badge.textContent = unreadCount + (badge.textContent.includes('sin leer') ? ' sin leer' : ' nuevos');
                    } else {
                        badge.remove();
                    }
                }
            });
        }
    });
</script>
@endsection
