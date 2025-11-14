<div>

    <div class="d-flex justify-content-end">
        <button data-bs-toggle="modal" data-bs-target="#staticBackdrop"
            class="btn btn-sm btn-primary btn-uppercase new-proposal" style="max-width: fit-content"
            data-id="{{ $bidding->id }}"><i class="fas fa-plus"></i> Agregar propuesta</button>
    </div>

    @if ($proposals->count() != null)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Propuesta</th>
                        <th>No. Proveedor</th>
                        <th>Nombre de Proveedor</th>
                        <th>Tipo de proveedor</th>
                        <th>Fecha</th>
                        <th>Archivo</th>
                        <th>Dictamen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposals as $index => $proposal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $proposal->supplier->registration_number }}</td>
                            <td>{{ $proposal->supplier->owner_name }}</td>
                            <td>{{ $proposal->supplier->person_type }}</td>
                            <td>{{ $proposal->updated_at->format('Y-m-d') }}</td>
                            <td>

                                <a href="{{ $proposal->file }}" class="btn btn-sm btn-light"
                                    style="max-width: fit-content; max-height:fit-content" target="_blanck">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                        </path>
                                    </svg>
                                    {{ $proposal->file_name }}
                                </a>

                            </td>
                            <td>
                                @if ($proposal->status != null)
                                    <h4>
                                        @switch($proposal->status)
                                            @case('Fallo')
                                                <span class="badge text-bg-danger">Fallo</span>
                                            @break

                                            @case('Adjudicada')
                                                <span class="badge text-bg-success">Adjudicada</span>
                                            @break
                                        @endswitch
                                    </h4>
                                    <p>Fecha: {{ $proposal->status_update }}</p>
                                    @if ($proposal->dictum_file_name != null)
                                        <a href="{{ $proposal->dictum_file }}" class="btn btn-sm btn-light"
                                            style="max-width: fit-content; max-height:fit-content" target="_blanck">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                                </path>
                                            </svg>
                                            {{ $proposal->dictum_file_name ?? 'N/A' }}
                                        </a>
                                    @endif
                                @else
                                    <button data-bs-toggle="modal" data-bs-target="#dictamenModal"
                                        class="btn btn-sm btn-primary btn-uppercase dictamen-btn"
                                        data-id="{{ $proposal->id }}">Dictamen</button>
                                @endif
                                <!-- Modal Propuestas-->
                                <div class="modal fade" id="dictamenModal" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="dictamenModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <livewire:bidding.proposal.dictum :proposal="$proposal" />
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
            {{ $proposals->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <h4>¡No hay propuestas guardadas en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargar propuestas en tu
                                plataforma usando el botón superior.
                            </p>
                            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                class="btn btn-sm btn-primary btn-uppercase new-proposal"
                                data-id="{{ $bidding->id }}"><i class="fas fa-plus"></i>
                                Crear nueva
                                Propuesta/Cotización</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Modal Propuestas-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <livewire:bidding.proposal.crud :bidding="$bidding->id" />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            Livewire.on('closeModal', () => {

                alert('hi');

                const modal = document.getElementById('staticBackdrop');
                bootstrap.Modal.getInstance(modal).hide();
            });
        </script>
    @endpush
</div>
