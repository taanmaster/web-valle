<section class="header-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                {{--
                <p class="mb-0">Horarios Presidencia: <strong>Lunes a Viernes de 8:00 am - 4:00 pm</strong></p>
                 --}}
            </div>
            <div class="col-md-7">
                <div class="d-flex gap-3 justify-content-end flex-column flex-md-row">
                    {{--
                    <a href="" class="btn d-flex align-items-center gap-2 btn-success disabled"><ion-icon
                            name="card-outline"></ion-icon> Pago en Linea</a>
                             --}}
                    <a href="{{ route('denuncia.net') }}"
                        class="btn d-flex align-items-center gap-2 btn-primary"><ion-icon name="radio-outline"></ion-icon>
                        Denuncia Ciudadana</a>
                    @guest
                        @if (Route::has('login'))
                            <div class="dropdown">
                                <a class="btn d-flex align-items-center gap-2 btn-secondary dropdown-toggle"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <ion-icon name="apps-outline"></ion-icon> 
                                    Interno 
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <ion-icon name="log-in-outline"></ion-icon>
                                        Iniciar Sesión
                                    </a>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        <ion-icon name="person-add-outline"></ion-icon>
                                        Registrarse
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="dropdown">
                            <a id="navbarDropdown" class="btn d-flex align-items-center gap-2 btn-secondary dropdown-toggle"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                Hola, {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(auth()->user()->hasRole('citizen'))
                                    <a class="dropdown-item" href="{{ route('citizen.profile.index') }}">
                                        <ion-icon name="person-circle-outline"></ion-icon>
                                        Mi Perfil
                                    </a>
                                @endif

                                @if(auth()->user()->hasRole('supplier'))
                                    <a class="dropdown-item" href="{{ route('supplier.profile.index') }}">
                                        <ion-icon name="person-circle-outline"></ion-icon>
                                        Mi Perfil
                                    </a>
                                @endif
                                
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('admin_access'))
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <ion-icon name="settings-outline"></ion-icon>
                                        Administración
                                    </a>
                                @endif
                                
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                    Cerrar Sesión
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest

                </div>
            </div>
        </div>
    </div>
</section>
