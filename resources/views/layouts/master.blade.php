<!doctype html>
<html>

<head>
    <meta charset="utf-8">

    {{--  
    <title> @yield('title')| - Intranet</title>
    --}}
    <title>Valle de Santiago | - Intranet</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Intranet" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    @include('layouts.head-css')

    <style>
        .leftbar-tab-menu .main-menu-inner .topbar-left .logo .logo-lg {
            height: 70px;
            margin-left: 17px;
            margin-top: 16px;
        }

        .leftbar-tab-menu .main-icon-menu{
            background-color: #551312;
        }

        .leftbar-tab-menu .main-icon-menu .main-icon-menu-body .nav.nav-tabs .nav-link.active, .leftbar-tab-menu .main-icon-menu .main-icon-menu-body .nav.nav-tabs .nav-link:active{
            color: #7C3235 !important;
        }

        .leftbar-tab-menu .main-menu-inner .menu-body .nav-item .nav-link.active, .leftbar-tab-menu .main-menu-inner .menu-body .nav-item .nav-link.active i{
            color: #7C3235;
        }

        .leftbar-tab-menu .main-icon-menu .main-icon-menu-body .nav.nav-tabs .nav-link.active, .leftbar-tab-menu .main-icon-menu .main-icon-menu-body .nav.nav-tabs .nav-link:focus{
            background-color: #7C3235 !important;
        }

        .leftbar-tab-menu .main-icon-menu .main-icon-menu-body .nav.nav-tabs .nav-link{
            background-color: rgba(124, 50, 53, .3); 
        }

        .leftbar-tab-menu .main-icon-menu .pro-metrica-end{
            background-color: transparent;
        }
    </style>
</head>

<body id="body" class="">
        @include('layouts.left-sidebar-tab')
        @include('layouts.topbar')
    <!-- Begin page -->
    <div class="page-wrapper">

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

            <div class="page-content-tab">
                <!-- Start content -->
                <div class="container-fluid">
                   
                   @yield('content')
                   
                </div> <!-- content -->
            </div>
            @include('layouts.footer')

        <a href="javascript:void(0)" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    </div>
    <!-- END wrapper -->

    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

    @include('layouts.vendor-scripts')
</body>

</html>
