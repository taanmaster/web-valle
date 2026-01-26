<div>
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h3>Simplificaciones</h3>

        <div class="d-flex align-items-center" style="gap: 12px">
            <a class="btn btn-secondary" style="max-width: 180px" data-bs-toggle="collapse" href="#collapseSimplifications"
                role="button" aria-expanded="false" aria-controls="collapseSimplifications">
                Filtros
            </a>

            @if ($is_admin == 'true')
                <a href="{{ route('simplification_agenda.create', $dependency->id) }}"
                    class="btn btn-primary" style="min-width: 200px">Nueva Simplificación</a>
            @endif
        </div>
    </div>

    <div class="collapse mb-4" id="collapseSimplifications" wire:ignore>
        <div class="mb-3 d-flex g-2 align-items-end" style="gap: 12px">
            <div class="col">
                <label for="date_start" class="form-label">Fecha de Inicio</label>
                <input type="date" id="date_start" class="form-control" wire:model.live="date_start">
            </div>

            <div class="col">
                <label for="semester_simp" class="form-label">Semestre</label>
                <select id="semester_simp" class="form-select" wire:model.live="semester">
                    <option value="">Todos</option>
                    <option value="1er Semestre">1er Semestre</option>
                    <option value="2do Semestre">2do Semestre</option>
                </select>
            </div>

            @if ($is_admin == 'true')
                <div class="col">
                    <label for="is_active_simp" class="form-label">Activo</label>
                    <select id="is_active_simp" class="form-select" wire:model.live="is_active">
                        <option value="">Todos</option>
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
            @endif

            <div class="col">
                <label for="high_frequency" class="form-label">Alta Frecuencia</label>
                <select id="high_frequency" class="form-select" wire:model.live="high_frequency">
                    <option value="">Todos</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <button class="btn btn-outline-primary" style="max-width: 180px" wire:click="resetFilters">
                Reiniciar filtros
            </button>
        </div>
    </div>

    @if ($simplifications->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay Simplificaciones guardadas en la base de datos!</h4>

                            @if ($is_admin == 'true')
                                <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                <a href="{{ route('simplification_agenda.create', $dependency->id) }}"
                                    class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nueva
                                    Simplificación</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Homoclave</th>
                            <th>Criterios</th>
                            <th>Justificación</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Término</th>
                            <th>Semestre</th>

                            @if ($is_admin == 'true')
                                <th>Status</th>
                                <th>Acciones</th>
                            @endif

                            @if ($is_admin == 'false')
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($simplifications as $simplification)
                            <tr>
                                <td>{{ $simplification->name }}</td>
                                <td>{{ $simplification->unique_code }}</td>
                                <td>
                                    @if ($simplification->high_frequency)
                                        <span class="badge bg-primary">Alta Frecuencia</span>
                                    @endif
                                    @if ($simplification->priority_grupos)
                                        <span class="badge bg-info">Grupos Prioritarios</span>
                                    @endif
                                    @if ($simplification->high_burocratic_cost)
                                        <span class="badge bg-warning">Alto Costo Burocrático</span>
                                    @endif
                                    @if ($simplification->in_person)
                                        <span class="badge bg-secondary">Presencialidad</span>
                                    @endif
                                    @if ($simplification->air_commitment)
                                        <span class="badge bg-success">Compromiso AIR</span>
                                    @endif
                                    @if ($simplification->others)
                                        <span class="badge bg-dark">Otros</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($simplification->brief, 50) }}</td>
                                <td>{{ $simplification->date_start ? $simplification->date_start->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $simplification->end_date ? $simplification->end_date->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $simplification->semester }}</td>

                                @if ($is_admin == 'true')
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                id="checkSimpSwitch{{ $simplification->id }}"
                                                wire:change="toggleActive({{ $simplification->id }})"
                                                @if ($simplification->is_active) checked @endif>
                                            <label class="form-check-label" for="checkSimpSwitch{{ $simplification->id }}">
                                                Visible
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('simplification_agenda.show', $simplification->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show"></i> Ver Detalle
                                        </a>
                                        <button class="btn btn-sm btn-outline-info show-simplification-detail" 
                                            type="button"
                                            data-id="{{ $simplification->id }}">
                                            <i class="bx bx-info-circle"></i> Vista Rápida
                                        </button>
                                        <a href="{{ route('simplification_agenda.edit', $simplification->id) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bx bx-edit"></i> Editar
                                        </a>
                                        <form method="POST"
                                            action="{{ route('simplification_agenda.destroy', $simplification->id) }}"
                                            style="display: inline-block;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                @endif

                                @if ($is_admin == 'false')
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary show-simplification-detail" 
                                            type="button"
                                            data-id="{{ $simplification->id }}">
                                            <i class="bx bx-info-circle"></i> Mostrar Información
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center">
            {{ $simplifications->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <!-- Modal de Detalle de Simplificación -->
    <div class="modal fade" id="simplificationDetailModal" tabindex="-1" aria-labelledby="simplificationDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="simplificationDetailModalLabel">Detalle de Simplificación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="simplificationDetailContent">
                    <!-- El contenido se cargará dinámicamente -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Sugerencia -->
    <div class="modal fade" id="simplificationSuggestionModal" tabindex="-1" aria-labelledby="simplificationSuggestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <livewire:regulatory-agenda.simplification-suggestion-modal :dependency="$dependency->id" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var simplificationDetailModal = new bootstrap.Modal(document.getElementById('simplificationDetailModal'), {
                keyboard: false
            });
            
            var simplificationSuggestionModal = new bootstrap.Modal(document.getElementById('simplificationSuggestionModal'), {
                keyboard: false
            });

            // Mostrar detalle de simplificación
            document.addEventListener('click', function(e) {
                if (e.target.closest('.show-simplification-detail')) {
                    const button = e.target.closest('.show-simplification-detail');
                    const simplificationId = button.getAttribute('data-id');
                    const isAdmin = '{{ $is_admin }}';
                    
                    // Buscar la simplificación en los datos
                    const simplifications = @json($simplifications->items());
                    const simplification = simplifications.find(s => s.id == simplificationId);
                    
                    if (simplification) {
                        let html = `
                            <h4>Datos Generales</h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Nombre:</strong> ${simplification.name || 'N/A'}
                                </div>
                                <div class="col-md-6">
                                    <strong>Homoclave:</strong> ${simplification.unique_code || 'N/A'}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>Criterios:</strong><br>
                                    ${simplification.high_frequency ? '<span class="badge bg-primary me-1">Alta Frecuencia</span>' : ''}
                                    ${simplification.priority_grupos ? '<span class="badge bg-info me-1">Grupos Prioritarios</span>' : ''}
                                    ${simplification.high_burocratic_cost ? '<span class="badge bg-warning me-1">Alto Costo Burocrático</span>' : ''}
                                    ${simplification.in_person ? '<span class="badge bg-secondary me-1">Presencialidad</span>' : ''}
                                    ${simplification.air_commitment ? '<span class="badge bg-success me-1">Compromiso AIR</span>' : ''}
                                    ${simplification.others ? '<span class="badge bg-dark me-1">Otros</span>' : ''}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>Descripción de selección:</strong><br>
                                    ${simplification.description || 'N/A'}
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <strong>Justificación breve:</strong><br>
                                    ${simplification.brief || 'N/A'}
                                </div>
                            </div>
                            
                            <h4 class="mt-4">Plan de Acción</h4>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>Diagnóstico actual:</strong><br>
                                    ${simplification.diagnostic || 'N/A'}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>Acción de Simplificación:</strong><br>
                                    ${simplification.simplification_action || 'N/A'}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>Acción de Digitalización:</strong><br>
                                    ${simplification.digitalizacion_action || 'N/A'}
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <strong>Meta Final:</strong><br>
                                    ${simplification.final_goal || 'N/A'}
                                </div>
                            </div>
                            
                            <h4 class="mt-4">Cronograma y Responsables</h4>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Fecha de Inicio:</strong><br>
                                    ${simplification.date_start ? new Date(simplification.date_start).toLocaleDateString('es-MX') : 'N/A'}
                                </div>
                                <div class="col-md-4">
                                    <strong>Fecha de Término:</strong><br>
                                    ${simplification.end_date ? new Date(simplification.end_date).toLocaleDateString('es-MX') : 'N/A'}
                                </div>
                                <div class="col-md-4">
                                    <strong>Porcentaje de Avance:</strong><br>
                                    ${simplification.progress_percentage || '0'}%
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Responsable:</strong><br>
                                    ${simplification.responsible || 'N/A'}
                                </div>
                                <div class="col-md-6">
                                    <strong>Semestre:</strong><br>
                                    ${simplification.semester || 'N/A'}
                                </div>
                            </div>
                        `;
                        
                        // Solo mostrar el botón de sugerencia si NO es admin
                        if (isAdmin === 'false') {
                            html += `
                                <div class="row mt-4">
                                    <div class="col-12 text-end">
                                        <button class="btn btn-primary new-simplification-suggestion" 
                                            type="button"
                                            data-id="${simplification.id}"
                                            data-dep="{{ $dependency->id }}">
                                            <i class="bx bx-comment-add"></i> Enviar Sugerencia
                                        </button>
                                    </div>
                                </div>
                            `;
                        }
                        
                        document.getElementById('simplificationDetailContent').innerHTML = html;
                        simplificationDetailModal.show();
                    }
                }
            });

            // Abrir modal de sugerencia desde el detalle o desde la tabla
            document.addEventListener('click', function(e) {
                if (e.target.closest('.new-simplification-suggestion')) {
                    const button = e.target.closest('.new-simplification-suggestion');
                    const simplificationId = button.getAttribute('data-id');
                    
                    // Cerrar modal de detalle si está abierto
                    simplificationDetailModal.hide();
                    
                    // Abrir modal de sugerencia
                    simplificationSuggestionModal.show();
                    Livewire.dispatch('newSimplificationSuggestion', {
                        id: simplificationId
                    });
                }
            });
        </script>
    @endpush
</div>
