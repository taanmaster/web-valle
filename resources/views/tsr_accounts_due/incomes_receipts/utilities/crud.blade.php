<div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-receipt fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-cash-register text-primary me-2"></i> Recibo de pago
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Completa los pasos para cerrar el cobro y emitir el recibo.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label for="date" class="form-label fw-semibold">Fecha:</label>
                    <input type="date" disabled wire:model="created_date" name="created_date" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>
                Captura montos por método de pago y el sistema calculará automáticamente el ingreso en número y texto.
            </div>
        </div>
    </div>

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row mb-3">
                    <h5 class="fw-semibold mb-3">Montos por método de pago</h5>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label for="total_cash" class="form-label fw-semibold">Ingreso en efectivo</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="total_cash" wire:model.live="total_cash" class="form-control" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="total_card" class="form-label fw-semibold">Ingreso en tarjeta</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="total_card" wire:model.live="total_card" class="form-control" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="total_check" class="form-label fw-semibold">Ingreso en cheque</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="total_check" wire:model.live="total_check" class="form-control" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="total_transfer" class="form-label fw-semibold">Ingreso en transferencia</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="total_transfer" wire:model.live="total_transfer" class="form-control" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="qty_integer" class="form-label fw-semibold">Ingreso (número)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="qty_integer" wire:model="qty_integer" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="qty_text" class="form-label fw-semibold">Ingreso (texto)</label>
                        <input type="text" name="qty_text" wire:model="qty_text" class="form-control" readonly required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="cashier_user" class="form-label fw-semibold">Usuario de Caja</label>
                        <input type="text" class="form-control" wire:model="cashier_user" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cashier" class="form-label fw-semibold">Caja</label>
                        <input type="text" class="form-control" wire:model="cashier" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label for="depositor" class="form-label fw-semibold">Depositante</label>
                        <input type="text" class="form-control" wire:model="depositor" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('account_due_incomes.show', $account_due_income_id) }}" class="btn btn-secondary btn-sm">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar recibo</button>
                </div>
            </div>
        </div>
    </form>
</div>
