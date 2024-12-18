@extends('layouts.master')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Hospital @endslot
@slot('title') Shedule @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-de-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-animation="bounce" data-bs-target=".bs-example-modal-lg">Add New Shedule</button>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Doctor Name</th>
                                <th>Department</th>
                                <th>Working days</th>
                                <th>Time</th>
                                <th>Extra Info</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            <!--end tr-->
                        </thead>

                        <tbody>
                            <tr>
                                <td><img src="{{URL::asset('assets/images/users/user-1.jpg')}}" alt="" class="thumb-sm rounded-circle me-2">Dr.Thomas Fant</td>
                                <td>Orthopedic</td>
                                <td>Monday,Tuesday</td>
                                <td>11:00 am to 03:00pm </td>
                                <td>-</td>
                                <td><span class="badge badge-soft-success">Active</span></td>
                                <td>
                                    <a href="#"><i class="las la-pen text-secondary font-18"></i></a>
                                    <a href="#"><i class="las la-trash-alt text-secondary font-18"></i></a>
                                </td>
                            </tr>
                            <!--end tr-->
                            <tr>
                                <td><img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="" class="thumb-sm rounded-circle me-2">Dr.Helen White</td>
                                <td>Neurology</td>
                                <td>Friday, Saturday</td>
                                <td>03:30 pm to 10:00 pm</td>
                                <td>-</td>
                                <td><span class="badge badge-soft-danger">Inactive</span></td>
                                <td>
                                    <a href="#"><i class="las la-pen text-secondary font-18"></i></a>
                                    <a href="#"><i class="las la-trash-alt text-secondary font-18"></i></a>
                                </td>
                            </tr>
                            <!--end tr-->
                            <tr>
                                <td><img src="{{URL::asset('assets/images/users/user-6.jpg')}}" alt="" class="thumb-sm rounded-circle me-2">Dr.Aretha Garland</td>
                                <td>Neurology</td>
                                <td>Monday</td>
                                <td>09:30 am to 12:30 pm</td>
                                <td>Going to Family Function</td>
                                <td><span class="badge badge-soft-success">Active</span></td>
                                <td>
                                    <a href="#"><i class="las la-pen text-secondary font-18"></i></a>
                                    <a href="#"><i class="las la-trash-alt text-secondary font-18"></i></a>
                                </td>
                            </tr>
                            <!--end tr-->
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Add New Shedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="DoctorName_select" class="me-2 form-label">Doctor Name</label>
                                <select class="form-select" id="DoctorName_select">
                                    <option selected="">-- Select --</option>
                                    <option value="1">Dr.Thomas Fant</option>
                                    <option value="2">Dr.Justin Williams</option>
                                    <option value="3">Dr.Aretha Garland</option>
                                    <option value="4">Dr.Lea Sanchez</option>
                                    <option value="5">Dr.Helen White</option>
                                    <option value="6">Dr.William Gonzalez</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Department_select" class="me-2 form-label">Department</label>
                                <select class="form-select" id="Department_select">
                                    <option selected="">-- Select --</option>
                                    <option value="1">Orthopedic</option>
                                    <option value="2">Fizioterapie</option>
                                    <option value="3">Cardiology</option>
                                    <option value="4">Gynaecology</option>
                                    <option value="5">Neurology</option>
                                    <option value="6">Psychology</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label my-2" for="AppoDate">Days</label>
                                <input type="text" class="form-control" id="AppoDate" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label my-2" for="AppoTime">Time</label>
                                <input type="text" class="form-control" id="AppoTime" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label my-2" for="message">Extra Info</label>
                                <textarea class="form-control" rows="3" id="message"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-de-primary">Save</button>
                    <button type="button" class="btn btn-sm btn-de-danger">Delete</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
