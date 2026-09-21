@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Desarrollo Urbano
        @endslot
        @slot('li_3')
            <a href="{{ route('urban_dev.sare_requests.index') }}">Solicitudes SARE</a>
        @endslot
        @slot('title')
            Revisión · Solicitud #{{ $review->sareRequest->request_num }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            @livewire('urban-dev.sare-requests.review', ['review' => $review])
        </div>
    </div>

    <!-- Modal de vista previa de imagen -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center p-0 pb-3">
                    <img id="imagePreviewModalImg" src="" class="img-fluid rounded" alt="Vista previa">
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(url) {
            document.getElementById('imagePreviewModalImg').src = url;
            new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
        }
    </script>
@endsection
