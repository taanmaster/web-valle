<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($profile != null)
                        @switch($mode)
                            @case(1)
                                <h2>Perfil de la cuenta</h2>
                            @break

                            @case(2)
                                <h2>Editar cuenta</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Alta de nueva cuenta</h2>
                    @endif
                </div>
                <div class="col-3 text-end">
                    @if ($mode == 1)

                    <!-- Button trigger modal -->
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary create-p-btn" data-id="{{ $profile->id }}">
                        Generar nuevo entero
                    </a>

                    <a href="{{ route('account_due_profiles.index') }}" class="btn btn-secondary btn-sm"
                        style="max-width: 110px">Regresar</a>
                    @endif
                </div>
            </div>
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
                    <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                        <a href="{{ route('account_due_profiles.index') }}" style="max-width: 110px"
                            class="btn btn-secondary btn-sm">Cancelar</a>
                        <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                            datos</button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if ($mode == 1 && $profile->integers->count() > 0)
    <div class="mt-4">
        <h5>Enteros provisionales de Pago</h5>
        <livewire:tsr_accounts_due.provisional_integer.table :profile="$profile->id"/>
    </div>
    @endif

    @if ($mode == 1)
        <!-- Modal -->
        <div class="modal fade" id="enteroModalProfile" tabindex="-1" aria-labelledby="enteroModalProfileLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="enteroModalProfileLabel">Entero Provisional para Pago</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:tsr_accounts_due.profiles.integer-modal/>
            </div>
            </div>
        </div>
    @endif


    @push('scripts')
        <script>
            var enteroModalProfile = new bootstrap.Modal(document.getElementById('enteroModalProfile'), {
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
        </script>
    @endpush
</div>
