@extends('layouts.master')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Maps @endslot
@slot('title') Google Maps @endslot
@endcomponent

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Default Map</h4>
                <p class="text-muted mb-0">Example of google maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="gmaps-basic" class="gmaps"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Map With Marker</h4>
                <p class="text-muted mb-0">Example of google maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="gmaps-marker" class="gmaps"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->


<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Overlays Map</h4>
                <p class="text-muted mb-0">Example of google maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="gmaps-overlay" class="gmaps"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Map Types</h4>
                <p class="text-muted mb-0">Example of google maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="gmaps-types" class="gmaps"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Layer Map</h4>
                <p class="text-muted mb-0">Example of google maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="gmaps-layers" class="gmaps"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script src="https://maps.google.com/maps/api/js?"></script>
<script src="{{URL::asset('assets/plugins/gmaps/gmaps.js')}}"></script>
<script src="{{URL::asset('assets/pages/gmaps.init.js')}}"></script>
@endsection
