<div>
    <div class="row mb-3 align-items-center">
        <div class="col-md-4">
            <label for="">Buscar por nombre</label>
            <input type="text" class="form-control" placeholder="Ingrese un nombre" wire:model.live="title" />
        </div>

        <div class="col-md-3">
            <label for="">Elegir tipo de publicación</label>
            <select class="form-select" aria-label="Default select example" wire:model.live="publication_type">
                <option selected>Seleccione un tipo</option>
                <option value="Nueva">Nueva</option>
                <option value="Abrogada">Abrogada</option>
                <option value="Reforma">Reforma</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="">Elegir un tipo de regulación</label>
            <select class="form-select" aria-label="Default select example" wire:model.live="regulation_type">
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

        <div class="col-md-2 text-end">
            @if ($title !== '' || $regulation_type !== '' || $publication_type !== '')
                <button class="btn btn-secondary btn-sm" wire:click="resetFilters">Limpiar Filtros</button>
            @endif

            @if ($mode === 0)
                <a href="{{ route('institucional_development.regulations.create') }}" class="btn btn-primary btn-sm"
                    wire:click="resetFilters">Nueva</a>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Título</th>
                    <th>Tipo de Regulación</th>
                    <th>Tipo de Publicación</th>
                    <th>Ficha</th>
                    <th>PDF</th>
                    <th>Word</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($regulations as $regulation)
                        <td>
                            <a href="{{ route('institucional_development.regulations.show', $regulation->id) }}"
                                class="btn btn-primary" data-toggle="tooltip" data-original-title="Ver Detalle">
                                Ver Detalle
                            </a>
                        </td>
                        <td>{{ $regulation->title }}</td>
                        <td>{{ $regulation->regulation_type }}</td>
                        <td>{{ $regulation->publication_type }}</td>
                        <td>
                            @if ($regulation->file)
                                <a href="{{ $regulation->file }}" target="_blank"
                                    class="btn btn-secondary">Ver Ficha</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if ($regulation->pdf_file)
                                <a href="{{ $regulation->pdf_file }}" target="_blank"
                                    class="btn btn-secondary">Ver PDF</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if ($regulation->word_file)
                                <a href="{{ $regulation->word_file }}" target="_blank"
                                    class="btn btn-secondary">Ver Word</a>
                            @else
                                N/A
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <div class="align-items-center mt-4">
        {{ $regulations->links('pagination::bootstrap-5') }}
    </div>
</div>
