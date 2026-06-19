<div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header + CREAR --}}
    <div class="d-flex flex-column align-items-center mb-4 gap-3">
        <h4 class="mb-0 text-center" style="font-weight:700; text-transform:uppercase; letter-spacing:1px;">
            Cumpleaños de Administración
        </h4>
        <button class="btn fw-semibold px-5 text-uppercase" wire:click="openCreate"
            style="background:#F5C842; color:#212529; border:none;">
            Crear
        </button>
    </div>

    {{-- Tabla --}}
    <div class="card" style="border-radius:12px;">
        <div class="card-body p-0">
            <table class="table table-borderless align-middle mb-0">
                <thead>
                    <tr style="border-bottom:1.5px solid #e5e5e5;">
                        <th class="ps-4 py-3 text-uppercase text-center"
                            style="font-size:.8rem; color:#888; font-weight:600;">Mes</th>
                        <th class="py-3 text-uppercase text-center"
                            style="font-size:.8rem; color:#888; font-weight:600;">Foto</th>
                        <th class="pe-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($birthdays as $birthday)
                        <tr style="border-bottom:1px solid #f0f0f0;" wire:key="bd-{{ $birthday->id }}">
                            <td class="ps-4 py-3 text-center">{{ $birthday->month_name }}</td>
                            <td class="py-3 text-center">
                                @if ($birthday->photo)
                                    <img src="{{ $birthday->photo }}" alt="Foto {{ $birthday->month_name }}"
                                        class="rounded" style="height:44px; width:64px; object-fit:cover;">
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-end" style="white-space:nowrap;">
                                <button class="btn btn-link p-0 me-2" wire:click="openEdit({{ $birthday->id }})"
                                    title="Ver / cambiar foto" aria-label="Ver / cambiar foto">
                                    <i class="ti ti-eye" style="font-size:1.3rem; color:#555;"></i>
                                </button>
                                <button class="btn btn-link p-0 text-danger" title="Eliminar" aria-label="Eliminar"
                                    wire:confirm="¿Eliminar la foto de {{ $birthday->month_name }}?"
                                    wire:click="delete({{ $birthday->id }})">
                                    <i class="ti ti-trash" style="font-size:1.2rem;"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    @if ($showModal)
        <div class="modal-backdrop fade show" style="z-index:1040;"></div>
        <div class="modal fade show d-block" tabindex="-1" style="z-index:1050;">
            <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
                <div class="modal-content" style="border-radius:12px; border:none;">
                    <div class="modal-body p-4">

                        <h5 class="mb-4 text-uppercase fw-bold" style="letter-spacing:1px;">
                            Cumpleaños de Administración
                        </h5>

                        <form wire:submit="save">

                            <div class="mb-3 row align-items-center">
                                <label class="col-md-4 col-form-label text-uppercase fw-semibold"
                                    style="font-size:.85rem; letter-spacing:.5px;">Fecha</label>
                                <div class="col-md-8">
                                    <select class="form-select @error('month') is-invalid @enderror"
                                        wire:model="month" @if($birthdayId) disabled @endif>
                                        <option value="">Mes</option>
                                        @foreach ($monthNames as $num => $name)
                                            <option value="{{ $num }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('month')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-4 col-form-label text-uppercase fw-semibold"
                                    style="font-size:.85rem; letter-spacing:.5px;">Foto</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                        wire:model="photo" accept="image/*">
                                    <div wire:loading wire:target="photo" class="text-muted small mt-1">
                                        <span class="spinner-border spinner-border-sm me-1"></span> Cargando foto...
                                    </div>
                                    @error('photo')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    @if ($photo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                        <img src="{{ $photo->temporaryUrl() }}" class="img-fluid rounded mt-2"
                                            style="max-height:140px;">
                                    @elseif ($birthdayId && ($current = $birthdays->firstWhere('id', $birthdayId))?->photo)
                                        <img src="{{ $current->photo }}" class="img-fluid rounded mt-2"
                                            style="max-height:140px;" alt="Foto actual">
                                        <small class="text-muted d-block mt-1">Foto actual — carga una nueva para reemplazarla.</small>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary"
                                    wire:click="closeModal">Cancelar</button>
                                <button type="submit" class="btn fw-semibold px-5"
                                    style="background:#F5C842; color:#212529; border:none;">
                                    <span wire:loading wire:target="save"
                                        class="spinner-border spinner-border-sm me-2"></span>
                                    Guardar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
