<div class="leftbar-tab-menu">
    <div class="main-icon-menu">
        <a href="{{ route('dashboard') }}" class="logo logo-metrica d-block text-center">
            <span>
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
            </span>
        </a>
        <div class="main-icon-menu-body">
            <div class="position-reletive h-100" data-simplebar style="overflow-x: hidden;">
                <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Vistas Generales" data-bs-trigger="hover">
                        <a href="#valleDashboard" id="dashboard-tab" class="nav-link">
                            <i class="ti ti-smart-home menu-icon"></i>
                        </a>
                    </li>

                    {{--  
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Apps" data-bs-trigger="hover">
                        <a href="#MetricaApps" id="apps-tab" class="nav-link">
                            <i class="ti ti-apps menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="UI Kit" data-bs-trigger="hover">
                        <a href="#MetricaUikit" id="uikit-tab" class="nav-link">
                            <i class="ti ti-planet menu-icon"></i>
                        </a>
                    </li>
                    --}}

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Documentos" data-bs-trigger="hover">
                        <a href="#valleDocuments" id="pages-tab" class="nav-link">
                            <i class="ti ti-files menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Configuraciones" data-bs-trigger="hover">
                        <a href="#valleConfiguration" id="authentication-tab" class="nav-link">
                            <i class="ti ti-shield-lock menu-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pro-metrica-end">
            <a href="{{ route('admin.profile') }}" class="profile">
                <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( Auth::user()->email ?? 'N/A'))) . '?d=retro&s=150' }}" alt="profile-user" class="rounded-circle thumb-sm">
            </a>
        </div>
    </div>

    <div class="main-menu-inner">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="{{ route('dashboard') }}" class="logo">
                <span>
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo-large" class="logo-lg logo-light">
                </span>
            </a>
        </div>

        <div class="menu-body navbar-vertical tab-content" data-simplebar>
            <div id="valleDashboard" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="dasboard-tab">
                <div class="title-box">
                    <h6 class="menu-title">Vistas Generales</h6>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    {{--  
                    <li class="nav-item">
                        <a class="nav-link" href="ecommerce-index">Pagos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="helpdesk-index">Denuncia Ciudadana</a>
                    </li>
                    --}}
                </ul>
            </div>

            {{-- 
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
                                    </li>
                                    <li class="nav-item">
                                        <a href="analytics-reports" class="nav-link ">Reports</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarAnalytics-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCrypto" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCrypto">
                                Crypto
                            </a>
                            <div class="collapse " id="sidebarCrypto">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-exchange">Exchange</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-wallet">Wallet</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-news">Crypto News</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-ico">ICO List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="crypto-settings">Settings</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarCrypto-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCRM" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCRM">
                                CRM
                            </a>
                            <div class="collapse " id="sidebarCRM">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-contacts">Contacts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-opportunities">Opportunities</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-leads">Leads</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="crm-customers">Customers</a>
                                    </li> 
                                </ul><!--end nav-->
                            </div><!--end sidebarCRM-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarProjects" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarProjects">
                                Projects
                            </a>
                            <div class="collapse " id="sidebarProjects">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-clients">Clients</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-team">Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-project">Project</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-task">Task</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-kanban-board">Kanban Board</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-chat">Chat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-users">Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projects-create">Project Create</a>
                                    </li> 
                                </ul><!--end nav-->
                            </div><!--end sidebarProjects-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarEcommerce" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarEcommerce">
                                Ecommerce
                            </a>
                            <div class="collapse " id="sidebarEcommerce">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-products">Products</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-product-list">Product List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-product-detail">Product Detail</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-cart">Cart</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ecommerce-checkout">Checkout</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarEcommerce-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarHelpdesk" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarHelpdesk">
                                Helpdesk
                            </a>
                            <div class="collapse " id="sidebarHelpdesk">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="helpdesk-teckets">Tickets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="helpdesk-reports">Reports</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="helpdesk-agents">Agents</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarHelpdesk-->
                        </li>

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
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-appointments">All Appointments</a>
                                                </li>
                                            </ul><!--end nav-->
                                        </div><!--end sidebarAppointments-->
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarDoctors" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarDoctors">
                                            Doctors
                                        </a>
                                        <div class="collapse" id="sidebarDoctors">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-doctors">All Doctors</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-add-doctor">Add Doctor</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-doctor-edit">Doctor Edit</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-doctor-profile">Doctor Profile</a>
                                                </li>
                                            </ul><!--end nav-->
                                        </div><!--end sidebarDoctors-->
                                    </li>

                                    <li class="nav-item">
                                        <a href="#sidebarPatients" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarPatients">
                                            Patients
                                        </a>
                                        <div class="collapse" id="sidebarPatients">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-patients">All Patients</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-add-patient">Add Patient</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-patient-edit">Patient Edit</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-patient-profile">Patient Profile</a>
                                                </li>
                                            </ul><!--end nav-->
                                        </div><!--end sidebarPatients-->
                                    </li>

                                    <li class="nav-item">
                                        <a href="#sidebarPayments" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarPayments">
                                            Payments
                                        </a>
                                        <div class="collapse" id="sidebarPayments">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-payments">All Payments</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-payment-invoice">Payment Invoice</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-cashless-payments">Cashless Payments</a>
                                                </li>
                                            </ul><!--end nav-->
                                        </div><!--end sidebarPayments-->
                                    </li>

                                    <li class="nav-item">
                                        <a href="#sidebarStaff" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarStaff">
                                            Staff
                                        </a>
                                        <div class="collapse" id="sidebarStaff">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-staff">All Staff</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-add-member">Add Member</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-edit-member">Edit Member</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-member-profile">Member Profile</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-salary">Staff Salary</a>
                                                </li>
                                            </ul><!--end nav-->
                                        </div><!--end sidebarStaff-->
                                    </li>

                                    <li class="nav-item">
                                        <a href="#sidebarGeneral" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarGeneral">
                                            General
                                        </a>
                                        <div class="collapse" id="sidebarGeneral">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-all-rooms">Room Allotments</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-expenses">Expenses Report</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-departments">Departments</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-insurance-company">Insurance Co.</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-events">Events</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-leaves">Leaves</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-holidays">Holidays</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-attendance">Attendance</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="hospital-chat">Chat</a>
                                                </li>
                                            </ul><!--end nav-->
                                        </div><!--end sidebarGeneral-->
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarHospital-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarEmail" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarEmail">
                                Email
                            </a>
                            <div class="collapse " id="sidebarEmail">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-email-inbox">Inbox</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="apps-email-read">Read Email</a>
                                    </li> 
                                </ul><!--end nav-->
                            </div><!--end sidebarEmail-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="apps-chat">Chat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="apps-contact-list">Contact List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="apps-calendar">Calendar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="apps-invoice">Invoice</a>
                        </li>
                    </ul><!--end navbar-nav--->
                </div><!--end sidebarCollapse-->
            </div>

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
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-avatar">Avatar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-buttons">Buttons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-badges">Badges</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-cards">Cards</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-carousels">Carousels</a>
                                    </li>                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-dropdowns">Dropdowns</a>
                                    </li>                                   
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-grids">Grids</a>
                                    </li>                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-images">Images</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-list">List</a>
                                    </li>                                   
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-modals">Modals</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-navs">Navs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-navbar">Navbar</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-paginations">Paginations</a>
                                    </li>   
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-popover-tooltips">Popover & Tooltips</a>
                                    </li>                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-progress">Progress</a>
                                    </li>                                
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-spinners">Spinners</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-tabs-accordions">Tabs & Accordions</a>
                                    </li>                               
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-typography">Typography</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-videos">Videos</a>
                                    </li> 
                                </ul><!--end nav-->
                            </div><!--end sidebarElements-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarAdvancedUI">
                                Advanced UI
                            </a>
                            <div class="collapse " id="sidebarAdvancedUI">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-animation">Animation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-clipboard">Clip Board</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-dragula">Dragula</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-files">File Manager</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-highlight">Highlight</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-rangeslider">Range Slider</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-ratings">Ratings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-ribbons">Ribbons</a>
                                    </li>                                  
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-sweetalerts">Sweet Alerts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-toasts">Toasts</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarAdvancedUI-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarForms">
                                Forms
                            </a>
                            <div class="collapse " id="sidebarForms">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-elements">Basic Elements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-advanced">Advance Elements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-validation">Validation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-wizard">Wizard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-editors">Editors</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-uploads">File Upload</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-img-crop">Image Crop</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarForms-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCharts">
                            Charts
                            </a>
                            <div class="collapse " id="sidebarCharts">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-apex">Apex</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-justgage">JustGage</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-chartjs">Chartjs</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-toast-ui">Toast</a>
                                    </li> 
                                </ul><!--end nav-->
                            </div><!--end sidebarCharts-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarTables">
                                Tables
                            </a>
                            <div class="collapse " id="sidebarTables">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-basic">Basic</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-datatable">Datatables</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-editable">Editable</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarTables-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarIcons">
                            Icons
                            </a>
                            <div class="collapse " id="sidebarIcons">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-materialdesign">Material Design</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-fontawesome">Font awesome</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-tabler">Tabler</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-feather">Feather</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarIcons-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarMaps">
                                Maps
                            </a>
                            <div class="collapse " id="sidebarMaps">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-google">Google Maps</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-leaflet">Leaflet Maps</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-vector">Vector Maps</a>
                                    </li> 
                                </ul><!--end nav-->
                            </div><!--end sidebarMaps-->
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarEmailTemplates" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarEmailTemplates">
                                Email Templates
                            </a>
                            <div class="collapse " id="sidebarEmailTemplates">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-basic">Basic Action Email</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-alert">Alert Email</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-billing">Billing Email</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarEmailTemplates-->
                        </li>
                    </ul><!--end navbar-nav--->
                </div><!--end sidebarCollapse_2-->
            </div>
             --}}

            <div id="valleDocuments" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="pages-tab">
                <div class="title-box">
                    <h6 class="menu-title">Documentos</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gazettes.index') }}">Gaceta Municipal</a>
                    </li>
                    {{--  
                    <li class="nav-item">
                        <a class="nav-link" href="pages-tour">Licitaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-timeline">Convocatorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-treeview">Documentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-starter">Página de Ejemplo</a>
                    </li>
                    --}}
                </ul>
            </div>

            <div id="valleConfiguration" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="authentication-tab">
                <div class="title-box">
                    <h6 class="menu-title">Configuraciones</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('legals.index') }}">Textos Legales</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>