@extends('front.layouts.app')

@section('content')
@php
    // Detectar el tipo de registro desde cualquier parámetro de la URL
    // Por defecto es 'citizen', pero si hay algún parámetro se usa ese
    $queryParams = request()->query();
    $firstParam = !empty($queryParams) ? array_key_first($queryParams) : null;
    
    // Extraer el tipo del parámetro (ej: 'supplier-type' -> 'supplier')
    $userType = 'citizen';
    if ($firstParam) {
        $userType = $firstParam;
    }
    
    // Configuración para cada tipo de usuario
    $config = [
        'citizen' => [
            'title' => 'Registro de Ciudadano',
            'description' => 'Crea tu cuenta para acceder a los servicios ciudadanos',
            'icon' => 'person-outline',
            'image' => 'front/img/placeholder-3.jpg',
            'submit_text' => 'Crear Cuenta Ciudadana',
            'submit_icon' => 'person-add-outline',
            'terms_text' => 'Al crear una cuenta ciudadana acepto los términos y condiciones y el aviso de privacidad',
            'support_email' => 'comunicacion.social@valledesantiago.gob.mx',
            'user_type_value' => 'citizen'
        ],
        'supplier' => [
            'title' => 'Registro de Proveedor',
            'description' => 'Crea tu cuenta para registrarte como proveedor municipal',
            'icon' => 'business-outline',
            'image' => 'front/img/placeholder-9.jpg',
            'submit_text' => 'Crear Cuenta de Proveedor',
            'submit_icon' => 'briefcase-outline',
            'terms_text' => 'Al crear una cuenta de proveedor acepto los términos y condiciones y el aviso de privacidad',
            'support_email' => 'comunicacion.social@valledesantiago.gob.mx',
            'user_type_value' => 'supplier'
        ]
    ];
    
    // Si el tipo no existe en la configuración, usar 'citizen' por defecto
    $current = $config[$userType] ?? $config['citizen'];
