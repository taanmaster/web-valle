<div>

    @push('stylesheets')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="">Rango de fechas</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>

        <div class="col-md-3">
            <label for="">Folio</label>
            <input type="text" class="form-control" wire:model.live="folio">
        </div>

        {{--
        <div class="col-md-3">
            <label for="">Departamento</label>
            <select class="js-example-basic-multiple w-100" multiple="multiple" wire:model="dependency_name" wire:ignore.self>
                @foreach ($dependencies as $dependency)
                    <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                @endforeach
            </select>
        </div>
         --}}
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Folio</th>
                    <th>Departamento</th>
                    <th>Fundamento</th>
                    <th>Método de Pago</th>
                    <th>Elaborado por</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($integers as $integer)
                    <tr>
                        <td>{{ $integer->created_at->format('d/m/Y') }}</td>
                        <td>{{ $integer->id }}</td>
                        <td>{{ $integer->dependency_name }}</td>
                        <td>{{ $integer->basis }}</td>
                        <td>{{ $integer->payment_method }}</td>
                        <td>{{ $integer->created_by }}</td>
                        <td>{{ $integer->name }}</td>
                        <td>${{ number_format($integer->qty_integer, 2) }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-secondary show-btn"
                                data-id="{{ $integer->id }}">
                                <i class="bx bx-edit"></i> Ver
                            </a>
                            <a href="{{ route('account_due_provisional_integers.print', $integer->id) }}"
                                class="btn btn-secondary btn-sm">Descargar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="enteroModal" tabindex="-1" aria-labelledby="enteroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="enteroModalLabel">Entero Provisional para Pago</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:tsr_accounts_due.profiles.integer-modal />
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            var enteroModal = new bootstrap.Modal(document.getElementById('enteroModal'), {
                keyboard: false
            });

            document.querySelectorAll('.show-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const integerId = this.getAttribute('data-id');
                    enteroModal.show();
                    Livewire.dispatch('selectInteger', {
                        id: integerId
                    });
                });
            });


            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();

                $('.js-example-basic-multiple').on('change', function(e) {
                    Livewire.dispatch('select',
                        $('.js-example-basic-multiple').select2("val"));
                });
            });
        </script>
    @endpush
</div>
