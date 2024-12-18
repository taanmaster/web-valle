@extends('layouts.master')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') UI Kit @endslot
@slot('title') Carousels @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 offset-lg-1 align-self-center">
                        <div class="p-5">
                            <span class="bg-soft-pink p-2 rounded">Mannat Themes</span>
                            <h1 class="my-4 font-weight-bold">Manage Your Work With <span class="text-primary">Metrica</span>.</h1>
                            <p class="font-14 text-muted">Metrica is a Bootstrap 4 admin dashboard,
                                It is fully responsive and included awesome features
                                to help build web applications fast and easy.
                            </p>
                            <button type="button" class="btn btn-de-primary">Get Started</button>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-5 offset-lg-1 text-center">

                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{URL::asset('assets/images/small/img-2.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-1.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-3.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                            </div>
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
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 text-center">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{URL::asset('assets/images/small/img-4.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-5.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-6.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-5 offset-lg-1 align-self-center">
                        <div class="p-5">
                            <span class="bg-soft-pink p-2 rounded">Mannat Themes</span>
                            <h1 class="my-4 font-weight-bold">Manage Your Work With <span class="text-primary">Metrica</span>.</h1>
                            <p class="font-14 text-muted">Metrica is a Bootstrap 4 admin dashboard,
                                It is fully responsive and included awesome features
                                to help build web applications fast and easy.
                            </p>
                            <button type="button" class="btn btn-de-primary">Get Started</button>
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
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 offset-lg-1 align-self-center">
                        <div class="p-5">
                            <span class="bg-soft-pink p-2 rounded">Mannat Themes</span>
                            <h1 class="my-4 font-weight-bold">Manage Your Work With <span class="text-primary">Metrica</span>.</h1>
                            <p class="font-14 text-muted">Metrica is a Bootstrap 4 admin dashboard,
                                It is fully responsive and included awesome features
                                to help build web applications fast and easy.
                            </p>
                            <button type="button" class="btn btn-de-primary">Get Started</button>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-5 offset-lg-1 text-center">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{URL::asset('assets/images/small/img-5.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-4.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-2.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
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
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 text-center">
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{URL::asset('assets/images/small/img-6.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-1.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{URL::asset('assets/images/small/img-3.jpg')}}" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-5 offset-lg-1 align-self-center">
                        <div class="p-5">
                            <span class="bg-soft-pink p-2 rounded">Mannat Themes</span>
                            <h1 class="my-4 font-weight-bold">Manage Your Work With <span class="text-primary">Metrica</span>.</h1>
                            <p class="font-14 text-muted">Metrica is a Bootstrap 4 admin dashboard,
                                It is fully responsive and included awesome features
                                to help build web applications fast and easy.
                            </p>
                            <button type="button" class="btn btn-de-primary">Get Started</button>
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

@endsection