@endphp

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card card-image card-alignment-bottom wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset($current['image']) }}" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow wow fadeInUp mb-0">
                <div class="card-body bg-secondary text-white">
                    <h4 class="mb-0">
                        <ion-icon name="{{ $current['icon'] }}"></ion-icon> {{ $current['title'] }}
                    </h4>
                    <p class="mb-0 small">{{ $current['description'] }}</p>
                </div>
                
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Campo oculto para asignar rol -->
                        <input type="hidden" name="user_type" value="{{ $current['user_type_value'] }}">

                        @switch($userType)
                            @case('citizen')
                                {{-- FORMULARIO CIUDADANO --}}
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <label for="name" class="form-label">
                                            <ion-icon name="person-outline"></ion-icon> Nombre Completo <span class="text-danger text-sm">*</span>
                                        </label>
                                        <input id="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               required 
                                               autocomplete="name" 
                                               autofocus
                                               placeholder="Ingresa tu nombre completo">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label for="email" class="form-label">
                                            <ion-icon name="mail-outline"></ion-icon> Correo Electrónico <span class="text-danger">*</span>
                                        </label>
                                        <input id="email" type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               required 
                                               autocomplete="email"
                                               placeholder="ejemplo@correo.com">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="password" class="form-label">
                                            <ion-icon name="lock-closed-outline"></ion-icon> Contraseña <span class="text-danger">*</span>
                                        </label>
                                        <input id="password" type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               name="password" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Mínimo 8 caracteres">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="password_confirmation" class="form-label">
                                            <ion-icon name="lock-closed-outline"></ion-icon> Confirmar Contraseña <span class="text-danger">*</span>
                                        </label>
                                        <input id="password_confirmation" type="password" 
                                               class="form-control" 
                                               name="password_confirmation" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Repite tu contraseña">
                                    </div>
                                </div>
                            @break

                            @case('supplier')
                                {{-- FORMULARIO PROVEEDOR --}}
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <label for="name" class="form-label">
                                            <ion-icon name="person-outline"></ion-icon> Nombre Completo <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               required 
                                               autocomplete="name" 
                                               autofocus
                                               placeholder="Ingresa tu nombre completo">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">
                                            <ion-icon name="people-outline"></ion-icon> Me registro como <span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="person_type" id="person_type_fisica" 
                                                       value="fisica" {{ old('person_type', 'fisica') == 'fisica' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="person_type_fisica">
                                                    Persona Física
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="person_type" id="person_type_moral" 
                                                       value="moral" {{ old('person_type') == 'moral' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="person_type_moral">
                                                    Persona Moral
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4" id="company_name_container" style="display: none;">
                                        <label for="company_name" class="form-label">
                                            <ion-icon name="business-outline"></ion-icon> Nombre de la Empresa <span class="text-danger">*</span>
                                        </label>
                                        <input id="company_name" type="text" 
                                               class="form-control @error('company_name') is-invalid @enderror" 
                                               name="company_name" 
                                               value="{{ old('company_name') }}"
                                               placeholder="Ingresa el nombre de la empresa">
                                        @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label for="email" class="form-label">
                                            <ion-icon name="mail-outline"></ion-icon> Correo Electrónico <span class="text-danger">*</span>
                                        </label>
                                        <input id="email" type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               required 
                                               autocomplete="email"
                                               placeholder="ejemplo@correo.com">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="password" class="form-label">
                                            <ion-icon name="lock-closed-outline"></ion-icon> Contraseña <span class="text-danger">*</span>
                                        </label>
                                        <input id="password" type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               name="password" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Mínimo 8 caracteres">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="password_confirmation" class="form-label">
                                            <ion-icon name="lock-closed-outline"></ion-icon> Confirmar Contraseña <span class="text-danger">*</span>
                                        </label>
                                        <input id="password_confirmation" type="password" 
                                               class="form-control" 
                                               name="password_confirmation" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Repite tu contraseña">
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">
                                            <ion-icon name="document-text-outline"></ion-icon> Mi registro es <span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="padron_status" id="padron_con" 
                                                       value="con_padron" {{ old('padron_status', 'con_padron') == 'con_padron' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="padron_con">
                                                    Proveedor con Padrón
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="padron_status" id="padron_sin" 
                                                       value="sin_padron" {{ old('padron_status') == 'sin_padron' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="padron_sin">
                                                    Proveedor sin Padrón
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @break
                        @endswitch

                        <div class="mb-4">
                            <div class="form-group mb-2">
                                <label for="rfc_name">Captcha <span class="text-danger">*</span></label>

                                <div class="captcha">
                                    <span class="me-2">{!! captcha_img('flat') !!}</span>
                                    <button type="button" class="btn btn-danger btn-sm reload" id="reload">&#x21bb; Cambiar captcha</button>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <input type="text" class="form-control custom-form-control @error('captcha') is-invalid @enderror" placeholder="Caracteres del captcha" name="captcha" required>

                                @error('captcha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    {{ $current['terms_text'] }} <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg py-3 d-flex align-items-center justify-content-center gap-2">
                                <ion-icon name="{{ $current['submit_icon'] }}"></ion-icon> {{ $current['submit_text'] }}
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">
                                ¿Ya tienes cuenta? 
                                <a href="{{ route('login') }}" class="text-primary">Inicia sesión aquí</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="text-center mt-4 wow fadeInUp">
                <div class="alert alert-info">
                    <i class="bx bx-info-circle"></i>
                    <strong>¿Necesitas ayuda?</strong><br>
                    Contacta a soporte: <a href="mailto:{{ $current['support_email'] }}">{{ $current['support_email'] }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validación adicional en el frontend
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPassword.setCustomValidity('');
            }
        }

        password.addEventListener('change', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);

        // Control de visibilidad del campo "Nombre de la Empresa" para proveedores
        const personTypeMoral = document.getElementById('person_type_moral');
        const personTypeFisica = document.getElementById('person_type_fisica');
        const companyNameContainer = document.getElementById('company_name_container');
        const companyNameInput = document.getElementById('company_name');

        if (personTypeMoral && personTypeFisica) {
            function toggleCompanyName() {
                if (personTypeMoral.checked) {
                    companyNameContainer.style.display = 'block';
                    companyNameInput.setAttribute('required', 'required');
                } else {
                    companyNameContainer.style.display = 'none';
                    companyNameInput.removeAttribute('required');
                    companyNameInput.value = '';
                }
            }

            // Verificar al cargar la página (por si hay valores old())
            toggleCompanyName();

            personTypeMoral.addEventListener('change', toggleCompanyName);
            personTypeFisica.addEventListener('change', toggleCompanyName);
        }
    });
</script>

<!-- Captcha Reload -->
<script>
    $('.reload').on('click', function(){
        event.preventDefault();            
        $.ajax({
            type: 'GET',
            url: "{{ route('reload.captcha') }}",
            success: function(response){
                console.log(response);
                $('.captcha span').html(response.captcha);
            },
            error: function(response){
                $('#registerBtn').attr('disabled', true);
            }
        });
    });
</script>
@endpush