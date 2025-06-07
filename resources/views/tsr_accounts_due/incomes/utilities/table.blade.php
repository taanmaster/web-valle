<div>
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="">Fecha de creación</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>

        <div class="col-md-4">
            <label for="">Clave única de la cuenta</label>
            <input type="text" class="form-control" wire:model.live="code">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#Recibo</th>
                    <th>Fecha y hora</th>
                    <th>Contribuyente</th>
                    <th>Concepto de cobro</th>
                    <th>Importe</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incomes as $income)
                    <tr>
                        <td>{{ $income->id }}</td>
                        <td>{{ $income->created_at->format('d/m/Y hh:mm') }}</td>
                        <td>{{ $income->name }}</td>
                        <td>{{ $income->concept }}</td>
                        <td>{{ number_format($income->qty_integer, 2) }}</td>
                        <td>
                            <a href="{{ route('account_due_profiles.show', $income->id) }}"
                                class="btn btn-primary btn-sm">Ver</a>
                            <a href="{{ route('account_due_profiles.edit', $income->id) }}"
                                class="btn btn-secondary btn-sm">Editar</a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal_{{ $income->id }}">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
