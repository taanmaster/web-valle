@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/plugins/animate/animate.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Advanced UI @endslot
@slot('title') Sweet Alert @endslot
@endcomponent

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Trigger modal And Trigger toast</h4>
                <p class="text-muted mb-0">And you can even trigger SweetAlert2 popups declaratively!
                    Use the bindClickHandler() method for that:
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <button type="button" class="btn btn-de-primary btn-sm" data-swal-template="#my-template" onclick="executeExample('TriggerModalToast')">Trigger modal</button>
                <button type="button" class="btn btn-de-primary btn-sm" data-swal-toast-template="#my-template" onclick="executeExample('TriggerModalToast')">Trigger toast</button>
                <template id="my-template">
                    <swal-title>
                        Save changes to "Untitled 1" before closing?
                    </swal-title>
                    <swal-icon type="warning" color="red"></swal-icon>
                    <swal-button type="confirm">
                        Save As
                    </swal-button>
                    <swal-button type="cancel">
                        Cancel
                    </swal-button>
                    <swal-button type="deny">
                        Close without Saving
                    </swal-button>
                    <swal-param name="allowEscapeKey" value="false" />
                    <swal-param name="customClass" value='{ "popup": "my-popup" }' />
                </template>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Icons</h4>
                <p class="text-muted mb-0">A beautiful, responsive, customizable and accessible
                    (WAI-ARIA) replacement for JavaScript's popup boxes.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <button type="button" class="btn btn-de-success btn-sm" onclick="executeExample('success')">Success</button>
                <button type="button" class="btn btn-de-danger btn-sm" onclick="executeExample('error')">Error</button>
                <button type="button" class="btn btn-de-warning btn-sm" onclick="executeExample('warning')">Warning</button>
                <button type="button" class="btn btn-de-info btn-sm" onclick="executeExample('info')">Info</button>
                <button type="button" class="btn btn-de-secondary btn-sm" onclick="executeExample('question')">Question</button>
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
                <h4 class="card-title">Examples</h4>
                <p class="text-muted mb-0">A beautiful, responsive, customizable
                    and accessible (WAI-ARIA) replacement for JavaScript's popup boxes. Zero
                    dependencies.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-pink"></i>A basic message</td>
                                <td class="border-0">
                                    <button class="btn btn-de-primary btn-sm" onclick="executeExample('basicMessage')">
                                        Click me
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-success"></i>A title with a text under</td>
                                <td class="border-0">
                                    <button class="btn btn-de-primary btn-sm" onclick="executeExample('titleText')">
                                        Click me
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-warning"></i>A modal with a title, an error icon, a text, and a footer</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('errorType')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-dark"></i>Custom HTML description and buttons with ARIA labels</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('customHtml')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-pink"></i>A dialog with three buttons</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('threeButtons')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-info"></i>A custom positioned dialog</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('customPosition')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-primary"></i>Custom animation with Animation</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('customAnimation')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-secondary"></i>A confirm dialog, with a function attached to the "Confirm"-button...</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('warningConfirm')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-danger"></i>... and by passing a parameter, you can execute something else for "Cancel".</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('handleDismiss')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-purple"></i>A message with a custom image</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('customImage')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-success"></i>A message with custom width, padding, background and animated Nyan Cat</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('customWidth')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-warning"></i>A message with auto close timer</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('timer')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-info"></i>Right-to-left support for Arabic, Persian, Hebrew, and other RTL languages</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('rtl')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-pink"></i>AJAX request example</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('ajaxRequest')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-pink"></i>Chaining modals (queue) example</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('chainingModals')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-warning"></i>Dynamic queue example</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('dynamicQueue')">Click me</button></td>
                            </tr>

                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-warning"></i>Mixin example</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('mixin')">Click me</button></td>
                            </tr>
                            <tr class="border-0">
                                <td class="border-0"><i class="mdi mdi-circle-outline me-1 text-warning"></i>Declarative template example</td>
                                <td class="border-0"><button type="button" class="btn btn-de-primary btn-sm" onclick="executeExample('declarativeTemplate')">Click me</button></td>
                                <template id="my-template">
                                    <swal-title>
                                        Save changes to "Untitled 1" before closing?
                                    </swal-title>
                                    <swal-icon type="warning" color="red"></swal-icon>
                                    <swal-button type="confirm">
                                        Save As
                                    </swal-button>
                                    <swal-button type="cancel">
                                        Cancel
                                    </swal-button>
                                    <swal-button type="deny">
                                        Close without Saving
                                    </swal-button>
                                    <swal-param name="allowEscapeKey" value="false" />
                                    <swal-param name="customClass" value='{ "popup": "my-popup" }' />
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--table responsive-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{URL::asset('assets/pages/sweet-alert.init.js')}}"></script>
@endsection
