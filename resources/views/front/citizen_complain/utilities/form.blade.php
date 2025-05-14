<div class="col-md-12">

    @push('styles')
        <style>
            .alert-modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                min-width: 330px;
                max-width: 900px;
                width: 900px;
                height: 600px;
                background-color: #fff;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                display: none;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            .alert-modal.visible {
                display: flex;
            }
        </style>
    @endpush


    <div class="card wow fadeInUp">
        <div class="card-content p-4">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <div class="d-flex align-items-center" style="gap: 12px;">
                        <div class="icon blue">
                            <ion-icon wire:ignore.self name="copy-outline"></ion-icon>
                        </div>
                        <h1>Denuncia ciudadana</h1>
                    </div>
                    <p>
                        Estimado usuario, envíe sus denuncias, quejas o sugerencias a través del siguiente formulario.
                        <br>
                        Es importante que rellene todos los campos para dar seguimiento a su mensaje. Gracias.
                    </p>
                </div>

                <div class="col-md-4">
                    <img src="{{ asset('front/img/denuncianet.png') }}" alt="" height="80px" style="">
                </div>
            </div>

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="col-form-label">Nombre</label>
                        <input type="text" name="name" wire:model="name" class="form-control">
                    </div>
                    <div class="col-md-8">
                        <label for="address" class="col-form-label">Dirección</label>
                        <input type="address" name="address" wire:model="address" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="phone" class="col-form-label">Teléfono</label>
                        <input type="text" name="phone" wire:model="phone" class="form-control">
                    </div>
                    <div class="col-md-8">
                        <label for="email" class="col-form-label">Correo electrónico</label>
                        <input type="email" name="email" wire:model="email" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="subject" class="col-form-label">Asunto</label>
                        <input type="text" name="subject" wire:model="subject" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="complain" class="col-form-label">Descripción</label>
                        <textarea class="form-control" wire:model="complain" name="complain" rows="3"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="file" class="col-form-label">Pruebas (Seleccione uno o multiples
                            archivos)</label>
                        <input type="file" name="files" wire:model="files" class="form-control" multiple>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <button wire:click="clean" class="btn btn-secondary ms-2">Borrar datos</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="alert-modal @if ($state == 'completed') visible @endif" role="alert">

        <button wire:click="clean" class="btn-close" style="position: absolute; top: 10px; right: 10px;">
        </button>

        <h1>¡Gracias!</h1>
        <p>Hemos recibido su denuncia, queja o sugerencia.</p> <br> Folio: <strong>{{ $folio }}</strong>
    </div>

</div>
