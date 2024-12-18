@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/fullcalendar/main.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Ecommerce @endslot
@slot('title') Products @endslot
@endcomponent

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon1 rib1-primary">
                    <span class="text-white text-center rib1-primary">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/05.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Electric</p>
                        <a href="#" class="header-title">Fever Gun</a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$49.00 <small class="text-muted font-14"><del>$99.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon1 rib1-primary">
                    <span class="text-white text-center rib1-primary">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/04.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Covid Safety</p>
                        <a href="#" class="header-title">N95 Mask</a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$9.00 <small class="text-muted font-14"><del>$18.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon1 rib1-primary">
                    <span class="text-white text-center rib1-primary">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/03.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Entertainment</p>
                        <a href="#" class="header-title">Imported VR Box</a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$39.00 <small class="text-muted font-14"><del>$99.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon1 rib1-primary">
                    <span class="text-white text-center rib1-primary">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/02.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Fashion & Life Style</p>
                        <a href="#" class="header-title">New Colorfull Shoes
                        </a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$39.00 <small class="text-muted font-14"><del>$99.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
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
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon4 rib4-primary">
                    <span class="ribbon4-band ribbon4-band-primary text-white text-center">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/06.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Fashion & Life Style</p>
                        <a href="#" class="header-title">Hand Bag</a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$69.00 <small class="text-muted font-14"><del>$99.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon4 rib4-primary">
                    <span class="ribbon4-band ribbon4-band-primary text-white text-center">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/01.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Security</p>
                        <a href="#" class="header-title">White Table Camera</a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$120.00 <small class="text-muted font-14"><del>$249.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon4 rib4-primary">
                    <span class="ribbon4-band ribbon4-band-primary text-white text-center">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/02.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Fashion & Life Style</p>
                        <a href="#" class="header-title">New Colorfull Shoes
                        </a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$39.00 <small class="text-muted font-14"><del>$99.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="ribbon4 rib4-primary">
                    <span class="ribbon4-band ribbon4-band-primary text-white text-center">50% off</span>
                </div>
                <!--end ribbon-->
                <img src="{{URL::asset('assets/images/products/07.png')}}" alt="" class="d-block mx-auto my-4" height="150">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <div>
                        <p class="text-muted mb-2">Life Style</p>
                        <a href="#" class="header-title">Unique Blue Bag</a>
                    </div>
                    <div>
                        <h4 class="text-dark mt-0 mb-2">$20.00 <small class="text-muted font-14"><del>$49.00</del></small></h4>
                        <ul class="list-inline mb-0 product-review align-self-center">
                            <li class="list-inline-item"><i class="la la-star text-warning font-16"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star text-warning font-16 ms-n2"></i></li>
                            <li class="list-inline-item"><i class="la la-star-half-o text-warning font-16 ms-n2"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-de-primary">Add To Cart</button>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection