
<!-- Top Bar Start -->
<div class="topbar">  
    <!-- LOGO -->
    <div class="brand">
        <a href="index" class="logo">
            <span>
                <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm">
            </span>
            <span>
                <img src="{{URL::asset('assets/images/logo.png')}}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{URL::asset('assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end logo-->  
    <!-- Navbar -->
    <nav class="navbar-custom">    
        <ul class="list-unstyled topbar-nav float-end mb-0"> 
            <li class="dropdown hide-phone">
                <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-search"></i>
                </a>                
                <div class="dropdown-menu dropdown-menu-end dropdown-lg p-0">
                    <!-- Top Search Bar -->
                    <div class="app-search-topbar">
                        <form action="#" method="get">
                            <input type="search" name="search" class="from-control top-search mb-0" placeholder="Type text...">
                            <button type="submit"><i class="ti ti-search"></i></button>
                        </form>
                    </div>
                </div>
            </li>                      

            <li class="notification-list">
                <a class="nav-link arrow-none nav-icon offcanvas-btn" href="#" data-bs-toggle="offcanvas" data-bs-target="#Appearance" role="button" aria-controls="Rightbar">
                    <i class="ti ti-settings ti-spin"></i>
                </a>
            </li>                       
            
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-mail"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
                
                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Emails <span class="badge bg-soft-primary badge-pill">3</span>
                    </h6> 
                    <div class="notification-menu" data-simplebar>
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">2 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <img src="{{URL::asset('assets/images/users/user-1.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">10 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Meeting with designers</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">40 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <img src="{{URL::asset('assets/images/users/user-2.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">UX 3 Task complete.</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">1 hr ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <img src="{{URL::asset('assets/images/users/user-5.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">2 hrs ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <img src="{{URL::asset('assets/images/users/user-3.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Payment Successfull</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                    </div>
                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-bell"></i>
                    <span class="alert-badge"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
                
                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Notifications <span class="badge bg-soft-primary badge-pill">2</span>
                    </h6> 
                    <div class="notification-menu" data-simplebar>
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">2 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <i class="ti ti-chart-arcs"></i>
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">10 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <i class="ti ti-device-computer-camera"></i>
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Meeting with designers</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">40 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">                                                    
                                    <i class="ti ti-diamond"></i>
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">UX 3 Task complete.</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">1 hr ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <i class="ti ti-drone"></i>
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-end text-muted ps-2">2 hrs ago</small>
                            <div class="media">
                                <div class="avatar-md bg-soft-primary">
                                    <i class="ti ti-users"></i>
                                </div>
                                <div class="media-body align-self-center ms-2 text-truncate">
                                    <h6 class="my-0 fw-normal text-dark">Payment Successfull</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                    </div>
                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="profile-user" class="rounded-circle me-0 me-md-2 thumb-sm" />
                        <div class="user-name">
                            <small class="d-none d-lg-block font-11">Admin</small>
                            <span class="d-none d-lg-block fw-semibold font-12">Maria Gibson <i
                                    class="mdi mdi-chevron-down"></i></span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="ti ti-settings font-16 me-1 align-text-bottom"></i> Settings</a>
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item" href="#"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Logout</a>
                </div>
            </li><!--end topbar-profile-->
            <li class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle nav-link" id="mobileToggle"  onclick="toggleMenu()" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a><!-- End mobile menu toggle-->
            </li> <!--end menu item--> 
        </ul><!--end topbar-nav-->

        <div class="navbar-custom-menu">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li class="nav-item dropdown parent-menu-item">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDashboards" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                            <span><i class="ti ti-smart-home menu-icon"></i>Dashboards</span>
                        </a>
                        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarDashboards"> 
                            <li>
                                <a class="dropdown-item sub-menu-item" href="horizontal-index">Analytics</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="crypto-index">Crypto</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="crm-index">CRM</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="projects-index">Project</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="ecommerce-index">Ecommerce</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="helpdesk-index">Helpdesk</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="hospital-index">Hospital</a>
                            </li><!--end /li-->  
                        </ul>
                    </li><!--end nav-item-->

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="ti ti-apps menu-icon"></i>Apps</span>
                        </a>
                        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Analytics
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a href="analytics-customers" class="dropdown-item ">Customers</a>
                                    </li>
                                    <li>
                                        <a href="analytics-reports" class="dropdown-item ">Reports</a>
                                    </li>
                                </ul>
                            </li> 
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Crypto
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="crypto-exchange">Exchange</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="crypto-wallet">Wallet</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="crypto-news">Crypto News</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="crypto-ico">ICO List</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="crypto-settings">Settings</a>
                                    </li><!--end /li-->
                                </ul>
                            </li> 
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    CRM
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="crm-contacts">Contacts</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="crm-opportunities">Opportunities</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="crm-leads">Leads</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="crm-customers">Customers</a>
                                    </li><!--end /li--> 
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Projects
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="projects-clients">Clients</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="projects-team">Team</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="projects-project">Project</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="projects-task">Task</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="projects-kanban-board">Kanban Board</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="projects-chat">Chat</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="projects-users">Users</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="projects-create">Project Create</a>
                                    </li><!--end /li--> 
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Ecommerce
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="ecommerce-products">Products</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ecommerce-product-list">Product List</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ecommerce-product-detail">Product Detail</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ecommerce-cart">Cart</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ecommerce-checkout">Checkout</a>
                                    </li><!--end /li-->
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Helpdesk
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="helpdesk-teckets">Tickets</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="helpdesk-reports">Reports</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="helpdesk-agents">Agents</a>
                                    </li><!--end /li-->
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#" id="hospital" aria-labelledby="navbarApps">
                                    Hospital
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#" id="appointments" aria-labelledby="hospital">
                                            Appointments
                                        </a>
                                        <ul class="dropdown-menu animate slideIn">
                                            <li>
                                                <a class="dropdown-item" aria-labelledby="appointments" href="hospital-doctor-shedule">Dr. Shedule</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-all-appointments">All Appointments</a>
                                            </li><!--end /li-->
                                        </ul>
                                    </li><!--end /li-->
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                            Doctors
                                        </a>
                                        <ul class="dropdown-menu animate slideIn">
                                            <li>
                                                <a class="dropdown-item" href="hospital-all-doctors">All Doctors</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-add-doctor">Add Doctor</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-doctor-edit">Doctor Edit</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-doctor-profile">Doctor Profile</a>
                                            </li><!--end /li-->
                                        </ul>
                                    </li><!--end /li-->
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                            Patients
                                        </a>
                                        <ul class="dropdown-menu animate slideIn">
                                            <li>
                                                <a class="dropdown-item" href="hospital-all-patients">All Patients</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-add-patient">Add Patient</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-patient-edit">Patient Edit</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-patient-profile">Patient Profile</a>
                                            </li><!--end /li-->
                                        </ul>
                                    </li><!--end /li-->
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                            Patients
                                        </a>
                                        <ul class="dropdown-menu animate slideIn">
                                            <li>
                                                <a class="dropdown-item" href="hospital-all-patients">All Patients</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-add-patient">Add Patient</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-patient-edit">Patient Edit</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-patient-profile">Patient Profile</a>
                                            </li><!--end /li-->
                                        </ul>
                                    </li><!--end /li-->
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                            Payments
                                        </a>
                                        <ul class="dropdown-menu animate slideIn">
                                            <li>
                                                <a class="dropdown-item" href="hospital-all-payments">All Payments</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-payment-invoice">Payment Invoice</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-cashless-payments">Cashless Payments</a>
                                            </li><!--end /li-->
                                        </ul>
                                    </li><!--end /li-->
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                            Staff
                                        </a>
                                        <ul class="dropdown-menu animate slideIn">
                                            <li>
                                                <a class="dropdown-item" href="hospital-all-staff">All Staff</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-add-member">Add Member</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-edit-member">Edit Member</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-member-profile">Member Profile</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-salary">Staff Salary</a>
                                            </li><!--end /li-->
                                        </ul>
                                    </li><!--end /li-->
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                            General
                                        </a>
                                        <ul class="dropdown-menu animate slideIn">
                                            <li>
                                                <a class="dropdown-item" href="hospital-all-rooms">Room Allotments</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-expenses">Expenses Report</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-departments">Departments</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-insurance-company">Insurance Co.</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-events">Events</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-leaves">Leaves</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-holidays">Holidays</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-attendance">Attendance</a>
                                            </li><!--end /li-->
                                            <li>
                                                <a class="dropdown-item" href="hospital-chat">Chat</a>
                                            </li><!--end /li-->
                                        </ul>
                                    </li><!--end /li-->
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Emails
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a href="apps-email-inbox" class="dropdown-item">Inbox</a>
                                    </li>
                                    <li>
                                        <a href="apps-email-read" class="dropdown-item">Read Email</a>
                                    </li>
                                </ul>
                            </li>                       
                            <li>
                                <a href="apps-chat" class="dropdown-item">
                                    Chat
                                </a>
                            </li>
                            <li>
                                <a href="apps-contact-list" class="dropdown-item">
                                    Contact List
                                </a>
                            </li>
                            <li>
                                <a href="apps-calendar" class="dropdown-item">
                                    Calendar
                                </a>
                            </li>
                            <li>
                                <a href="apps-invoice" class="dropdown-item">
                                    Invoice
                                </a>
                            </li>                    
                        </ul><!--end submenu-->
                    </li><!--end nav-item--> 
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUI_Kit" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="ti ti-planet menu-icon"></i>UI Kit</span>
                        </a>
                        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarUI_Kit">                                    
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#" >
                                    UI Elements
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="ui-alerts">Alerts</a>
                                    </li><!--end /li--> 
                                    <li>
                                        <a class="dropdown-item" href="ui-avatar">Avatar</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-buttons">Buttons</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-badges">Badges</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-cards">Cards</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-carousels">Carousels</a>
                                    </li><!--end /li-->                                
                                    <li>
                                        <a class="dropdown-item" href="ui-dropdowns">Dropdowns</a>
                                    </li><!--end /li-->                                   
                                    <li>
                                        <a class="dropdown-item" href="ui-grids">Grids</a>
                                    </li><!--end /li-->                                
                                    <li>
                                        <a class="dropdown-item" href="ui-images">Images</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-list">List</a>
                                    </li><!--end /li-->                                   
                                    <li>
                                        <a class="dropdown-item" href="ui-modals">Modals</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-navs">Navs</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-navbar">Navbar</a>
                                    </li><!--end /li--> 
                                    <li>
                                        <a class="dropdown-item" href="ui-paginations">Paginations</a>
                                    </li><!--end /li-->   
                                    <li>
                                        <a class="dropdown-item" href="ui-popover-tooltips">Popover & Tooltips</a>
                                    </li><!--end /li-->                                
                                    <li>
                                        <a class="dropdown-item" href="ui-progress">Progress</a>
                                    </li><!--end /li-->                                
                                    <li>
                                        <a class="dropdown-item" href="ui-spinners">Spinners</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-tabs-accordions">Tabs & Accordions</a>
                                    </li><!--end /li-->                               
                                    <li>
                                        <a class="dropdown-item" href="ui-typography">Typography</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="ui-videos">Videos</a>
                                    </li><!--end /li-->                                                     
                                </ul>                                      
                            </li><!--end nav-item-->
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Advanced UI
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="advanced-animation">Animation</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="advanced-clipboard">Clip Board</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="advanced-dragula">Dragula</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="advanced-files">File Manager</a>
                                    </li><!--end /li--> 
                                    <li>
                                        <a class="dropdown-item" href="advanced-highlight">Highlight</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="advanced-rangeslider">Range Slider</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="advanced-ratings">Ratings</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="advanced-ribbons">Ribbons</a>
                                    </li><!--end /li-->                                  
                                    <li>
                                        <a class="dropdown-item" href="advanced-sweetalerts">Sweet Alerts</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="advanced-toasts">Toasts</a>
                                    </li><!--end /li-->
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Forms
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="forms-elements">Basic Elements</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="forms-advanced">Advance Elements</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="forms-validation">Validation</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="forms-wizard">Wizard</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="forms-editors">Editors</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="forms-uploads">File Upload</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="forms-img-crop">Image Crop</a>
                                    </li><!--end /li--> 
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Charts
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="charts-apex">Apex</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="charts-justgage">JustGage</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="charts-chartjs">Chartjs</a>
                                    </li><!--end /li--> 
                                    <li>
                                        <a class="dropdown-item" href="charts-toast-ui">Toast</a>
                                    </li><!--end /li-->
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Tables
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="tables-basic">Basic</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="tables-datatable">Datatables</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="tables-editable">Editable</a>
                                    </li><!--end /li-->
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Icons
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="icons-materialdesign">Material Design</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="icons-fontawesome">Font awesome</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="icons-tabler">Tabler</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="icons-feather">Feather</a>
                                    </li><!--end /li-->
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Maps
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="maps-google">Google Maps</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="maps-leaflet">Leaflet Maps</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="maps-vector">Vector Maps</a>
                                    </li><!--end /li-->  
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    Email Templates
                                </a>
                                <ul class="dropdown-menu animate slideIn">
                                    <li>
                                        <a class="dropdown-item" href="email-templates-alert">Alert Email</a>
                                    </li><!--end /li-->
                                    <li>
                                        <a class="dropdown-item" href="email-templates-basic">Basic Action Email</a>
                                    </li><!--end /li-->                                    
                                    <li>
                                        <a class="dropdown-item" href="email-templates-billing">Billing Email</a>
                                    </li><!--end /li-->
                                </ul>
                            </li><!--end nav-item-->                     
                        </ul><!--end submenu-->
                    </li><!--end nav-item-->

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="ti ti-file-diff menu-icon"></i>Pages</span>
                        </a>
                        <ul class="dropdown-menu  animate slideIn" aria-labelledby="navbarPages">
                            <li>
                                <a class="dropdown-item" href="pages-profile">Profile</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="pages-tour">Tour</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="pages-timeline">Timeline</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="pages-treeview">Treeview</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="horizontal-starter">Starter Page</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="pages-pricing">Pricing</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="pages-blogs">Blogs</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="pages-faq">FAQs</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="pages-gallery">Gallery</a>
                            </li><!--end /li-->                                            
                        </ul>
                    </li><!--end nav-item-->

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbar_auth" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="ti ti-shield-lock menu-icon"></i>Authentication</span>
                        </a>
                        <ul class="dropdown-menu  animate slideIn" aria-labelledby="navbar_auth">
                            <li>
                                <a class="dropdown-item" href="auth-login">Log in</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-login-alt">Log in alt</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-register">Register</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-register-alt">Register-alt</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-recover-pw">Re-Password</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-recover-pw-alt">Re-Password-alt</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-lock-screen">Lock Screen</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-lock-screen-alt">Lock Screen-alt</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-404">Error 404</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-404-alt">Error 404-alt</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-500">Error 500</a>
                            </li><!--end /li-->
                            <li>
                                <a class="dropdown-item" href="auth-500-alt">Error 500-alt</a>
                            </li><!--end /li-->
                        </ul><!--end submenu-->
                    </li><!--end nav-item-->                    
                </ul><!-- End navigation menu -->
            </div> <!-- end navigation -->
        </div>
        <!-- Navbar -->
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->


