@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/tobii/tobii.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Pages @endslot
@slot('title') Gallery @endslot
@endcomponent

<div class="row">

    <div class="col-md-6 col-lg-auto filters-group-wrap">
        <div class="filters-group mb-3">
            <p class="filter-label mb-0">Filter</p>
            <div class="btn-group filter-options">
                <button class="btn btn-primary" data-group="fashion">Fashion</button>
                <button class="btn btn-primary" data-group="animal">Animal</button>
                <button class="btn btn-primary" data-group="food">Food</button>
            </div>
        </div>
    </div>
</div>


<div id="grid" class="row g-0">
    <div class="col-md-4 col-lg-3 picture-item" data-groups='["fashion"]'>
        <a href="{{URL::asset('assets/images/small/img-1.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-1.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
    <div class="col-md-4 col-lg-3 picture-item picture-item--overlay" data-groups='["food"]'>
        <a href="{{URL::asset('assets/images/small/img-2.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-2.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
    <div class="col-md-4 col-lg-3 picture-item" data-groups='["animal"]'>
        <a href="{{URL::asset('assets/images/small/img-3.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-3.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
    <div class="col-md-4 col-lg-3 picture-item picture-item--h2" data-groups='["food"]'>
        <a href="{{URL::asset('assets/images/small/img-4.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-4.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
    <div class="col-md-4 col-lg-3 picture-item" data-groups='["food", "animal"]'>
        <a href="{{URL::asset('assets/images/small/img-5.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-5.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
    <div class="col-md-4 col-lg-3 picture-item picture-item--overlay" data-groups='["fashion"]'>
        <a href="{{URL::asset('assets/images/small/img-6.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-6.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
    <div class="col-md-4 col-lg-3 picture-item picture-item--h2" data-groups='["food"]'>
        <a href="{{URL::asset('assets/images/small/img-2.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-2.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
    <div class="col-md-4 col-lg-3 picture-item picture-item--h2" data-groups='["fashion"]'>
        <a href="{{URL::asset('assets/images/small/img-1.jpg')}}" class="lightbox">
            <img src="{{URL::asset('assets/images/small/img-1.jpg')}}" alt="" class="img-fluid" />
        </a>
    </div>
</div>

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/shuffle/shuffle.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tobii/tobii.min.js')}}"></script>
<script src="{{URL::asset('assets/pages/gallery.init.js')}}"></script>
@endsection
