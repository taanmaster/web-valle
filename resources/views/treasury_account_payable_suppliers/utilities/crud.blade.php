<div>
    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="modal-body pd-25">
            <div class="row">
                <!-- Información básica -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" wire:model="name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="rfc" class="form-label">RFC <span class="text-info tx-12">(Opcional)</span></label>
                    <input type="text" class="form-control" id="rfc" name="rfc" wire:model="rfc">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Correo Electrónico <span
                            class="text-info tx-12">(Opcional)</span></label>
                    <input type="email" class="form-control" id="email" name="email" wire:model="email">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Teléfono <span
                            class="text-info tx-12">(Opcional)</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" wire:model="phone">
                </div>

                <!-- Información de la cuenta bancaria -->
                <div class="col-md-6 mb-3">
                    <label for="account_name" class="form-label">Nombre de la Cuenta <span
                            class="text-info tx-12">(Opcional)</span></label>
                    <input type="text" class="form-control" id="account_name" name="account_name"
                        wire:model="account_name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="account_number" class="form-label">Número de Cuenta <span
                            class="text-info tx-12">(Opcional)</span></label>
                    <input type="text" class="form-control" id="account_number" name="account_number"
                        wire:model="account_number">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bank_name" class="form-label">Banco <span
                            class="text-info tx-12">(Opcional)</span></label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" wire:model="bank_name">
                </div>

                <!-- Estado -->
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Estado <span class="text-danger tx-12">*</span></label>
                    <select class="form-control" id="status" name="status" required wire:model="status">
                        <option value="">Seleccionar estado</option>
                        <option value="active">Activo</option>
                        <option value="inactive">Inactivo</option>
                        <option value="payed">Pagado</option>
                    </select>
                </div>

                <div class="mb-3 col-md-12">
                    <h5><i class="fas fa-folder"></i> Dependencias</h5>
                    <p class="text-muted">Selecciona los dependencias que pertenecen a esta coordinación:</p>

                    <!-- Buscador de dependencias -->
                    <div class="form-group mb-3">
                        <label for="program-search" class="form-label">
                            <i class="fas fa-search me-1"></i>Buscar dependencia
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search search-icon"></i>
                            </span>
                            <input type="text" id="searchDependencies" name="searchDependencies"
                                wire:model.live="searchDependencies" class="form-control"
                                placeholder="Nombre de dependencia" autocomplete="off" aria-describedby="search-help">
                        </div>
                    </div>

                    <!-- dependencias seleccionados -->
                    @if (!empty($selectedDependencies))
                        <div id="selected-programs" class="mb-3">
                            <h6><i class="fas fa-check-circle text-success"></i> Dependencias Seleccionadas:</h6>
                            <div id="selected-programs-list" class="d-flex flex-wrap gap-2">
                                @foreach ($selectedDependencies as $dependencyS)
                                    <span class="badge bg-secondary me-1 mb-1 selected-programs-badge"
                                        style="font-size: 0.85em; padding: 0.5em 0.75em;">
                                        <i class="fas fa-folder me-1"></i>{{ $dependencyS->name }}
                                        <button type="button" class="btn-close btn-close-white ms-2"
                                            style="font-size: 0.7em; padding: 0; mix-blend-mode: color-dodge;"
                                            title="Remover dependencia"
                                            wire:click="deleteDependency({{ $dependencyS->id }})"></button>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Contenedor de dependencias -->
                    <div class="programs-container" style="max-height: 300px; overflow-y: auto; padding: 15px;">
                        <div id="programs-list">
                            @if ($dependencies != null)
                                <div class="alert alert-info alert-sm py-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i> {{ count($dependencies) }} dependencias
                                    encontradas
                                </div>

                                @foreach ($dependencies as $dependency)
                                    <div class="form-check mb-3 program-item">
                                        <input type="checkbox" class="form-check-input program-checkbox"
                                            id="selectDependency" name="selectDependency"
                                            value="{{ $dependency->id }}" wire:model.live="selectDependency">
                                        <label class="form-check-label w-100" for="">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <strong class="d-block">{{ $dependency->name }}</strong>
                                                    <small class="text-muted d-block mt-1">
                                                        {{ $dependency->description }}
                                                    </small>
                                                </div>
                                                <i class="fas fa-check-circle text-success ms-2"></i>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <!-- Los dependencias se cargarán aquí dinámicamente -->
                                <div class="text-center py-4">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Buscar dependencias</h6>
                                    <p class="text-muted mb-0">Comienza a escribir para buscar dependencias
                                        disponibles...</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
        </div>
    </form>
</div>
