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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">
                            <ion-icon name="storefront-outline"></ion-icon> Servicios Municipales en Línea
                        </h5>
                        <a href="{{ route('citizen.cart.index') }}" class="btn btn-outline-primary btn-sm position-relative">
                            <ion-icon name="cart-outline"></ion-icon> Carrito
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($services->isEmpty())
                        <div class="text-center text-muted py-5">
                            <ion-icon name="cube-outline" style="font-size:3rem"></ion-icon>
                            <p class="mt-2">No hay servicios disponibles por el momento.</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($services as $service)
                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title mb-1">
                                            <ion-icon name="document-text-outline"></ion-icon>
                                            Solicitar {{ $service->name }}
                                        </h6>
                                        @if($service->description)
                                            <p class="card-text text-muted small mb-2">{{ $service->description }}</p>
                                        @endif
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-success fs-6">${{ number_format($service->unit_price, 2) }}</span>
                                            <button type="button"
                                                class="btn btn-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalVincularFolio"
                                                data-service-id="{{ $service->id }}"
                                                data-service-name="{{ $service->name }}">
                                                <ion-icon name="cart-outline"></ion-icon> Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Vincular folio al servicio --}}
<div class="modal fade" id="modalVincularFolio" tabindex="-1" aria-labelledby="modalVincularFolioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVincularFolioLabel">
                    <ion-icon name="link-outline"></ion-icon> Vincular trámite al pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            @if($pendingCertificates->isNotEmpty())
            {{-- El usuario tiene constancias pendientes: seleccionar una --}}
            <form id="formVincularConstancia" action="#" method="POST">
                @csrf
                <input type="hidden" name="billable_service_id" id="modalServiceIdA">
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Servicio: <strong id="modalServiceName"></strong>
                    </p>
                    <p class="mb-2">Selecciona la constancia a la que deseas vincular este pago:</p>
                    <div class="list-group">
                        @foreach($pendingCertificates as $cert)
                        <label class="list-group-item list-group-item-action d-flex align-items-start gap-2" style="cursor:pointer">
                            <input class="form-check-input mt-1 flex-shrink-0" type="radio"
                                   name="certificate_id" value="{{ $cert->id }}" required>
                            <div>
                                <div class="fw-semibold">{{ $cert->folio }}</div>
                                <small class="text-muted">{{ $cert->certificate_type }} — {{ $cert->full_name }}</small>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <ion-icon name="cart-outline"></ion-icon> Agregar al carrito
                    </button>
                </div>
            </form>
            @else
            {{-- Sin constancias pendientes: agregar servicio genérico --}}
            <form id="formAgregarGenerico" action="{{ route('citizen.cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="billable_service_id" id="modalServiceId">
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Servicio: <strong id="modalServiceNameB"></strong>
                    </p>
                    <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                        <ion-icon name="information-circle-outline" style="font-size:1.3rem;flex-shrink:0"></ion-icon>
                        <span>No tienes constancias con pago pendiente. El servicio se agregará al carrito sin vincular un trámite específico.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <ion-icon name="cart-outline"></ion-icon> Agregar al carrito
                    </button>
                </div>
            </form>
            @endif

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    (function () {
        const modalEl = document.getElementById('modalVincularFolio');
        if (!modalEl) return;

        const formA = document.getElementById('formVincularConstancia');

        // Al abrir el modal, rellenar nombre del servicio y resetear selección
        modalEl.addEventListener('show.bs.modal', function (event) {
            const btn         = event.relatedTarget;
            const serviceId   = btn.getAttribute('data-service-id');
            const serviceName = btn.getAttribute('data-service-name');

            const nameA = document.getElementById('modalServiceName');
            const nameB = document.getElementById('modalServiceNameB');
            if (nameA) nameA.textContent = serviceName;
            if (nameB) nameB.textContent = serviceName;

            // Formulario genérico: asignar billable_service_id
            const hiddenId = document.getElementById('modalServiceId');
            if (hiddenId) hiddenId.value = serviceId;

            // Formulario de constancias: asignar billable_service_id también
            const hiddenIdA = document.getElementById('modalServiceIdA');
            if (hiddenIdA) hiddenIdA.value = serviceId;

            // Formulario de constancias: limpiar selección y resetear action
            if (formA) {
                formA.querySelectorAll('input[name="certificate_id"]').forEach(r => r.checked = false);
                formA.action = '#';
            }
        });

        // Al seleccionar un radio, actualizar el action con el ID de la constancia
        if (formA) {
            formA.querySelectorAll('input[name="certificate_id"]').forEach(function (radio) {
                radio.addEventListener('change', function () {
                    formA.action = '{{ url("ciudadanos/constancias_de_identificacion") }}/' +
                        this.value + '/pagar-en-linea';
                });
            });
        }
    })();
</script>
@endpush
