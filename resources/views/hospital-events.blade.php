@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/fullcalendar/main.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Hospital @endslot
@slot('title') Events @endslot
@endcomponent

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <img src="{{URL::asset('assets/images/small/calendar.svg')}}" alt="" class="img-fluid">
                <ul class="list-group">
                    <li class="list-group-item align-items-center d-flex">
                        <div class="media">
                            <img src="{{URL::asset('assets/images/small/project-1.jpg')}}" class="me-3 thumb-sm align-self-center rounded-circle" alt="...">
                            <div class="media-body align-self-center">
                                <h6 class="mt-0 mb-1">Meeting with UI/UX Designers</h6>
                                <p class="text-muted mb-0">Today 07:30 AM</p>
                            </div>
                            <!--end media body-->
                        </div>
                    </li>
                    <li class="list-group-item align-items-center ">
                        <div class="media">
                            <img src="{{URL::asset('assets/images/users/user-5.jpg')}}" class="me-3 thumb-sm align-self-center rounded-circle" alt="...">
                            <div class="media-body align-self-center">
                                <h6 class="mt-0 mb-1">Lunch with my friend</h6>
                                <p class="text-muted mb-0">Today 12:30 PM</p>
                            </div>
                            <!--end media body-->
                        </div>
                    </li>
                    <li class="list-group-item align-items-center">
                        <div class="media">
                            <img src="{{URL::asset('assets/images/small/project-3.jpg')}}" class="me-3 thumb-sm align-self-center rounded-circle" alt="...">
                            <div class="media-body align-self-center">
                                <h6 class="mt-0 mb-1">Call for payment Project ID : #254136</h6>
                                <p class="text-muted mb-0">Tomorrow 10:30 AM</p>
                            </div>
                            <!--end media body-->
                        </div>
                    </li>
                    <li class="list-group-item align-items-center ">
                        <div class="media">
                            <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" class="me-3 thumb-sm align-self-center rounded-circle" alt="...">
                            <div class="media-body align-self-center">
                                <h6 class="mt-0 mb-1">Picnic with my Family</h6>
                                <p class="text-muted mb-0">01 June 2019 - 09:30 AM</p>
                            </div>
                            <!--end media body-->
                        </div>
                    </li>
                    <li class="list-group-item align-items-center">
                        <div class="media">
                            <img src="{{URL::asset('assets/images/small/project-4.jpg')}}" class="me-3 thumb-sm align-self-center rounded-circle" alt="...">
                            <div class="media-body align-self-center">
                                <h6 class="mt-0 mb-1">Meeting with Developers</h6>
                                <p class="text-muted mb-0">04 June 2019 - 07:30 AM</p>
                            </div>
                            <!--end media body-->
                        </div>
                    </li>
                </ul>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div id='calendar'></div>
                <div style='clear:both'></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div><!-- End row -->

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/fullcalendar/main.min.js')}}"></script>
<script src="{{URL::asset('assets/pages/calendar.init.js')}}"></script>
@endsection
