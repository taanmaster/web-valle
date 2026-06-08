<div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-id-card fa-2x text-primary"></i>
                        </div>
                        <div>
                            @if ($profile != null)
                                @switch($mode)
                                    @case(1)
                                        <h3 class="mb-1 fw-bold">Perfil de la cuenta</h3>
                                    @break

                                    @case(2)
                                        <h3 class="mb-1 fw-bold">Editar cuenta</h3>
                                    @break
                                @endswitch
                            @else
                                <h3 class="mb-1 fw-bold">Alta de nueva cuenta</h3>
                            @endif
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Captura y valida datos del contribuyente para habilitar su flujo de cobro.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    @if ($mode == 1)
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm create-p-btn" data-id="{{ $profile->id }}">
                            <i class="fas fa-plus me-1"></i> Generar nuevo entero
                        </a>
                    @endif
                    <a href="{{ route('account_due_profiles.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>
                @if ($mode == 1)
                    Verifica los datos del perfil antes de generar un entero provisional.
                @else
                    Completa los datos del contribuyente para crear la cuenta por cobrar.
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row align-items-center m-3">
                    <div class="col-md-4">
                        <label for="name" class="col-form-label">Nombre o razón social del contribuyente</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="name" wire:model="name" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="rfc_curp" class="col-form-label">RFC/CURP</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="rfc_curp" wire:model="rfc_curp" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="typeOfPerson" class="col-form-label">Tipo de persona</label>
                            </div>
                            <div class="col-md">
                                <select name="typeOfPerson" id="typeOfPerson" class="form-select" @if ($mode == 1) disabled @endif wire:model="typeOfPerson">
                                    <option selected>Seleccionar tipo de persona</option>
                                    <option value="Física">Física</option>
                                    <option value="Moral">Moral</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="address" class="col-form-label">Domicilio</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="address" wire:model="address" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="zipcode" class="col-form-label">Código Postal</label>
                            </div>
                            <div class="col-md">
                                <input type="number" name="zipcode" wire:model="zipcode" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="phone" class="col-form-label">Teléfono</label>
                            </div>
                            <div class="col-md">
                                <input type="phone" name="phone" wire:model="phone" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="email" class="col-form-label">Email</label>
                            </div>
                            <div class="col-md">
                                <input type="email" name="email" wire:model="email" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($mode == 1)
                    <div class="row align-items-center m-3">
                        <div class="col-md-6">
                            <label for="presentation_date" class="form-label">Fecha de alta</label>
                            <input type="date" class="form-control" disabled @if ($mode == 1)  value="{{ $created_date }}" @endif value="{{ $today }}">
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Clave única de la cuenta</label>
                            <input type="text" class="form-control" wire:model="code" name="code"
                                disabled>
                        </div>
                    </div>
                @endif

                @if ($mode != 1)
                    <div class="m-3 d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('account_due_profiles.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i> Guardar datos
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if ($mode == 1 && $profile->integers->count() > 0)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-file-invoice-dollar text-primary me-2"></i> Enteros provisionales de pago
                </h5>
            </div>
            <div class="card-body p-4">
                <livewire:tsr_accounts_due.provisional_integer.table :profile="$profile->id"/>
            </div>
        </div>
    @endif

    @if ($mode == 1)
        <!-- Modal -->
        <div class="modal fade" id="enteroModalProfile" tabindex="-1" aria-labelledby="enteroModalProfileLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5 text-white" id="enteroModalProfileLabel">Entero Provisional para Pago</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:tsr_accounts_due.profiles.integer-modal/>
            </div>
            </div>
        </div>
    @endif


    @push('scripts')
        <script>
            const enteroModalProfileElement = document.getElementById('enteroModalProfile');

            if (enteroModalProfileElement) {
                var enteroModalProfile = new bootstrap.Modal(enteroModalProfileElement, {
                    keyboard: false
                });

                document.querySelectorAll('.create-p-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        const profileId = this.getAttribute('data-id');
                        enteroModalProfile.show();
                        Livewire.dispatch('selectProfile', {
                            id: profileId
                        });
                    });
                });
            }
        </script>
    @endpush
</div>
