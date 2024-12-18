<div class="leftbar-tab-menu">
    <div class="main-icon-menu">
        <a href="index" class="logo logo-metrica d-block text-center">
            <span>
                <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm">
            </span>
        </a>
        <div class="main-icon-menu-body">
            <div class="position-reletive h-100" data-simplebar style="overflow-x: hidden;">
                <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard" data-bs-trigger="hover">
                        <a href="#MetricaDashboard" id="dashboard-tab" class="nav-link">
                            <i class="ti ti-smart-home menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Apps" data-bs-trigger="hover">
                        <a href="#MetricaApps" id="apps-tab" class="nav-link">
                            <i class="ti ti-apps menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Uikit" data-bs-trigger="hover">
                        <a href="#MetricaUikit" id="uikit-tab" class="nav-link">
                            <i class="ti ti-planet menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Pages" data-bs-trigger="hover">
                        <a href="#MetricaPages" id="pages-tab" class="nav-link">
                            <i class="ti ti-files menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Authentication" data-bs-trigger="hover">
                        <a href="#MetricaAuthentication" id="authentication-tab" class="nav-link">
                            <i class="ti ti-shield-lock menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                </ul><!--end nav-->
            </div><!--end /div-->
        </div><!--end main-icon-menu-body-->
        <div class="pro-metrica-end">
            <a href="" class="profile">
                <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="profile-user" class="rounded-circle thumb-sm">
            </a>
        </div><!--end pro-metrica-end-->
    </div>
    <!--end main-icon-menu-->

    <div class="main-menu-inner">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="index" class="logo">
                <span>
                    <img src="{{URL::asset('assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg logo-dark">
                    <img src="{{URL::asset('assets/images/logo.png')}}" alt="logo-large" class="logo-lg logo-light">
                </span>
            </a><!--end logo-->
        </div><!--end topbar-left-->
        <!--end logo-->
        <div class="menu-body navbar-vertical tab-content" data-simplebar>
            <div id="MetricaDashboard" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="dasboard-tab">
                <div class="title-box">
                    <h6 class="menu-title">Dashboard</h6>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index">Analytics</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="crypto-index">Crypto</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="crm-index">CRM</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="projects-index">Project</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="ecommerce-index">Ecommerce</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="helpdesk-index">Helpdesk</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="hospital-index">Hospital</a>
                    </li><!--end nav-item-->
                </ul><!--end nav-->
            </div><!-- end Dashboards -->

            <div id="MetricaApps" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="apps-tab">
                <div class="title-box">
                    <h6 class="menu-title">Apps</h6>
                </div>

                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarAnalytics">
                                Analytics
                            </a>
                            <div class="collapse " id="sidebarAnalytics">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="analytics-customers" class="nav-link ">Customers</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a href="analytics-reports" class="nav-link ">Reports</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarAnalytics-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCrypto" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCrypto">
                                Crypto
                            </a>
                            <div class="collapse " id="sidebarCrypto">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-exchange">Exchange</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-wallet">Wallet</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-news">Crypto News</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-ico">ICO List</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-settings">Settings</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarCrypto-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCRM" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCRM">
                                CRM
                            </a>
                            <div class="collapse " id="sidebarCRM">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-contacts">Contacts</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-opportunities">Opportunities</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-leads">Leads</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-customers">Customers</a>
                                    </li><!--end nav-item--> 
                                </ul><!--end nav-->
                            </div><!--end sidebarCRM-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarProjects" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarProjects">
                                Projects
                            </a>
                            <div class="collapse " id="sidebarProjects">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-clients">Clients</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-team">Team</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-project">Project</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-task">Task</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-kanban-board">Kanban Board</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-chat">Chat</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-users">Users</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-create">Project Create</a>
                                    </li><!--end nav-item--> 
                                </ul><!--end nav-->
                            </div><!--end sidebarProjects-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarEcommerce" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarEcommerce">
                                Ecommerce
                            </a>
                            <div class="collapse " id="sidebarEcommerce">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-products">Products</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-product-list">Product List</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-product-detail">Product Detail</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-cart">Cart</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-checkout">Checkout</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarEcommerce-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarHelpdesk" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarHelpdesk">
                                Helpdesk
                            </a>
                            <div class="collapse " id="sidebarHelpdesk">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="helpdesk-teckets">Tickets</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="helpdesk-reports">Reports</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="helpdesk-agents">Agents</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarHelpdesk-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarHospital" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarHospital">
                                Hospital
                            </a>
                            <div class="collapse " id="sidebarHospital">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#sidebarAppointments " class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarAppointments">
                                            Appointments 
                                        </a>
                                        <div class="collapse " id="sidebarAppointments">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-doctor-shedule">Dr. Shedule</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-appointments">All Appointments</a>
                                                </li><!--end nav-item-->
                                            </ul><!--end nav-->
                                        </div><!--end sidebarAppointments-->
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a href="#sidebarDoctors" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarDoctors">
                                            Doctors
                                        </a>
                                        <div class="collapse" id="sidebarDoctors">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-doctors">All Doctors</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-add-doctor">Add Doctor</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-doctor-edit">Doctor Edit</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-doctor-profile">Doctor Profile</a>
                                                </li><!--end nav-item-->
                                            </ul><!--end nav-->
                                        </div><!--end sidebarDoctors-->
                                    </li><!--end nav-item-->

                                    <li class="nav-item">
                                        <a href="#sidebarPatients" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarPatients">
                                            Patients
                                        </a>
                                        <div class="collapse" id="sidebarPatients">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-patients">All Patients</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-add-patient">Add Patient</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-patient-edit">Patient Edit</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-patient-profile">Patient Profile</a>
                                                </li><!--end nav-item-->
                                            </ul><!--end nav-->
                                        </div><!--end sidebarPatients-->
                                    </li><!--end nav-item-->

                                    <li class="nav-item">
                                        <a href="#sidebarPayments" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarPayments">
                                            Payments
                                        </a>
                                        <div class="collapse" id="sidebarPayments">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-payments">All Payments</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-payment-invoice">Payment Invoice</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-cashless-payments">Cashless Payments</a>
                                                </li><!--end nav-item-->
                                            </ul><!--end nav-->
                                        </div><!--end sidebarPayments-->
                                    </li><!--end nav-item-->

                                    <li class="nav-item">
                                        <a href="#sidebarStaff" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarStaff">
                                            Staff
                                        </a>
                                        <div class="collapse" id="sidebarStaff">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-staff">All Staff</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-add-member">Add Member</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-edit-member">Edit Member</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-member-profile">Member Profile</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-salary">Staff Salary</a>
                                                </li><!--end nav-item-->
                                            </ul><!--end nav-->
                                        </div><!--end sidebarStaff-->
                                    </li><!--end nav-item-->

                                    <li class="nav-item">
                                        <a href="#sidebarGeneral" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarGeneral">
                                            General
                                        </a>
                                        <div class="collapse" id="sidebarGeneral">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-rooms">Room Allotments</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-expenses">Expenses Report</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-departments">Departments</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-insurance-company">Insurance Co.</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-events">Events</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-leaves">Leaves</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-holidays">Holidays</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-attendance">Attendance</a>
                                                </li><!--end nav-item-->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-chat">Chat</a>
                                                </li><!--end nav-item-->
                                            </ul><!--end nav-->
                                        </div><!--end sidebarGeneral-->
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarHospital-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarEmail" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarEmail">
                                Email
                            </a>
                            <div class="collapse " id="sidebarEmail">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-email-inbox">Inbox</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-email-read">Read Email</a>
                                    </li><!--end nav-item--> 
                                </ul><!--end nav-->
                            </div><!--end sidebarEmail-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="apps-chat">Chat</a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="apps-contact-list">Contact List</a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="apps-calendar">Calendar</a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="apps-invoice">Invoice</a>
                        </li><!--end nav-item-->
                    </ul><!--end navbar-nav--->
                </div><!--end sidebarCollapse-->
            </div><!-- end Crypto -->

            <div id="MetricaUikit" class="main-icon-menu-pane  tab-pane" role="tabpanel"
                aria-labelledby="uikit-tab">
                <div class="title-box">
                    <h6 class="menu-title">UI Kit</h6>
                </div>
                <div class="collapse navbar-collapse" id="sidebarCollapse_2">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarElements">
                            UI Elements
                            </a>
                            <div class="collapse " id="sidebarElements">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-alerts">Alerts</a>
                                    </li><!--end nav-item--> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-avatar">Avatar</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-buttons">Buttons</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-badges">Badges</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-cards">Cards</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-carousels">Carousels</a>
                                    </li><!--end nav-item-->                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-dropdowns">Dropdowns</a>
                                    </li><!--end nav-item-->                                   
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-grids">Grids</a>
                                    </li><!--end nav-item-->                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-images">Images</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-list">List</a>
                                    </li><!--end nav-item-->                                   
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-modals">Modals</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-navs">Navs</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-navbar">Navbar</a>
                                    </li><!--end nav-item--> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-paginations">Paginations</a>
                                    </li><!--end nav-item-->   
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-popover-tooltips">Popover & Tooltips</a>
                                    </li><!--end nav-item-->                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-progress">Progress</a>
                                    </li><!--end nav-item-->                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-spinners">Spinners</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-tabs-accordions">Tabs & Accordions</a>
                                    </li><!--end nav-item-->                               
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-typography">Typography</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-videos">Videos</a>
                                    </li><!--end nav-item--> 
                                </ul><!--end nav-->
                            </div><!--end sidebarElements-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarAdvancedUI">
                                Advanced UI
                            </a>
                            <div class="collapse " id="sidebarAdvancedUI">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-animation">Animation</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-clipboard">Clip Board</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-dragula">Dragula</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-files">File Manager</a>
                                    </li><!--end nav-item--> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-highlight">Highlight</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-rangeslider">Range Slider</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-ratings">Ratings</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-ribbons">Ribbons</a>
                                    </li><!--end nav-item-->                                  
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-sweetalerts">Sweet Alerts</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-toasts">Toasts</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarAdvancedUI-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarForms">
                                Forms
                            </a>
                            <div class="collapse " id="sidebarForms">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-elements">Basic Elements</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-advanced">Advance Elements</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-validation">Validation</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-wizard">Wizard</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-editors">Editors</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-uploads">File Upload</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-img-crop">Image Crop</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarForms-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCharts">
                            Charts
                            </a>
                            <div class="collapse " id="sidebarCharts">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-apex">Apex</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-justgage">JustGage</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-chartjs">Chartjs</a>
                                    </li><!--end nav-item--> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-toast-ui">Toast</a>
                                    </li><!--end nav-item--> 
                                </ul><!--end nav-->
                            </div><!--end sidebarCharts-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarTables">
                                Tables
                            </a>
                            <div class="collapse " id="sidebarTables">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-basic">Basic</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-datatable">Datatables</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-editable">Editable</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarTables-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarIcons">
                            Icons
                            </a>
                            <div class="collapse " id="sidebarIcons">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-materialdesign">Material Design</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-fontawesome">Font awesome</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-tabler">Tabler</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-feather">Feather</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarIcons-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarMaps">
                                Maps
                            </a>
                            <div class="collapse " id="sidebarMaps">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-google">Google Maps</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-leaflet">Leaflet Maps</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-vector">Vector Maps</a>
                                    </li><!--end nav-item--> 
                                </ul><!--end nav-->
                            </div><!--end sidebarMaps-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarEmailTemplates" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarEmailTemplates">
                                Email Templates
                            </a>
                            <div class="collapse " id="sidebarEmailTemplates">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-basic">Basic Action Email</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-alert">Alert Email</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-billing">Billing Email</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarEmailTemplates-->
                        </li><!--end nav-item-->
                    </ul><!--end navbar-nav--->
                </div><!--end sidebarCollapse_2-->
            </div><!-- end Others -->

            <div id="MetricaPages" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="pages-tab">
                <div class="title-box">
                    <h6 class="menu-title">Pages</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="pages-profile">Profile</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-tour">Tour</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-timeline">Timeline</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-treeview">Treeview</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-starter">Starter Page</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-pricing">Pricing</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-blogs">Blogs</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-faq">FAQs</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages-gallery">Gallery</a>
                    </li><!--end nav-item-->
                </ul><!--end nav-->
            </div><!-- end Pages -->

            <div id="MetricaAuthentication" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="authentication-tab">
                <div class="title-box">
                    <h6 class="menu-title">Authentication</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="auth-login">Log in</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-login-alt">Log in alt</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-register">Register</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-register-alt">Register-alt</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-recover-pw">Re-Password</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-recover-pw-alt">Re-Password-alt</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-lock-screen">Lock Screen</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-lock-screen-alt">Lock Screen-alt</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-404">Error 404</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-404-alt">Error 404-alt</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-500">Error 500</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="auth-500-alt">Error 500-alt</a>
                    </li><!--end nav-item-->
                </ul><!--end nav-->
            </div><!-- end Authentication-->
        </div>
        <!--end menu-body-->
    </div><!-- end main-menu-inner-->
</div>