@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.urban_dev.utilities._nav')

        <style>
            /* Avatar square that remains circular and doesn't squash */
            .uv-avatar {
                width: 44px;
                height: 44px;
                min-width: 44px;
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                font-weight: 600;
            }
        </style>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-5.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Desarrollo Urbano</p>
                        <h1 class="display-1 mb-0">Directorio</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-normal wow fadeInUp mb-4">
            <div class="w-100">
                <!-- Búsqueda -->
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="input-group">
                            <input id="searchContact" type="text" class="form-control" placeholder="Buscar contacto por nombre">
                            <button class="btn btn-outline-secondary" type="button" aria-label="Buscar">
                                <ion-icon name="search-outline"></ion-icon>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cabecera -->
                <div class="row text-muted small fw-bold mb-2 mt-5">
                    <div class="col-12 col-md-6">Nombre / Área</div>
                    <div class="d-none d-md-block col-md-2 text-center">Ext.</div>
                    <div class="col-12 col-md-4">Correo</div>
                </div>

                <!-- Contactos -->
                <div class="list-group list-group-flush" id="contactList">
                    @php
                        $contacts = [
                            ['name'=>'María Elena Álvarez','initials'=>'MA','ext'=>'1001','email'=>'maria.alvarez@valledesantiago.gob.mx','area'=>'Dirección'],
                            ['name'=>'José Roberto Ramírez','initials'=>'JR','ext'=>'1002','email'=>'jose.ramirez@valledesantiago.gob.mx','area'=>'Planeación'],
                            ['name'=>'Laura Patricia Mendoza','initials'=>'LM','ext'=>'1003','email'=>'laura.mendoza@valledesantiago.gob.mx','area'=>'Licencias'],
                            ['name'=>'Antonio García Hernández','initials'=>'AG','ext'=>'1004','email'=>'antonio.garcia@valledesantiago.gob.mx','area'=>'Obras'],
                            ['name'=>'Carmen Rosa Jiménez','initials'=>'CR','ext'=>'1005','email'=>'carmen.jimenez@valledesantiago.gob.mx','area'=>'Catastro'],
                            ['name'=>'Fernando Valdez López','initials'=>'FV','ext'=>'1006','email'=>'fernando.valdez@valledesantiago.gob.mx','area'=>'Topografía'],
                            ['name'=>'Silvia Patricia Morales','initials'=>'SP','ext'=>'1007','email'=>'silvia.morales@valledesantiago.gob.mx','area'=>'Urbanismo'],
                            ['name'=>'Roberto Carlos Sánchez','initials'=>'RC','ext'=>'1008','email'=>'roberto.sanchez@valledesantiago.gob.mx','area'=>'Proyectos'],
                            ['name'=>'Gabriela Luna Torres','initials'=>'GL','ext'=>'1009','email'=>'gabriela.luna@valledesantiago.gob.mx','area'=>'Inspección'],
                            ['name'=>'Diego Rodríguez Vega','initials'=>'DR','ext'=>'1010','email'=>'diego.rodriguez@valledesantiago.gob.mx','area'=>'Trámites'],
                            ['name'=>'Verónica Fernández Castro','initials'=>'VF','ext'=>'1011','email'=>'veronica.fernandez@valledesantiago.gob.mx','area'=>'Archivo'],
                            ['name'=>'Miguel Pérez Ruiz','initials'=>'MP','ext'=>'1012','email'=>'miguel.perez@valledesantiago.gob.mx','area'=>'Atención'],
                            ['name'=>'Ana Cristina Navarro','initials'=>'AN','ext'=>'1013','email'=>'ana.navarro@valledesantiago.gob.mx','area'=>'Registros'],
                            ['name'=>'Eduardo González Martín','initials'=>'EG','ext'=>'1014','email'=>'eduardo.gonzalez@valledesantiago.gob.mx','area'=>'Sistemas'],
                            ['name'=>'Patricia Herrera Díaz','initials'=>'PH','ext'=>'1015','email'=>'patricia.herrera@valledesantiago.gob.mx','area'=>'Gestión'],
                            ['name'=>'Raúl Castillo Flores','initials'=>'RC','ext'=>'1016','email'=>'raul.castillo@valledesantiago.gob.mx','area'=>'Dirección'],
                            ['name'=>'Isabel Salinas Romero','initials'=>'IS','ext'=>'1017','email'=>'isabel.salinas@valledesantiago.gob.mx','area'=>'Licencias'],
                            ['name'=>'Javier Moreno Esquivel','initials'=>'JM','ext'=>'1018','email'=>'javier.moreno@valledesantiago.gob.mx','area'=>'Obras'],
                            ['name'=>'Lucía Ramírez Silva','initials'=>'LR','ext'=>'1019','email'=>'lucia.ramirez@valledesantiago.gob.mx','area'=>'Catastro'],
                            ['name'=>'Alejandro Ortega Mejía','initials'=>'AO','ext'=>'1020','email'=>'alejandro.ortega@valledesantiago.gob.mx','area'=>'Topografía'],
                            ['name'=>'Mónica Cervantes López','initials'=>'MC','ext'=>'1021','email'=>'monica.cervantes@valledesantiago.gob.mx','area'=>'Urbanismo'],
                            ['name'=>'Héctor Vargas Peña','initials'=>'HV','ext'=>'1022','email'=>'hector.vargas@valledesantiago.gob.mx','area'=>'Proyectos'],
                            ['name'=>'Beatriz Medina Rojas','initials'=>'BM','ext'=>'1023','email'=>'beatriz.medina@valledesantiago.gob.mx','area'=>'Inspección'],
                            ['name'=>'Omar Soto Guerrero','initials'=>'OS','ext'=>'1024','email'=>'omar.soto@valledesantiago.gob.mx','area'=>'Trámites'],
                            ['name'=>'Natalia Gutiérrez Reyes','initials'=>'NG','ext'=>'1025','email'=>'natalia.gutierrez@valledesantiago.gob.mx','area'=>'Archivo'],
                            ['name'=>'Tomás Cruz Aguilar','initials'=>'TC','ext'=>'1026','email'=>'tomas.cruz@valledesantiago.gob.mx','area'=>'Atención'],
                            ['name'=>'Elena Márquez Santos','initials'=>'EM','ext'=>'1027','email'=>'elena.marquez@valledesantiago.gob.mx','area'=>'Registros'],
                            ['name'=>'Ricardo Flores Campos','initials'=>'RF','ext'=>'1028','email'=>'ricardo.flores@valledesantiago.gob.mx','area'=>'Sistemas'],
                            ['name'=>'Adriana León Vázquez','initials'=>'AL','ext'=>'1029','email'=>'adriana.leon@valledesantiago.gob.mx','area'=>'Gestión'],
                            ['name'=>'Carlos Lara Mendoza','initials'=>'CL','ext'=>'1030','email'=>'carlos.lara@valledesantiago.gob.mx','area'=>'Dirección'],
                            ['name'=>'Valeria Ramos Herrera','initials'=>'VR','ext'=>'1031','email'=>'valeria.ramos@valledesantiago.gob.mx','area'=>'Licencias'],
                            ['name'=>'Ignacio Guerra Rubio','initials'=>'IG','ext'=>'1032','email'=>'ignacio.guerra@valledesantiago.gob.mx','area'=>'Obras'],
                            ['name'=>'Sandra Muñoz Ríos','initials'=>'SM','ext'=>'1033','email'=>'sandra.munoz@valledesantiago.gob.mx','area'=>'Catastro'],
                            ['name'=>'Jorge Andrade Téllez','initials'=>'JA','ext'=>'1034','email'=>'jorge.andrade@valledesantiago.gob.mx','area'=>'Topografía'],
                            ['name'=>'Diana Padilla Córdoba','initials'=>'DP','ext'=>'1035','email'=>'diana.padilla@valledesantiago.gob.mx','area'=>'Urbanismo'],
                            ['name'=>'Marco Villalobos Ochoa','initials'=>'MV','ext'=>'1036','email'=>'marco.villalobos@valledesantiago.gob.mx','area'=>'Proyectos'],
                            ['name'=>'Liliana Suárez Morales','initials'=>'LS','ext'=>'1037','email'=>'liliana.suarez@valledesantiago.gob.mx','area'=>'Inspección'],
                            ['name'=>'Rodrigo Herrera Palacios','initials'=>'RH','ext'=>'1038','email'=>'rodrigo.herrera@valledesantiago.gob.mx','area'=>'Trámites'],
                            ['name'=>'Karla Chávez Miranda','initials'=>'KC','ext'=>'1039','email'=>'karla.chavez@valledesantiago.gob.mx','area'=>'Archivo'],
                            ['name'=>'Arturo Mejía Sandoval','initials'=>'AM','ext'=>'1040','email'=>'arturo.mejia@valledesantiago.gob.mx','area'=>'Atención'],
                        ];
                    @endphp

                    @php
                        $bgColors = ['bg-primary','bg-secondary','bg-success','bg-danger','bg-warning','bg-info','bg-dark'];
                    @endphp

                    @foreach($contacts as $c)
                        @php $bg = $bgColors[array_rand($bgColors)]; @endphp
                        <div class="list-group-item py-3">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 d-flex align-items-center flex-nowrap">
                                    <div class="uv-avatar text-white me-3 flex-shrink-0 {{ $bg }} fs-6 fw-bold" role="img" aria-label="avatar">{{ $c['initials'] }}</div>
                                    <div>
                                        <div class="fw-semibold">{{ $c['name'] }}</div>
                                        <div class="small text-muted">{{ $c['area'] }}</div>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center">
                                    <div class="fw-bold">{{ $c['ext'] }}</div>
                                </div>
                                <div class="col-12 col-md-4 text-truncate">
                                    <a href="mailto:{{ $c['email'] }}" class="text-decoration-none text-muted">{{ $c['email'] }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="noResults" class="text-center py-4 small text-muted d-none">
                    <div class="mb-2"><ion-icon name="search-outline" class="fs-2"></ion-icon></div>
                    No se encontraron contactos
                </div>
            </div>
        </div>

        @include('front.urban_dev.utilities._footer')
    </div>

    <!-- Script para funcionalidad de búsqueda -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchContact');
            const contactItems = document.querySelectorAll('#contactList .list-group-item');
            const noResults = document.getElementById('noResults');

            function updateFilter() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                contactItems.forEach(function(item) {
                    const contactNameEl = item.querySelector('.fw-semibold');
                    const contactName = contactNameEl ? contactNameEl.textContent.toLowerCase() : '';
                    const matches = contactName.includes(searchTerm);
                    item.classList.toggle('d-none', !matches);
                    if (matches) visibleCount++;
                });

                noResults.classList.toggle('d-none', !(visibleCount === 0 && searchTerm !== ''));
            }

            searchInput.addEventListener('input', updateFilter);

            // Botón de búsqueda: enfocar input
            const searchBtn = document.querySelector('#searchContact')?.closest('.input-group')?.querySelector('button');
            if (searchBtn) searchBtn.addEventListener('click', function() { searchInput.focus(); });

            // Evitar submit con Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') e.preventDefault();
            });
        });
    </script>
@endsection

