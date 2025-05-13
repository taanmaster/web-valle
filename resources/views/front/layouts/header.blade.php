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
                            <a href="{{ route('login') }}"
                                class="btn d-flex align-items-center gap-2 btn-secondary"><ion-icon
                                    name="apps-outline"></ion-icon> Interno <ion-icon
                                    name="caret-forward-outline"></ion-icon></a>
                        @endif
                    @else
                        <div class="dropdown">
                            <a id="navbarDropdown" class="btn d-flex align-items-center gap-2 btn-secondary dropdown-toggle"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                Hola, {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">Acceder al Panel</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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
