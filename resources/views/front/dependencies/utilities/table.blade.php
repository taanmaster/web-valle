<div>
    <div class="row mb-4 align-items-center">

        @if ($mode != 1)
            <div class="col-md-3">
                <label for="selectedObligation" class="col-form-label">Obligación</label>
                <select name="selectedObligation" id="selectedObligation" wire:model.live="selectedObligation"
                    class="form-control">
                    <option value="" disabled selected>Seleccione una obligación</option>
                    @foreach ($obligations as $obligation)
                        <option value="{{ $obligation->id }}">{{ $obligation->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif



        <div class="col-md-3">
            <label for="year" class="col-form-label">Año</label>
            <select name="year" id="year" wire:model.live="year" class="form-control">
                <option value="" disabled selected>Seleccione un año</option>
                @foreach ($years as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="period" class="col-form-label">Periodo</label>
            <select name="period" id="period" wire:model.live="period" class="form-control">
                <option value="" disabled selected>Seleccione un periodo</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <button wire:click="resetFilters" class="btn btn-outline-secondary btn-sm">Restablecer Filtros</button>
        </div>
    </div>

    @if ($period != null || $selectedObligation != null || $year != null)
        @if ($documents->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    <p class="text-muted">No hay documentos disponibles.</p>
                    <p class="text-muted">Por favor, ajusta los filtros de búsqueda.</p>
                </div>
            </div>
        @else
            <p>Se encontraron <strong>{{ $documents->count() }}</strong> resultados.</p>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Obligación</th>
                            <th>Nombre</th>
                            <th>Período</th>
                            <th>Rubro</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td>{{ $document->year }}</td>
                                <td>{{ $document->obligation->name }}</td>
                                <td>{{ $document->name }}</td>
                                <td>{{ $document->obligation->update_period }} {{ $document->period }}</td>
                                <td>{{ $document->obligation->type }}</td>
                                <td>
                                    @if ($document->s3_asset_url != null)
                                        <a href="{{ $document->s3_asset_url }}" target="_blank"
                                            class="btn btn-primary d-flex align-items-center justify-content-between gap-2"
                                            style="width: fit-content">
                                        @else
                                            <a href="{{ asset('files/documents/' . $document->filename) }}"
                                                target="_blank"
                                                class="btn btn-primary d-flex align-items-center justify-content-between gap-2"
                                                style="width: fit-content">
                                    @endif
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                        </path>
                                    </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @else
        @if ($obligations->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    <p class="text-muted">No hay obligaciones disponibles.</p>
                    <p class="text-muted">Por favor, ajusta los filtros de búsqueda.</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($obligations as $obligation)
                    <div class="col-md-3">
                        <a href="{{ route('obligation.detail', [$dependency, $obligation->slug]) }}"
                            class="card px-3 py-1 wow fadeInUp d-flex flex-column justify-content-center"
                            style="min-height: 160px">
                            <div class="d-flex align-items-center" style="gap: 30px">
                                @if ($obligation->icon != null)
                                    <img src="{{ asset('front/img/icons/' . $obligation->icon) }}" alt=""
                                        style="height: 30px; width:auto">
                                @endif
                                <p class="mb-0">{{ $obligation->name }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
