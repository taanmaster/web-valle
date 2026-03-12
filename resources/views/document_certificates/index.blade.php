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
            Secretaría de Ayuntamiento
        @endslot
        @slot('title')
            Certificaciones de Documentos
        @endslot
    @endcomponent

    <div class="content">
        <div class="row">
            <livewire:document-certificates.table :mode="0" />
        </div>
    </div>
@endsection
