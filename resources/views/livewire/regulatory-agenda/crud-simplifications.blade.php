<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($simplification != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver simplificación</h2>
                            @break

                            @case(2)
                                <h2>Editar simplificación</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva simplificación</h2>
                    @endif
                </div>
            </div>

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <!-- Datos Generales -->
                <h3>Datos Generales</h3>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="unique_code" class="col-form-label">Homoclave</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="unique_code" wire:model="unique_code" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="name" class="col-form-label">Nombre del trámite o servicio <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="name" wire:model="name" class="form-control"
                            @if ($mode == 1) disabled @endif required>
                    </div>
                </div>

                <div class="row align-items-start m-3">
                    <div class="col-md-2">
                        <label class="col-form-label">Criterios</label>
                    </div>
                    <div class="col-md">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="high_frequency" id="high_frequency"
                                @if ($mode == 1) disabled @endif>
                            <label class="form-check-label" for="high_frequency">
                                I. Alta Frecuencia
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="priority_grupos" id="priority_grupos"
                                @if ($mode == 1) disabled @endif>
                            <label class="form-check-label" for="priority_grupos">
                                II. Grupos Prioritarios
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="high_burocratic_cost" id="high_burocratic_cost"
                                @if ($mode == 1) disabled @endif>
                            <label class="form-check-label" for="high_burocratic_cost">
                                III. Alto Costo Burocrático
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="in_person" id="in_person"
                                @if ($mode == 1) disabled @endif>
                            <label class="form-check-label" for="in_person">
                                IV. Presencialidad
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="air_commitment" id="air_commitment"
                                @if ($mode == 1) disabled @endif>
                            <label class="form-check-label" for="air_commitment">
                                V. Compromiso AIR
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="others" id="others"
                                @if ($mode == 1) disabled @endif>
                            <label class="form-check-label" for="others">
                                VI. (Otros) Autoridad
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="description" class="col-form-label">Descripción de selección</label>
                    </div>
                    <div class="col-md">
                        <textarea class="form-control" wire:model="description" name="description" rows="4"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="brief" class="col-form-label">Justificación breve</label>
                    </div>
                    <div class="col-md">
                        <textarea class="form-control" wire:model="brief" name="brief" rows="3"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <!-- Plan de Acción -->
                <h3 class="mt-4">Plan de Acción</h3>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="diagnostic" class="col-form-label">Diagnóstico actual</label>
                    </div>
                    <div class="col-md">
                        <textarea class="form-control" wire:model="diagnostic" name="diagnostic" rows="3"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="simplification_action" class="col-form-label">Acción de Simplificación</label>
                    </div>
                    <div class="col-md">
                        <textarea class="form-control" wire:model="simplification_action" name="simplification_action" rows="3"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="digitalizacion_action" class="col-form-label">Acción de Digitalización</label>
                    </div>
                    <div class="col-md">
                        <textarea class="form-control" wire:model="digitalizacion_action" name="digitalizacion_action" rows="3"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="final_goal" class="col-form-label">Meta Final</label>
                    </div>
                    <div class="col-md">
                        <textarea class="form-control" wire:model="final_goal" name="final_goal" rows="3"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <!-- Cronograma y Responsables -->
                <h3 class="mt-4">Cronograma y Responsables</h3>

                <div class="row m-3">
                    <div class="col-md-6">
                        <label for="date_start" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" wire:model="date_start" name="date_start"
                            @if ($mode == 1) disabled @endif>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">Fecha de Término</label>
                        <input type="date" class="form-control" wire:model="end_date" name="end_date"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-4">
                        <label for="progress_percentage" class="form-label">Porcentaje de Avance</label>
                        <input type="text" class="form-control" wire:model="progress_percentage" name="progress_percentage"
                            placeholder="0-100" @if ($mode == 1) disabled @endif>
                    </div>
                    <div class="col-md-4">
                        <label for="responsible" class="form-label">Responsable</label>
                        <input type="text" class="form-control" wire:model="responsible" name="responsible"
                            @if ($mode == 1) disabled @endif>
                    </div>
                    <div class="col-md-4">
                        <label for="semester" class="form-label">Semestre</label>
                        <select class="form-select" name="semester" wire:model="semester"
                            @if ($mode == 1) disabled @endif>
                            <option value="">Seleccionar semestre</option>
                            <option value="1er Semestre">1er Semestre</option>
                            <option value="2do Semestre">2do Semestre</option>
                        </select>
                    </div>
                </div>

                @if ($mode != 1)
                    <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                        <a href="{{ route('agenda_dependencies.show', $dependency->id) }}" style="max-width: 110px"
                            class="btn btn-secondary btn-sm">Cancelar</a>
                        <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                            datos</button>
                    </div>
                @endif
            </form>

            @if ($mode != 2)
                @if ($simplification != null)
                    <div style="margin-top: 40px">
                        <h3>Buzón de sugerencias</h3>

                        @if ($suggestions->count() != 0)
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Simplificación</th>
                                            <th>Creado</th>
                                            <th>Nombre</th>
                                            <th>Sugerencia</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($suggestions as $suggestion)
                                            <tr>
                                                <th>{{ $name }}</th>
                                                <td>{{ $suggestion->created_at }}</td>
                                                <td>{{ $suggestion->name }}</td>
                                                <td>{{ $suggestion->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                {{ $suggestions->links() }}
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="text-center" style="padding:80px 0px 100px 0px;">
                                                <img src="{{ asset('assets/images/empty.svg') }}"
                                                    class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                                                <h4>¡No hay sugerencias guardadas en la base de datos!</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
