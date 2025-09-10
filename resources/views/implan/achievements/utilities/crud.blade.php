<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($achievement != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver logro</h2>
                            @break

                            @case(2)
                                <h2>Editar logro</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nuevo logro</h2>
                    @endif
                </div>
            </div>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row align-items-center justify-content-end m-3">
                    <div class="col-md-2">
                        <label for="published_at" class="col-form-label">Fecha de Ingreso</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="published_at" wire:model="published_at" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center justify-content-end m-3">
                    <div class="col-md-2">
                        <label for="is_active" class="col-form-label">Visible en Front</label>
                    </div>
                    <div class="col-md-4">
                        <select name="is_active" wire:model="is_active" id="is_active" class="form-control"
                            @if ($mode == 1) disabled @endif>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="title" class="col-form-label">Nombre del Logro</label>
                    </div>
                    <div class="col-md">
                        <input type="text" class="form-control" wire:model="title" name="title"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="description" class="col-form-label">Descripción</label>
                    </div>
                    <div class="col-md">
                        <textarea name="description" id="description" rows="3" wire:model="description"
                            @if ($mode == 1) disabled @endif class="form-control"></textarea>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-2">
                        <label for="file" class="col-form-label">Archivo</label>
                    </div>
                    <div class="col-md">
                        <input type="file" wire:model="file" name="file"
                            @if ($mode == 1) disabled @endif class="form-control">
                    </div>
                </div>

                <div class="row m-3 align-items-center">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="hex" class="col-form-label">Color</label>
                            </div>
                            <div class="col-md">
                                <input type="color" name="hex" id="hex" wire:model="hex"
                                    @if ($mode == 1) disabled @endif class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="image" class="col-form-label">Imagen</label>
                            </div>
                            <div class="col-md">
                                <input type="file" @if ($mode == 1) disabled @endif
                                    wire:model="image" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('implan.achievements.index') }}" style="max-width: 110px"
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
