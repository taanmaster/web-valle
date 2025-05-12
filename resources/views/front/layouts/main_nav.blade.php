<header class="page-header">
    <nav>
      <a href="{{ url('/') }}" aria-label="Valle de Santiago logo" class="logo hide-text">
        Valle de Santiago
      </a>

      <button class="toggle-mob-menu" aria-expanded="false" aria-label="open menu">
        <svg width="20" height="20" aria-hidden="true">
          <use xlink:href="#down"></use>
        </svg>
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
        
        <li>
          <a href="{{ route('treasury.dependency.list') }}">
            <ion-icon name="layers-outline"></ion-icon>
            <span>Tesorería</span>
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
            <ion-icon name="eye-off-outline"></ion-icon>
            <span>Ocultar Menú</span>
          </button>
        </li>
      </ul>
    </nav>
  </header>