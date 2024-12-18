@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/jmap/jsvectormap.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Maps @endslot
@slot('title') Vector Maps @endslot
@endcomponent

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Metrica</a>
                    </li>
                    <!--end nav-item-->
                    <li class="breadcrumb-item"><a href="#">Maps</a>
                    </li>
                    <!--end nav-item-->
                    <li class="breadcrumb-item active">Vector Maps</li>
                </ol>
            </div>
            <h4 class="page-title">Vector Maps</h4>
        </div>
        <!--end page-title-box-->
    </div>
    <!--end col-->
</div>
<!-- end page title end breadcrumb -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">World Map Markers</h4>
                <p class="text-muted mb-0">Example of vector maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="map_1" style="width: 100%; height: 350px"></div>
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
                <h4 class="card-title">World Map With Marker Lines</h4>
                <p class="text-muted mb-0">Example of vector maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="map_2" style="width: 100%; height: 350px"></div>
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
                <h4 class="card-title">Russia Map</h4>
                <p class="text-muted mb-0">Example of vector maps.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="map_3" style="width: 100%; height: 350px"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/jmap/jsvectormap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jmap/world.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jmap/russia.js')}}"></script>
<script src="{{URL::asset('assets/pages/vectormap.init.js')}}"></script>
@endsection
