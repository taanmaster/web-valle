@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/tabulator/bootstrap/tabulator_bootstrap4.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Advanced UI @endslot
@slot('title') Analytics @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Customers Growth</h4>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="chart-demo">
                    <div id="apex_line1" class="apex-charts"></div>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col align-self-center">
                        <h6 class="font-15 m-0 mb-1">Returning Customers</h6>
                        <p class="text-muted mb-0">Last Month : 150 <i class="mdi mdi-menu-up text-success"></i></p>
                    </div>
                    <!--end col-->
                    <div class="col-auto align-self-center">
                        <div class="">
                            <div id="bar-1" class="apex-charts mb-n4"></div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col align-self-center">
                        <h6 class="font-15 m-0 mb-1">New Customers</h6>
                        <p class="text-muted mb-0">Last Month : 10 <i class="mdi mdi-menu-down text-danger"></i></p>
                    </div>
                    <!--end col-->
                    <div class="col-auto align-self-center">
                        <div class="">
                            <div id="line-1" class="apex-charts"></div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col align-self-center">
                        <h6 class="font-15 m-0 mb-1">Bounce Rate</h6>
                        <p class="text-muted mb-0">Last Month : 50% <i class="mdi mdi-menu-up text-success"></i></p>
                    </div>
                    <!--end col-->
                    <div class="col-auto align-self-center">
                        <div class="">
                            <div id="radialBar-1" class="apex-charts my-n2"></div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Customers Details </h4>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="table-responsive">
                    <div id="datatable-1"></div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tabulator/tabulator.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tabulator/jspdf.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tabulator/xlsx.full.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tabulator/jspdf.plugin.autotable.js')}}"></script>
<script src="{{URL::asset('assets/pages/analytics-customers.init.js')}}"></script>
@endsection
