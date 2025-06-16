<div>

    <div class="row mb-4">
        <div class="col-md-3">
            <label for="">No. de caja</label>
            <input type="text" class="form-control" wire:model.live="bank">
        </div>

        <div class="col-md-3">
            <label for="">Cajero</label>
            <input type="text" class="form-control" wire:model.live="code">
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <label for="">Rango de fechas</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>

        <div class="col-md">
            <label for="">Cuenta bancaria</label>
            <input type="text" class="form-control" wire:model.live="bank">
        </div>

        <div class="col-md">
            <label for="">Método de pago</label>
            <input type="text" class="form-control" wire:model.live="bank">
        </div>

        <div class="col-md">
            <label for="">Usuario responsable</label>
            <input type="text" class="form-control" wire:model.live="bank">
        </div>

        <div class="col-md">
            <label for="">Filtrar por...</label>
            <input type="text" class="form-control" wire:model.live="bank">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Recibo</th>
                    <th>Fecha y hora</th>
                    <th>Contribuyente</th>
                    <th>Concepto de cobro</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incomes as $income)
                    <tr>
                        <td>{{ $income->id }}</td>
                        <td>{{ $income->created_at->format('d/m/Y h:m') }}</td>
                        <td>{{ $income->income->name }}</td>
                        <td>{{ $income->income->concept }}</td>
                        <td>$ {{ number_format($income->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        {{ $incomes->links() }}
    </div>

    <div class="row justify-content-end align-items-center my-3">
        <div class="col-md-2 text-end">
            <a href="" class="btn btn-sm btn-secondary">Guardar</a>
        </div>
        <div class="col-md-2 text-end">
            <a href="" class="btn btn-sm btn-primary">Exportar</a>
        </div>
    </div>
</div>
