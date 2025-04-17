<div>

    <div class="d-flex align-items-center justify-content-between mb-2">
        <h3>Regulaciones</h3>


        <div class="d-flex align-items-center" style="gap: 12px">
            <a class="btn btn-secondary" style="max-width: 180px" data-bs-toggle="collapse" href="#collapseExample"
                role="button" aria-expanded="false" aria-controls="collapseExample">
                Filtros
            </a>
            @if ($is_admin == 'true')
                <a href="{{ route('regulatory_agenda_regulation.create', $dependency->id) }}"
                    class="btn btn-primary new-fraction" style="min-width: 200px">Nueva
                    regulación</a>
            @endif
        </div>
    </div>

    <div class="collapse mb-4" id="collapseExample" wire:ignore>
        <div class="mb-3 d-flex g-2 align-items-end" style="gap: 12px">
            <div class="col">
                <label for="presentation_date" class="form-label">Fecha</label>
                <input type="date" id="presentation_date" class="form-control" wire:model.live="presentation_date">
            </div>

            <div class="col">
                <label for="semester" class="form-label">Semestre</label>
                <select id="semester" class="form-select" wire:model.live="semester">
                    <option value="">Todos</option>
                    <option value="1er Semestre">1er Semestre</option>
                    <option value="2do Semestre">2do Semestre</option>
                </select>
            </div>

            <div class="col">
                <label for="is_active" class="form-label">Activo</label>
                <select id="is_active" class="form-select" wire:model.live="is_active">
                    <option value="">Todos</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="col">
                <label for="type" class="form-label">Tipo</label>
                <select id="type" class="form-select" wire:model.live="type">
                    <option value="">Todos</option>
                    <option value="Creación">Creación</option>
                    <option value="Actualización">Actualización</option>
                    <!-- Agrega más opciones según tu tabla -->
                </select>
            </div>

            <button class="btn btn-outline-primary" style="max-width: 180px" wire:click="resetFilters">
                Reiniciar filtros
            </button>
        </div>
    </div>




    @if ($regulations->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay Regulaciones guardadas en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-uppercase new-fraction"><i
                                    class="fas fa-plus"></i> Nueva
                                Regulación</a>
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
                            <th>Materia</th>
                            <th>Problemática</th>
                            <th>Justificación</th>
                            <th>Fecha de presentación</th>
                            <th>Tipo</th>
                            <th>Impacto</th>
                            <th>Beneficiarios</th>
                            <th>Semestre</th>
                            @if ($is_admin == 'true')
                                <th>Acciones</th>
                            @endif

                            @if ($is_admin == 'false')
                                <th>

                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($regulations as $regulation)
                            <tr>
                                <td>
                                    {{ $regulation->name }}
                                </td>
                                <td>
                                    {{ $regulation->subject }}
                                </td>
                                <td>
                                    {{ $regulation->problematic }}
                                </td>
                                <td>
                                    {{ $regulation->justification }}
                                </td>
                                <td>
                                    {{ $regulation->presentation_date }}
                                </td>
                                <td>
                                    {{ $regulation->type }}
                                </td>
                                <td>
                                    {{ $regulation->impact }}
                                </td>
                                <td>
                                    {{ $regulation->beneficiaries }}
                                </td>
                                <td>
                                    {{ $regulation->semester }}
                                </td>
                                @if ($is_admin == 'true')
                                    <td>
                                        <a href="{{ route('regulatory_agenda_regulation.show', $regulation->id) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bx bx-edit"></i> Editar
                                        </a>
                                        <form method="POST"
                                            action="{{ route('rates_and_cost.destroy', $regulation->id) }}"
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
                                        <button class="btn btn-secondary new-suggestion" type="button"
                                            data-id="{{ $regulation->id }}"
                                            data-dep="{{ $dependency->id }}">Sugerencia</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center">
            {{ $regulations->links() }}
        </div>
    @endif


    <!-- Modal -->
    <div class="modal fade" id="suggestionModal" tabindex="-1" aria-labelledby="suggestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <livewire:regulatory-agenda.suggestion-modal :dependency="$dependency->id" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var suggestionModal = new bootstrap.Modal(document.getElementById('suggestionModal'), {
                keyboard: false
            });

            document.querySelectorAll('.new-suggestion').forEach(button => {
                button.addEventListener('click', function(e) {
                    const regulation = this.getAttribute('data-id');
                    suggestionModal.show();
                    Livewire.dispatch('newSuggestion', {
                        id: regulation
                    });
                });
            });
        </script>
    @endpush
</div>
