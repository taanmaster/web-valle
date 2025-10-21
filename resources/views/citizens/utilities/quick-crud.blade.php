<div>

    @switch($step)
        @case(1)
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name" class="col-form-label">Nombre *</label>
                            <input type="text" name="name" wire:model="name" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="lastname" class="col-form-label">Apellido *</label>
                            <input type="text" name="lastname" wire:model="lastname" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label for="email" class="col-form-label">Correo Electrónico *</label>
                            <input type="email" name="email" wire:model="email" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        @break

        @case(2)
            <div class="modal-body">
                <h3>Cuenta creada para el ciudadano</h3>

                <p>Proporcione al ciudadano su correo y la contraseña generada. Con estos datos podrá ingresar a la plataforma y
                    consultar sus citatorios.</p>

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="email" class="col-form-label">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ $email }}" class="form-control" disabled>
                    </div>

                    <div class="col-md-12">
                        <label class="col-form-label">Contraseña</label>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                                <input type="text" id="passwordField" value="{{ $pass }}" class="form-control"
                                    readonly>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="copyToClipboard()">Copiar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="sendUser">Cerrar</button>
            </div>
        @break
    @endswitch


    <script>
        function copyToClipboard() {
            const input = document.getElementById('passwordField');
            const value = input.value;

            // Prioriza la API moderna
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(value)
                    .then(() => {
                        alert('Contraseña copiada: ' + value);
                    })
                    .catch(err => {
                        console.error('Error al copiar: ', err);
                    });
            } else {
                // Fallback para entornos inseguros o navegadores antiguos
                input.select();
                input.setSelectionRange(0, 99999); // para móviles
                document.execCommand('copy');
                alert('Contraseña copiada: ' + value);
            }
        }
    </script>

</div>
