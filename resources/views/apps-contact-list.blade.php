@extends('layouts.master')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Advanced UI @endslot
@slot('title') Cantacts @endslot
@endcomponent

<div class="row">
    <div class="col-lg-4">
        <div class="card profile-card">
            <div class="card-body p-0">
                <div class="media p-3  align-items-center">
                    <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                    <div class="media-body ms-3 align-self-center">
                        <h5 class="pro-title">Merri Diamond</h5>
                        <p class="mb-2 text-muted">@SaraHopkins.com</p>
                    </div>
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <a href="" class=""><i class="la la-pen text-secondary font-16 "></i></a>
                        <a href="" class=""><i class="la la-trash-alt text-secondary font-16 "></i></a>
                    </div>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->

    <div class="col-lg-4">
        <div class="card profile-card">
            <div class="card-body p-0">
                <div class="media p-3  align-items-center">
                    <img src="{{URL::asset('assets/images/users/user-5.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                    <div class="media-body ms-3 align-self-center">
                        <h5 class="pro-title">Paul Schmidt</h5>
                        <p class="mb-2 text-muted">@SaraHopkins.com</p>
                    </div>
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <a href="" class=""><i class="la la-pen text-secondary font-16 "></i></a>
                        <a href="" class=""><i class="la la-trash-alt text-secondary font-16 "></i></a>
                    </div>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-4">
        <div class="card profile-card">
            <div class="card-body p-0">
                <div class="media p-3  align-items-center">
                    <img src="{{URL::asset('assets/images/users/user-8.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                    <div class="media-body ms-3 align-self-center">
                        <h5 class="pro-title">Harry McCall</h5>
                        <p class="mb-2 text-muted">@SaraHopkins.com</p>
                    </div>
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <a href="" class=""><i class="la la-pen text-secondary font-16 "></i></a>
                        <a href="" class=""><i class="la la-trash-alt text-secondary font-16 "></i></a>
                    </div>
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
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-8.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-5.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-3.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row">
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-2.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-6.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-8.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-lg-3">
        <div class="card client-card">
            <div class="card-body text-center">
                <img src="{{URL::asset('assets/images/users/user-9.jpg')}}" alt="user" class="rounded-circle thumb-xl">
                <h5 class=" client-name">Wendy Keen</h5>
                <span class="text-muted me-3"><i class="la la-map-marker me-2 text-secondary"></i>New York, USA</span>
                <span class="text-muted"><i class="la la-phone me-2 text-secondary"></i>+1 123 456 789</span>
                <p class="text-muted text-center mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                <button type="button" class="btn btn-sm btn-de-primary">Project</button>
                <button type="button" class="btn btn-sm btn-de-primary">Message</button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection
