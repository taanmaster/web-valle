<div>
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name" class="form-label">Nombre *</label>
                <input type="text" class="form-control" wire:model="first_name" placeholder="Tu nombre">
                @error('first_name')
                    <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="last_name" class="form-label">Apellido *</label>
                <input type="text" class="form-control" wire:model="last_name" placeholder="Tu apellido">
                @error('last_name')
                    <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" wire:model="email" placeholder="tu@email.com">
                @error('email')
                    <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Telefono</label>
                <input type="text" class="form-control" wire:model="phone" placeholder="10 digitos">
                @error('phone')
                    <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="cv" class="form-label">Curriculum Vitae (PDF) * <small class="text-muted">Max
                        5MB</small></label>
                <input type="file" class="form-control" wire:model="cv" accept=".pdf">
                @error('cv')
                    <span class="text-danger"><small>{{ $message }}</small></span>
                @enderror

                <div wire:loading wire:target="cv" class="mt-2">
                    <span class="text-primary">
                        <span class="spinner-border spinner-border-sm" role="status"></span>
                        Cargando archivo...
                    </span>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3" style="gap: 12px">
            <a href="{{ route('rrhh.vacancy.detail', $vacancy->id) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Enviar aplicacion</span>
                <span wire:loading wire:target="save">
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    Enviando...
                </span>
            </button>
        </div>
    </form>
</div>
