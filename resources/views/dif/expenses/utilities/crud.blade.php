<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($expense != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver Salida</h2>
                            @break

                            @case(2)
                                <h2>Editar salida</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva salida</h2>
                    @endif
                </div>
            </div>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                @if ($mode == 1)
                    <div class="row align-items-center justify-content-end m-3">
                        <div class="col-md-2">
                            <label for="created_at" class="col-form-label">Fecha de Salida</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="created_at" value="{{ $expense->created_at->format('Y-m-d') }}"
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row align-items-center justify-content-end m-3">
                        <div class="col-md-2">
                            <label for="folio" class="col-form-label">Folio</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="folio" value="{{ $expense->id }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                @endif

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="type" class="col-form-label">Tipo de salida</label>
                    </div>
                    <div class="col-md">
                        <select name="type" id="type" wire:model="type" class="form-control"
                            @if ($mode == 1) disabled @endif>
                            <option value="Entrega ciudadano">Entrega ciudadano</option>
                            <option value="Venta">Venta</option>
                            <option value="Donación externa">Donación externa</option>
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="concept" class="col-form-label">Concepto</label>
                    </div>
                    <div class="col-md">
                        <select name="concept" id="concept" wire:model="concept" class="form-control"
                            @if ($mode == 1) disabled @endif>
                            <option>Seleccionar una opción</option>
                            @foreach ($concepts as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="recipient" class="col-form-label">Beneficiario</label>
                    </div>
                    <div class="col-md">
                        <input type="text" class="form-control mb-0" name="recipient" wire:model="recipient"
                            placeholder="Nombre Completo" @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('dif.expenses.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    @if ($mode != 1)
                        <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                            datos</button>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>
