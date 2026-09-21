@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Corrige los siguientes errores:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Encabezado --}}
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                            <div>
                                <h5 class="mb-1">
                                    Folio de solicitud: <span class="text-muted">—</span>
                                    <span class="badge bg-secondary">Nuevo</span>
                                </h5>
                                <p class="text-muted mb-0">Tipo de Trámite: Permiso de Venta en Vía Pública</p>
                                <p class="text-muted mb-0">Fecha de Solicitud: {{ now()->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('citizen.fisc.street_vending.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- ===== DATOS Y CONTACTO ===== --}}
                            <div class="card mb-4">
                                <div class="card-header text-white" style="background-color:#0d6e6e;">
                                    <strong>DATOS Y CONTACTO</strong>
                                </div>
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-3">Datos del Solicitante</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Nombre Completo</label>
                                            <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Teléfono de contacto</label>
                                            <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Domicilio</label>
                                            <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <h6 class="text-uppercase text-muted mb-3">Datos de la Instalación a Solicitud</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Giro del puesto</label>
                                            <input type="text" name="business_type" value="{{ old('business_type') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tipo de Instalación</label>
                                            <input type="text" name="installation_type" value="{{ old('installation_type') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <h6 class="text-uppercase text-muted mb-3">Dimensiones</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-3">
                                            <label class="form-label">Frente (Mts)</label>
                                            <input type="text" name="front_meters" value="{{ old('front_meters') }}" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Fondo (Mts)</label>
                                            <input type="text" name="depth_meters" value="{{ old('depth_meters') }}" class="form-control">
                                        </div>
                                    </div>

                                    <h6 class="text-uppercase text-muted mb-3">Mobiliario</h6>
                                    <div class="row g-3">
                                        <div class="col-6 col-md-2">
                                            <label class="form-label">Toldo</label>
                                            <input type="number" min="0" name="awning_qty" value="{{ old('awning_qty') }}" class="form-control">
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <label class="form-label">Carrito</label>
                                            <input type="number" min="0" name="cart_qty" value="{{ old('cart_qty') }}" class="form-control">
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <label class="form-label">Mesa</label>
                                            <input type="number" min="0" name="table_qty" value="{{ old('table_qty') }}" class="form-control">
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <label class="form-label">Sillas</label>
                                            <input type="number" min="0" name="chairs_qty" value="{{ old('chairs_qty') }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== ESPACIOS Y FOTOGRAFÍAS ===== --}}
                            <div class="card mb-4">
                                <div class="card-header text-white" style="background-color:#0d6e6e;">
                                    <strong>ESPACIOS Y FOTOGRAFÍAS</strong>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <h6 class="text-uppercase text-muted mb-0">Espacios Solicitados</h6>
                                        <span class="badge bg-info text-dark">1 PRINCIPAL + 2 ALTERNOS</span>
                                    </div>

                                    <div class="border rounded p-3 mb-3">
                                        <strong>Opción 1 - Principal</strong>
                                        <div class="row g-3 mt-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Calle</label>
                                                <input type="text" name="option1_street" value="{{ old('option1_street') }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Entre las calles</label>
                                                <input type="text" name="option1_between_streets" value="{{ old('option1_between_streets') }}" class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Fotografía del espacio</label>
                                                <div class="border border-dashed rounded p-3 text-center">
                                                    <ion-icon name="cloud-upload-outline" style="font-size:1.5rem;"></ion-icon>
                                                    <p class="mb-2 text-muted">Arrastra o selecciona JPG/PNG</p>
                                                    <input type="file" name="option1_photo" accept="image/jpeg,image/png" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded p-3 mb-3">
                                        <strong>Opción 2 - Alterno</strong>
                                        <div class="row g-3 mt-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Calle</label>
                                                <input type="text" name="option2_street" value="{{ old('option2_street') }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Subir foto</label>
                                                <input type="file" name="option2_photo" accept="image/jpeg,image/png" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded p-3">
                                        <strong>Opción 3 - Alterno</strong>
                                        <div class="row g-3 mt-1">
                                            <div class="col-md-6">
                                                <label class="form-label">Calle</label>
                                                <input type="text" name="option3_street" value="{{ old('option3_street') }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Subir foto</label>
                                                <input type="file" name="option3_photo" accept="image/jpeg,image/png" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== DÍAS Y HORARIOS ===== --}}
                            <div class="card mb-4">
                                <div class="card-header text-white" style="background-color:#0d6e6e;">
                                    <strong>DÍAS Y HORARIOS</strong>
                                </div>
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-3">Días y Horario en que Trabajará</h6>

                                    <label class="form-label d-block">Días</label>
                                    <div class="mb-4">
                                        @foreach (['LUN' => 'Lunes', 'MAR' => 'Martes', 'MIE' => 'Miércoles', 'JUE' => 'Jueves', 'VIE' => 'Viernes', 'SAB' => 'Sábado', 'DOM' => 'Domingo'] as $code => $label)
                                            <input type="checkbox" class="btn-check" name="work_days[]" value="{{ $code }}"
                                                id="workday-{{ $code }}"
                                                {{ collect(old('work_days', []))->contains($code) ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary btn-sm me-1 mb-1" for="workday-{{ $code }}" title="{{ $label }}">{{ $code }}</label>
                                        @endforeach
                                    </div>

                                    <label class="form-label d-block">Horario</label>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label">De las</label>
                                            <input type="time" name="schedule_from" value="{{ old('schedule_from') }}" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">A las</label>
                                            <input type="time" name="schedule_to" value="{{ old('schedule_to') }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== LISTA DE VERIFICACIÓN DE DOCUMENTOS ===== --}}
                            <div class="card mb-4">
                                <div class="card-header text-white bg-primary">
                                    <strong>LISTA DE VERIFICACIÓN DE DOCUMENTOS</strong>
                                </div>
                                <div class="card-body">
                                    @foreach (['ine-frente' => 'INE - Frente', 'ine-reverso' => 'INE - Reverso', 'comprobante-domicilio' => 'Comprobante de Domicilio'] as $slug => $label)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-3 mb-2">
                                            <div class="d-flex align-items-center">
                                                <ion-icon name="ellipse-outline" style="font-size:1.3rem;" class="me-2 text-muted"></ion-icon>
                                                <div>
                                                    <div class="fw-bold">{{ strtoupper($label) }}</div>
                                                    <small class="text-muted">Pendiente de subir</small>
                                                </div>
                                            </div>
                                            <input type="file" name="documents[{{ $slug }}]" class="form-control" style="max-width: 260px;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- ===== FOOTER ===== --}}
                            <div class="alert alert-info d-flex align-items-start gap-2">
                                <ion-icon name="information-circle-outline" style="font-size:1.3rem;"></ion-icon>
                                <span>
                                    Tras el envío, un inspector visitará el espacio para verificar que no genere obstrucción ni conflicto con otros usos de la vía.
                                </span>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-warning fw-bold">
                                    <ion-icon name="send-outline"></ion-icon> ENVIAR SOLICITUD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
