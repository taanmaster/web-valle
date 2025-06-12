<div class="mt-5">
    <h4 class="mb-4">Lista de Eventos</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Fechas</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($events as $event)
                <tr>
                    <td style="min-width: 200px;">
                        <div class="d-flex">
                            <div class="event-dot bg-{{ $event->is_in_progress ? 'success' : 'primary' }} me-2 mt-2"></div>
                            <div>
                                <strong>{{ $event->name }}</strong>
                                @if($event->blog_url)
                                <div><a href="{{ $event->blog_url }}" target="_blank" class="text-primary small">
                                    <i class="bx bx-link-external me-1"></i>Ver página del evento
                                </a></div>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td style="min-width: 180px;">
                        <div class="small mb-1">
                            <i class="bx bx-calendar me-1"></i>
                            <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y') }}
                        </div>
                        <div class="small mb-1">
                            <i class="bx bx-time me-1"></i>
                            <strong>Hora:</strong> {{ \Carbon\Carbon::parse($event->date_start)->format('h:i a') }}
                        </div>
                        @if($event->date_end)
                        <div class="small">
                            <i class="bx bx-calendar-check me-1"></i>
                            <strong>Fin:</strong> {{ \Carbon\Carbon::parse($event->date_end)->format('d/m/Y h:i a') }}
                        </div>
                        @endif
                    </td>
                    
                    <td style="min-width: 150px;">
                        <i class="bx bx-map me-1"></i>{{ $event->location }}
                    </td>
                    
                    <td>
                        @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($event->date_start)))
                            <span class="badge bg-info">Próximo</span>
                        @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($event->date_start)) && (!$event->date_end || \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($event->date_end))))
                            <span class="badge bg-success">En curso</span>
                        @else
                            <span class="badge bg-secondary">Finalizado</span>
                        @endif
                        
                        @if($event->is_active)
                            <span class="badge bg-primary">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    
                    <td class="text-end" style="min-width: 200px;">
                        <div class="d-flex gap-2">
                            {{-- 
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Ver Detalle">
                                Ver Detalle
                            </a>
                            --}}

                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Editar">
                                Editar
                            </a>
                            
                            <form method="POST" action="{{ route('events.status', $event->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $event->id }}">
                                <button type="submit" class="btn btn-sm {{ $event->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" data-bs-toggle="tooltip" title="{{ $event->is_active ? 'Desactivar' : 'Activar' }}">
                                    <i class="bx {{ $event->is_active ? 'bx-power-off' : 'bx-power-on' }}"></i> Cambiar Estatus
                                </button>
                            </form>

                            <form method="POST" action="{{ route('events.destroy', $event->id) }}" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Eliminar Evento">
                                    <i class="bx bx-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <div class="text-muted">
                            <i class="bx bx-calendar-x fs-2 mb-2"></i>
                            <p>No hay eventos registrados</p>
                            <a href="{{ route('events.create') }}" class="btn btn-sm btn-primary">Crear un evento</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>                    
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $events->links() }}
    </div>
</div>

<style>
    .event-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .delete-form button {
        transition: all 0.2s;
    }
    
    .delete-form button:hover {
        background-color: var(--bs-danger);
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Confirmación para eliminar eventos
        var deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                if (!confirm('¿Estás seguro de que deseas eliminar este evento?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
