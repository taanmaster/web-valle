<div>
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center" style="gap: 12px;">
                <div class="icon blue">
                    <ion-icon wire:ignore.self name="copy-outline"></ion-icon>
                </div>
                <h1>Denuncia ciudadana</h1>
            </div>
            <p>
                Estimado usuario, envíe sus denuncias, quejas o sugerencias a través del siguiente
                formulario.
                <br>
                Es importante que rellene todos los campos para dar seguimiento a su mensaje. Gracias.
            </p>
        </div>

        <div class="col-md-4">
            <img src="{{ asset('front/img/denuncianet.png') }}" alt="" height="80px" style="">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Ingresa tu folio aquí</label>
        </div>
        <div class="col-md">
            <input type="text" wire:model.live="complain">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <label class="form-label">Folio</label>
            <p>{{ $id }}</p>
        </div>
        <div class="col-md-4">
            <label class="form-label">Denuncia</label>
            <p>{{ $subject }}</p>
        </div>
        <div class="col-md-4">
            <label class="form-label">Estatus</label>
            <p>{{ $status }}</p>
        </div>
    </div>
</div>
