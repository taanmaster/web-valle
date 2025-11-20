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

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}


                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="title" class="col-form-label" required>Título</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="title" wire:model="title" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="regulation_type" class="col-form-label">Tipo de regulación</label>
                    </div>
                    <div class="col-md">
                        <select name="regulation_type" id="regulation_type" wire:model="regulation_type"
                            class="form-select" @if ($mode == 1) disabled @endif>
                            <option selected>Seleccione un tipo</option>
                            <option value="Acuerdo">Acuerdo</option>
                            <option value="Código">Código</option>
                            <option value="Disposición de carácter">Disposición de carácter</option>
                            <option value="Disposición Técnica">Disposición Técnica</option>
                            <option value="Lineamiento">Lineamiento</option>
                            <option value="Manual">Manual</option>
                            <option value="Programa">Programa</option>
                            <option value="Protocolo">Protocolo</option>
                            <option value="Reglamento">Reglamento</option>
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="publication_type" class="col-form-label">Tipo de publicación</label>
                    </div>
                    <div class="col-md">
                        <select name="publication_type" id="publication_type" wire:model="publication_type"
                            class="form-select" @if ($mode == 1) disabled @endif>
                            <option selected>Seleccione un tipo</option>
                            <option value="Nueva">Nueva</option>
                            <option value="Abrogada">Abrogada</option>
                            <option value="Reforma">Reforma</option>
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="publication_date" class="col-form-label">Publicación Periodico Oficial</label>
                    </div>
                    <div class="col-md">
                        <input type="date" name="publication_date" wire:model="publication_date" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="file" class="col-form-label">Archivo</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="file" wire:model="file" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="pdf_file" class="col-form-label">Archivo PDF</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="pdf_file" wire:model="pdf_file" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                {{--
                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="word_file" class="col-form-label">Archivo Word</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="word_file" wire:model="word_file" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>
                 --}}

                <div class="d-flex align-items-center justify-content-end" style="gap: 12px">

                    <a href="{{ route('institucional_development.regulations.index') }}"
                        class="btn btn-sm btn-secondary" style="max-width: 100px">Regresar</a>


                    @if ($mode != 1)
                        <button class="btn btn-sm btn-primary" type="submit" style="max-width: 100px">Guardar</button>
                    @endif
                </div>
            </form>
        </div>
    </div>


    @if ($regulation != null && $regulation->logs->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <h3>Historial de cambios</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Acción</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($regulation->logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d/m/Y') }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->user ? $log->user->name : 'Desconocido' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif
</div>
