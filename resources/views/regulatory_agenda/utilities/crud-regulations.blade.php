<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($regulation != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver regulación</h2>
                            @break

                            @case(2)
                                <h2>Editar regulación</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva regulación</h2>
                    @endif

                    <div class="d-flex">

                    </div>
                </div>
            </div>

            <h3>Información General</h3>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="name" class="col-form-label">Nombre preliminar de la regulación</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="name" wire:model="name" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="subject" class="col-form-label">Materia sobre la que versará la regulación</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="subject" wire:model="subject" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="problematic" class="col-form-label">Problemática que se pretende resolver con la
                            propuesta regulatoria</label>
                    </div>
                    <div class="col-md">
                        <textarea class="form-control" wire:model="problematic" name="problematic" rows="3"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="justification" class="col-form-label">Justificación para emitir la propuesta
                            regulatoria</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="justification" wire:model="justification" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-6">
                        <label for="presentation_date" class="form-label">Fecha tentativa de presentación</label>
                        <input type="date" class="form-control" wire:model="presentation_date"
                            name="presentation_date" @if ($mode == 1) disabled @endif>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Actualización, creación,
                            modificación o reforma</label>
                        <select class="form-select" name="type" wire:model.change="type"
                            @if ($mode == 1) disabled @endif>
                            <option selected>Seleccionar tipo</option>
                            <option value="Actualización">Actualización</option>
                            <option value="Creación">Creación</option>
                            <option value="Modificación">Modificación</option>
                            <option value="Reforma">Reforma</option>
                        </select>
                    </div>
                </div>

                @if ($type == 'Actualización' || $type == 'Modificación' || $type == 'Reforma')
                    <div class="row m-3">
                        <div class="col-md-4">
                            <label for="expeditions_date">Fecha de expedición de la regulación previa</label>
                            <input type="date" class="form-control" wire:model="expeditions_date"
                                name="expeditions_date" @if ($mode == 1) disabled @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="update_date">Fecha de nueva regulación</label>
                            <input type="date" class="form-control" wire:model="update_date" name="update_date"
                                @if ($mode == 1) disabled @endif>
                        </div>
                    </div>
                @endif

                <div class="row m-3">
                    {{--
                    <div class="col-md-4">
                        <label for="impact" class="form-label">Impacto</label>
                        <select class="form-select" name="impact" wire:model="impact"
                            @if ($mode == 1) disabled @endif>
                            <option selected>Seleccionar impacto</option>
                            <option value="Interno">Interno</option>
                            <option value="Externo">Externo</option>
                            <option value="No Aplica">No Aplica</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="beneficiaries" class="form-label">Beneficiarios</label>
                        <input type="text" class="form-control" wire:model="beneficiaries" name="beneficiaries"
                            @if ($mode == 1) disabled @endif>
                    </div>
                     --}}
                    <div class="col-md-4">
                        <label for="semester" class="form-label">Semestre al que corresponde la regulación</label>
                        <select class="form-select" name="semester" wire:model="semester"
                            @if ($mode == 1) disabled @endif>
                            <option selected>Seleccionar semestre</option>
                            <option value="1er Semestre">1er Semestre</option>
                            <option value="2do Semestre">2do Semestre</option>
                        </select>
                    </div>
                </div>

                @if ($mode != 1)
                    <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                        <a href="{{ route('regulatory_agenda.show', $dependency->id) }}" style="max-width: 110px"
                            class="btn btn-secondary btn-sm">Cancelar</a>
                        <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                            datos</button>
                    </div>
                @endif
            </form>


            @if ($mode != 2)
                @if ($regulation != null)
                    <div style="margin-top: 40px">
                        <h3>Buzón de sugerencias</h3>

                        @if ($suggestions->count() != 0)
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Regulación</th>
                                            <th>Creado</th>
                                            <th>Nombre</th>
                                            <th>Sugerencia</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($suggestions as $suggestion)
                                            <tr>
                                                <th>{{ $name }}</th>
                                                <td>
                                                    {{ $suggestion->created_at }}
                                                </td>
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
