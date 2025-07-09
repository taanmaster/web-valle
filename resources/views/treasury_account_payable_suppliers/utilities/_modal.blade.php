<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Proveedor</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <livewire:tap-supplier.crud />

            {{--
            <form method="POST" action="{{ route('treasury_account_payable_suppliers.store') }}"
                enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="row">
                        <!-- Información básica -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rfc" class="form-label">RFC <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="rfc" name="rfc">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>

                        <!-- Información de la cuenta bancaria -->
                        <div class="col-md-6 mb-3">
                            <label for="account_name" class="form-label">Nombre de la Cuenta <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="account_name" name="account_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="account_number" class="form-label">Número de Cuenta <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="account_number" name="account_number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bank_name" class="form-label">Banco <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dependency_name" class="form-label">Dependencia <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="dependency_name" name="dependency_name">
                        </div>


                        <div class="mb-3 col-md-12">
                            <h5><i class="fas fa-folder"></i> Dependencias</h5>
                            <p class="text-muted">Selecciona los programas que pertenecen a esta coordinación:</p>

                            <!-- Buscador de programas -->
                            <div class="form-group mb-3">
                                <label for="program-search" class="form-label">
                                    <i class="fas fa-search me-1"></i>Buscar dependencia
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search search-icon"></i>
                                    </span>
                                    <input type="text" id="program-search" class="form-control"
                                        placeholder="Nombre de dependencia" autocomplete="off"
                                        aria-describedby="search-help">
                                </div>
                            </div>

                            <!-- Programas seleccionados -->
                            <div id="selected-programs" class="mb-3" style="display: none;">
                                <h6><i class="fas fa-check-circle text-success"></i> Programas Seleccionados:</h6>
                                <div id="selected-programs-list" class="d-flex flex-wrap gap-2"></div>
                            </div>

                            <!-- Contenedor de programas -->
                            <div class="programs-container"
                                style="max-height: 300px; overflow-y: auto; padding: 15px;">
                                <div id="programs-list">
                                    <!-- Los programas se cargarán aquí dinámicamente -->
                                    <div class="text-center py-4">
                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">Buscar Programas</h6>
                                        <p class="text-muted mb-0">Comienza a escribir para buscar programas
                                            disponibles...</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="selectAllVisiblePrograms()">
                                    <i class="fas fa-check-double"></i> Seleccionar Visibles
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="deselectAllPrograms()">
                                    <i class="fas fa-times"></i> Deseleccionar Todos
                                </button>
                            </div>

                            <!-- Inputs ocultos para enviar al controlador -->
                            <div id="hidden-inputs"></div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-12 mb-3">
                            <label for="status" class="form-label">Estado <span
                                    class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                                <option value="payed">Pagado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
                </div>
            </form>
             --}}
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
