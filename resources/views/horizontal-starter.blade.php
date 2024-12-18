@extends('layouts.horizontal-layout')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb-hori')
@slot('title_1') Starer @endslot
@slot('li_1') Metrica @endslot
@slot('li_2') Dashboards @endslot
@slot('title') Starer @endslot
@endcomponent

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col align-self-center">
                    <h4 class="page-title pb-md-0">Starer</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dastone</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Starer</li>
                    </ol>
                </div>
                <!--end col-->
                <div class="col-auto align-self-center">
                    <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                        <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                        <span class="" id="Select_date">Jan 11</span>
                        <i data-feather="calendar" class="align-self-center icon-xs ms-1"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        <i data-feather="download" class="align-self-center icon-xs"></i>
                    </a>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end page-title-box-->
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection