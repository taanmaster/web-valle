@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Secretaria Particular
        @endslot
        @slot('title')
            Constancia #{{ $certificate->folio }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <a href="{{ route('identification_certificates.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver al listado
                    </a>
                </div>
            </div>

            <livewire:identification-certificates.crud :certificate="$certificate" :mode="1" />
        </div>
    </div>
@endsection
