<div class="col-md-12">

    @push('styles')
        @livewireStyles

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

            .dark-mode .alert-modal {
                background: linear-gradient(135deg, #171717 0%, #262626 100%);
                color: #171717;
            }

            .alert-modal.visible {
                display: flex;
            }
        </style>
    @endpush

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        @switch($step)
            @case(1)
                <div class="card wow fadeInUp p-4">
                    <h1>Manejo de datos personales</h1>
                    <p>Los datos personales recabados serán protegidos, incorporados y tratados en los bancos de datos que obran
                        en
                        la Contraloría Municipal, de conformidad con la Ley de Protección de Datos Personales para el Estado y
                        los
                        Municipios de Guanajuato y demás normatividad aplicable.</p>

                    <br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" wire:model="is_agree" id="is_agree">
                        <label class="form-check-label" for="checkDefault">
                            Estoy de acuerdo en el manejo de mis datos personales
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" wire:model="is_aware" id="is_aware">
                        <label class="form-check-label" for="checkDefault">
                            Estoy consciente de que esta plataforma es ÚNICAMENTE para registrar inconformidades referentes al
                            actuar de servidores públicos municipales, deficiencias en el servicio público y/o falta de
                            seguimiento
                            a solicitudes en dependencias municipales
                        </label>
                    </div>
                    <br><br><br>

                    <div class="mb-3">
                        <label class="form-label">Usted presenta una: (Obligatorio)</label>
                        <select class="form-select" name="subject" wire:model="subject" required>
                            <option selected>Selecciona una opción</option>
                            <option value="Queja">Queja</option>
                            <option value="Denuncia">Denunca</option>
                            <option value="Sugerencia">Sugerencia</option>
                            <option value="Solicitud">Solicitud</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary" wire:click="nextStep">Siguiente</button>
                </div>
            @break

            @case(2)
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
                                    Estimado usuario, envíe sus denuncias, quejas o sugerencias a través del siguiente
                                    formulario.
                                    <br>
                                    Es importante que rellene todos los campos para dar seguimiento a su mensaje. Gracias.
                                </p>
                            </div>

                            <div class="col-md-4">
                                <img src="{{ asset('front/img/denuncianet.png') }}" alt="" height="80px"
                                    style="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h4>Dinos quien eres:</h4>
                                <p>(Debes anexar una copia de tu INE)</p>

                                <input type="file" name="ine" id="ine" wire:model.live="ine" class="form-control">
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="true" id="anonymus"
                                        wire:model.live="anonymus">
                                    <label class="form-check-label" for="checkDefault">
                                        ¿Deseas que tu denuncia sea anónima?
                                    </label>
                                    <br>
                                    <small>Los datos proporcionados se manejan de manera confidencial, no obstante, si así
                                        lo desea, puede manifestar su voluntad de que su queja o denuncia sea tratada como
                                        anónima.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="name" class="col-form-label">Nombre</label>
                                <input type="text" name="name" wire:model.live="name" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label for="address" class="col-form-label">Calle y número</label>
                                <input type="address" name="address" wire:model.live="address" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="suburb" class="col-form-label">Colonia</label>
                                <input type="text" name="suburb" wire:model.live="suburb" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label for="town" class="col-form-label">Municipio</label>
                                <input type="text" name="town" wire:model.live="town" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="phone" class="col-form-label">Teléfono</label>
                                <input type="text" name="phone" wire:model.live="phone" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label for="email" class="col-form-label">Correo electrónico</label>
                                <input type="email" name="email" wire:model.live="email" class="form-control" required>
                            </div>
                        </div>

                        <br>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="notification_email"
                                wire:model.live="notification_email">
                            <label class="form-check-label" for="checkDefault">
                                Recibir seguimiento por e-mail
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="notification_home"
                                wire:model.live="notification_home">
                            <label class="form-check-label" for="checkDefault">
                                Notificación en domicilio
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button type="button" wire:click="back" class="btn btn-secondary">Regresar</button>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-primary" wire:click="nextStep">
                            Siguiente
                        </button>
                    </div>
                </div>
            @break

            @case(3)
                <div class="card wow fadeInUp p-4">
                    <div class="card-content">
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
                                <img src="{{ asset('front/img/denuncianet.png') }}" alt="" height="80px"
                                    style="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="complain" class="col-form-label">Descripción</label>
                                <textarea class="form-control" wire:model="complain" name="complain" rows="3"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="file" class="col-form-label">Pruebas (Seleccione uno o multiples
                                    archivos)</label>
                                <input type="file" name="files" wire:model="files" class="form-control" multiple>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            {{--
                            <label for="captcha" class="col-form-label">
                                Captcha <span class="text-danger">*</span>
                            </label>

                            <div class="captcha d-flex align-items-center gap-2 mb-2">
                                <span class="me-2" id="captcha-image">{!! $captchaHtml !!}</span>

                                <button type="button" class="btn btn-danger btn-sm" wire:click="reloadCaptcha">
                                    &#x21bb; Cambiar captcha
                                </button>
                            </div>


                            <input type="text" name="captcha" wire:model="captcha"
                                class="form-control @error('captcha') is-invalid @enderror"
                                placeholder="Ingrese los caracteres del captcha" required wire:ignore>

                            @error('captcha')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                             --}}

                            <div id="captcha" class="mt-4" wire:ignore></div>

                            @error('captcha')
                                <p class="mt-3 text-sm text-red-600 text-left">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <button type="button" wire:click="back" class="btn btn-secondary">Regresar</button>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                <button wire:click="clean" class="btn btn-secondary ms-2">Borrar datos</button>
                            </div>
                        </div>
                    </div>
                </div>
            @break

            @default
        @endswitch
    </form>


    <div class="alert-modal @if ($state == 'completed') visible @endif" role="alert">

        <button wire:click="clean" class="btn-close" style="position: absolute; top: 10px; right: 10px;">
        </button>

        <h1>¡Gracias!</h1>
        <p>Hemos recibido su denuncia, queja o sugerencia.</p> <br>
        <p>Folio: <strong>{{ $folio }}</strong></p>
    </div>

    @push('scripts')
        @livewireScripts

        <script>
            // Recargar captcha
            document.addEventListener('DOMContentLoaded', function() {
                const reloadButton = document.querySelector('.reload-captcha');

                if (reloadButton) {
                    reloadButton.addEventListener('click', function(event) {
                        event.preventDefault();

                        fetch("{{ route('reload.captcha') }}", {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('captcha-image').innerHTML = data.captcha;
                            })
                            .catch(error => {
                                console.error('Error al recargar captcha:', error);
                            });
                    });
                }
            });

            Livewire.on('issue', data => {
                alert(data.message); // Puedes usar cualquier UI: toast, modal, etc.
            });
        </script>

        <script src="https://www.google.com/recaptcha/api.js?onload=handle&render=explicit" async defer></script>
        <script>
            var handle = function(e) {
                widget = grecaptcha.render('captcha', {
                    'sitekey': '{{ config('services.recaptcha.public_key') }}',
                    'theme': 'light', // you could switch between dark and light mode.
                    'callback': verify
                });

            }
            var verify = function(response) {
                @this.set('captcha', response)
            }
        @endpush

            <
            /div>
