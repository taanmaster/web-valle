<header class="page-header">
    <nav>
        <a href="{{ url('/') }}" aria-label="Valle de Santiago logo" class="logo hide-text">
            Valle de Santiago
        </a>

        <button class="toggle-mob-menu" aria-expanded="false" aria-label="open menu">
            <ion-icon name="menu"></ion-icon>
        </button>

        <ul class="admin-menu list-unstyled">
            <li>
                <a href="{{ route('index') }}">
                    <ion-icon name="apps-outline"></ion-icon>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dependency.list') }}">
                    <ion-icon name="people-outline"></ion-icon>
                    <span>Transparencia</span>
                </a>
            </li>
            <li>
                <a href="{{ route('gazette.list', 'all') }}">
                    <ion-icon name="documents-outline"></ion-icon>
                    <span>Gaceta Municipal</span>
                </a>
            </li>

            {{--
            <li>
                <a href="{{ route('treasury.dependency.list') }}">
                    <ion-icon name="stats-chart-outline"></ion-icon>
                    <span>Tesorería</span>
                </a>
            </li>
            --}}

            <li>
                <a href="{{ route('desarrollo_institucional.index') }}">
                    <ion-icon name="business-outline"></ion-icon>
                    <span>Desarrollo Institucional</span>
                </a>
            </li>

            <li>
                <a href="{{ route('urban_dev.index') }}">
                    <ion-icon name="bus-outline"></ion-icon>
                    <span>Desarrollo Urbano</span>
                </a>
            </li>

            <li>
                <a href="{{ route('urban_dev.contacts', 'auditors') }}">
                    <ion-icon name="document-text-outline"></ion-icon>
                    <span>Fiscalización</span>
                </a>
            </li>

            <li>
                <a href="{{ route('implan.index') }}">
                    <ion-icon name="bulb-outline"></ion-icon>
                    <span>IMPLAN</span>
                </a>
            </li>

            <li>
                <a href="{{ route('sare.index') }}">
                    <ion-icon name="layers-outline"></ion-icon>
                    <span>S.A.R.E</span>
                </a>
            </li>

            <li>
                <a href="{{ route('blog.index') }}">
                    <ion-icon name="newspaper-outline"></ion-icon>
                    <span>Noticias</span>
                </a>
            </li>

            <li>
                <a href="{{ route('contraloria.index') }}">
                    <ion-icon name="library-outline"></ion-icon>
                    <span>Contraloría</span>
                </a>
            </li>

            <li>
                <a href="{{ route('dif.index') }}">
                    <ion-icon name="medkit-outline"></ion-icon>
                    <span>DIF</span>
                </a>
            </li>
            
            <li>
                <div class="switch">
                    <input type="checkbox" id="mode" checked>
                    <label for="mode">
                        <span></span>
                        <span>Oscuro</span>
                    </label>
                </div>

                <button class="collapse-btn btn btn-secondary-outline" aria-expanded="true" aria-label="collapse menu">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                    <span>Ocultar Menú</span>
                </button>
            </li>
        </ul>
    </nav>
</header>
