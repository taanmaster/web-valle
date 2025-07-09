<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="">Rango de fechas</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>
    </div>


    <div class="bg-secondary-subtle p-4" style="border-top-left-radius: 12px; border-top-right-radius:12px">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card p-2 text-center" style="border-radius: 12px">
                    <h3> {{ $total_accounts }}</h3>
                    <p>Total de cuentas</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-2 text-center" style="border-radius: 12px">
                    <h3> {{ $programados->count() }}</h3>
                    <p>Cuentas programadas a pago</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-2 text-center" style="border-radius: 12px">
                    <h3> {{ $vencidos->count() }}</h3>
                    <p>Cuentas vencidas</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-2 text-center" style="border-radius: 12px">
                    <h3> {{ $pagados->count() }}</h3>
                    <p>Cuentas pagadas</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Pagos programados</h5>
                    </div>
                    <div class="card-body">
                        @if ($programados->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Programación de pago</th>
                                            <th>Cantidad</th>
                                            <th>Tipo</th>
                                            <th>Dependencia</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($programados as $programado)
                                            <tr>
                                                <td>
                                                    {{ $programado->created_at }}
                                                </td>
                                                <td>
                                                    {{ $programado->ammount }}
                                                </td>
                                                <td>
                                                    {{ $programado->type }}
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Pagos vencidos</h5>
                    </div>
                    <div class="card-body">
                        @if ($vencidos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Programación de pago</th>
                                            <th>Cantidad</th>
                                            <th>Tipo</th>
                                            <th>Dependencia</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($vencidos as $vencido)
                                            <tr>
                                                <td>
                                                    {{ $vencido->created_at }}
                                                </td>
                                                <td>
                                                    {{ $vencido->ammount }}
                                                </td>
                                                <td>
                                                    {{ $vencido->type }}
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Pagos realizados</h5>
                    </div>
                    <div class="card-body">
                        @if ($pagados->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Programación de pago</th>
                                            <th>Cantidad</th>
                                            <th>Tipo</th>
                                            <th>Dependencia</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($pagados as $pagado)
                                            <tr>
                                                <td>
                                                    {{ $pagado->created_at }}
                                                </td>
                                                <td>
                                                    {{ $pagado->ammount }}
                                                </td>
                                                <td>
                                                    {{ $pagado->type }}
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
