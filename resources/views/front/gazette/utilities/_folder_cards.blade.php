<div class="row w-100">
    <div class="col-md-4 mb-4 mb-md-0">
        <a href="{{ route('gazette.list', 'ordinary') }}" class="folder-card folder-green">
            <div class="folder-head"></div>
            <div class="folder-body">
                <div class="folder-document"></div>
                <div class="folder-document"></div>
            </div>
            <div class="folder-overlay"></div>
            <div class="folder-text">
                <div class="d-flex align-items-start justify-content-between">
                    <h6>Sesiones Ordinarias <br> H. Ayuntamiento 2024-2027</h6>
                    <div
                        class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline"></ion-icon>
                    </div>
                </div>
                <p class="mb-0"><strong>{{ $ordinary_gazette_sessions }}</strong></p>
            </div>
        </a>
    </div>

    <div class="col-md-4 mb-4 mb-md-0">
        <a href="{{ route('gazette.list', 'solemn') }}" class="folder-card folder-yellow">
            <div class="folder-head"></div>
            <div class="folder-body">
                <div class="folder-document"></div>
                <div class="folder-document"></div>
            </div>
            <div class="folder-overlay"></div>
            <div class="folder-text">
                <div class="d-flex align-items-start justify-content-between">
                    <h6>Sesiones Solemnes <br> H. Ayuntamiento 2024-2027</h6>
                    <div
                        class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline"></ion-icon>
                    </div>
                </div>
                <p class="mb-0"><strong>{{ $solemn_gazette_sessions }}</strong></p>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <a href="{{ route('gazette.list', 'extraordinary') }}" class="folder-card folder-blue">
            <div class="folder-head"></div>
            <div class="folder-body">
                <div class="folder-document"></div>
            </div>
            <div class="folder-overlay"></div>
            <div class="folder-text">
                <div class="d-flex align-items-start justify-content-between">
                    <h6>Sesiones Extraordinarias <br> H. Ayuntamiento 2024-2027</h6>
                    <div
                        class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline"></ion-icon>
                    </div>
                </div>
                <p class="mb-0"><strong>{{ $extraordinary_gazette_sessions }}</strong></p>
            </div>
        </a>
    </div>
</div>