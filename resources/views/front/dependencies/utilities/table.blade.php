<div>
    <div class="row mb-4 align-items-center">
        <div class="col-md-3">
            <label for="period" class="col-form-label">Periodo</label>
            <select name="period" id="period" wire:model.live="period" class="form-control">
                <option value="" disabled selected>Seleccione un periodo</option>
                <option value="Trimestral">Trimestral</option>
                <option value="Anual">Anual</option>
                <option value="Semestral">Semestral</option>
                <option value="Trianual">Trianual</option>
                <option value="Mensual">Mensual</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="type" class="col-form-label">Tipo</label>
            <select name="type" id="type" wire:model.live="type" class="form-control">
                <option value="" disabled selected>Seleccione un tipo</option>
                <option value="Especifica">Especifica</option>
                <option value="Común">Común</option>
                <option value="Aplicabilidad">Tabla de Aplicabilidad</option>
                <option value="Clasificados">Índice de expedientes clasificados</option>
                <option value="Graficas">Gráficas Informativas</option>
                <option value="Proactiva">Transparencia Proactiva</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <button wire:click="resetFilters" class="btn btn-outline-secondary btn-sm">Restablecer Filtros</button>
        </div>
    </div>
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
                <div class="col-md-3" style="margin-bottom: 30px;">
                    <a href="{{ route('obligation.detail', [$dependency, $obligation->slug]) }}"
                        class="card px-3 py-1 wow fadeInUp h-100 d-flex flex-column justify-content-center">
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
</div>
