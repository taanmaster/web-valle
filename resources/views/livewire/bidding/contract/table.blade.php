<div class="mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Contratos y Modificatorios</h3>
        <button data-bs-toggle="modal" data-bs-target="#contractModal"
            class="btn btn-sm btn-primary btn-uppercase new-proposal" style="max-width: fit-content"
            data-id="{{ $bidding->id }}"><i class="fas fa-plus"></i> Agregar propuesta</button>
    </div>


    @if ($contracts->count() != null)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Fecha de creación</th>
                        <th>Archivo</th>
                        <th>Tipo</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de fin</th>
                        <th>Entregables</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                        <tr>
                            <td>{{ $contract->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($contract->file != null)
                                    <a href="{{ $contract->file }}" class="btn btn-sm btn-light"
                                        style="max-width: fit-content; max-height:fit-content" target="_blanck">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="#000000" viewBox="0 0 256 256">
                                            <path
                                                d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                            </path>
                                        </svg>
                                        {{ $contract->file_name }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $contract->type }}</td>
                            <td>{{ $contract->start_date }}</td>
                            <td>{{ $contract->end_date }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-uppercase new-check"
                                    data-id="{{ $contract->id }}">Agregar checklist</a>

                                @if ($contract->checklists->count() != null)
                                    @foreach ($contract->checklists as $checklist)
                                        <div class="d-flex align-items-center my-2" style="gap: 8px">

                                            <a href="javascript:void(0)" class="btn btn-sm btn-light disabled"
                                                style="max-width: fit-content; max-height:fit-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path
                                                        d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                                    </path>
                                                </svg>
                                                {{ $checklist->file_name }}
                                            </a>


                                            <a href="javascript:void(0)"
                                                class="btn btn-sm btn-outline-secondary edit-check-btn"
                                                data-id="{{ $checklist->id }}" style="max-width: fit-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path
                                                        d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.68,147.31,64l24-24L216,84.68Z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger"
                                                style="max-width: fit-content"
                                                wire:click="deleteCheck({{ $checklist->id }})"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este entregable?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="#fff" viewBox="0 0 256 256">
                                                    <path
                                                        d="M216,48H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM192,208H64V64H192ZM80,24a8,8,0,0,1,8-8h80a8,8,0,0,1,0,16H88A8,8,0,0,1,80,24Z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif

                                <!-- Modal Propuestas-->
                                <div class="modal fade" id="checkModal" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <livewire:bidding.checklist.crud :bidding="$bidding" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="align-items-center mt-4">
            {{ $contracts->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <h4>¡No hay contratos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargar contratos en tu
                                plataforma usando el botón superior.
                            </p>
                            <button data-bs-toggle="modal" data-bs-target="#contractModal"
                                class="btn btn-sm btn-primary btn-uppercase new-proposal"
                                data-id="{{ $bidding->id }}"><i class="fas fa-plus"></i>
                                Crear contrato o Modificador</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Modal Contratos-->
    <div class="modal fade" id="contractModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="contractModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <livewire:bidding.contract.crud :bidding="$bidding" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            Livewire.on('closeModalContract', () => {
                const modal = document.getElementById('contractModal');
                bootstrap.Modal.getInstance(modal).hide();
            });

            var checkModal = new bootstrap.Modal(document.getElementById('checkModal'), {
                keyboard: false
            });

            document.querySelectorAll('.new-check').forEach(button => {
                button.addEventListener('click', function(e) {
                    const checkId = this.getAttribute('data-id');
                    checkModal.show();
                    Livewire.dispatch('newCheckModal', {
                        id: checkId
                    });
                });
            });

            document.querySelectorAll('.edit-check-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const checkId = this.getAttribute('data-id');
                    checkModal.show();
                    Livewire.dispatch('selectCheck', {
                        id: checkId
                    });
                });
            });

            Livewire.on('checklistDone', () => {
                const modal = document.getElementById('checkModal');
                bootstrap.Modal.getInstance(modal).hide();
            });
        </script>
    @endpush
</div>
