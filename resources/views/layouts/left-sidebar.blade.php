<div class="left-sidebar">
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
    <div class="menu-content h-100" data-simplebar>
        <div class="menu-body navbar-vertical tab-content">
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="menu-label mt-0">M<span>ain</span></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAnalytics">
                            <i class="ti ti-home menu-icon"></i>
                            <span>Dashboards</span>
                        </a>
                        <div class="collapse " id="sidebarDashboards">
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
                        </div><!--end sidebarDashboards-->
                    </li><!--end nav-item-->
                    <li class="menu-label mt-0">A<span>pps</span></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAnalytics">
                            <i class="ti ti-stack menu-icon"></i>
                            <span>Analytics</span>
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
                            <i class="ti ti-currency-bitcoin menu-icon"></i>
                            <span>Crypto</span>
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
                            <i class="ti ti-ball-football menu-icon"></i>
                            <span>CRM</span>
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
                            <i class="ti ti-brand-asana menu-icon"></i>
                            <span>Projects</span>
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
                            <i class="ti ti-shopping-cart menu-icon"></i>
                            <span>Ecommerce</span>
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
                            <i class="ti ti-headset menu-icon"></i>
                            <span>Helpdesk</span>
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
                            aria-expanded="false" aria-controls="sidebarHospital" id="hospital">
                            <i class="ti ti-building-hospital menu-icon"></i>
                            <span>Hospital</span>
                        </a>
                        <div class="collapse " id="sidebarHospital">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#sidebarAppointments " class="nav-link" data-bs-toggle="collapse" id="appointments"
                                        role="button" aria-expanded="false" aria-controls="sidebarAppointments" aria-labelledby="hospital">
                                        Appointments 
                                    </a>
                                    <div class="collapse " id="sidebarAppointments">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" aria-labelledby="appointments" href="hospital-doctor-shedule">Dr. Shedule</a>
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
                            <i class="ti ti-mail menu-icon"></i>
                            <span>Email</span>
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
                        <a class="nav-link" href="apps-chat"><i class="ti ti-brand-hipchat menu-icon"></i><span>Chat</span></a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="apps-contact-list"><i class="ti ti-headphones menu-icon"></i><span>Contact List</span></a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="apps-calendar"><i class="ti ti-calendar menu-icon"></i><span>Calendar</span></a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="apps-invoice"><i class="ti ti-file-invoice menu-icon"></i><span>Invoice</span></a>
                    </li><!--end nav-item-->
                    <li class="menu-label mt-0">C<span>omponents</span></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarElements">
                            <i class="ti ti-planet menu-icon"></i>
                        <span>UI Elements</span>
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
                            <i class="ti ti-chart-bubble menu-icon"></i>
                            <span>Advanced UI</span>
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
                            <i class="ti ti-forms menu-icon"></i>
                            <span>Forms</span>
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
                            <i class="ti ti-chart-donut menu-icon"></i>
                        <span>Charts</span>
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
                            <i class="ti ti-table menu-icon"></i>
                            <span>Tables</span>
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
                            <i class="ti ti-parachute menu-icon"></i>
                        <span>Icons</span>
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
                            <i class="ti ti-map menu-icon"></i>
                            <span>Maps</span>
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
                            <i class="ti ti-target menu-icon"></i>
                            <span>Email Templates</span>
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
                    <li class="menu-label mt-0">C<span>rafted</span></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarPages">
                            <i class="ti ti-file-diff menu-icon"></i>
                            <span>Pages</span>
                        </a>
                        <div class="collapse " id="sidebarPages">
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
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarAuthentication" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAuthentication">
                            <i class="ti ti-shield-lock menu-icon"></i>
                            <span>Authentication</span>
                        </a>
                        <div class="collapse " id="sidebarAuthentication">
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
                        </div><!--end sidebarAuthentication-->
                    </li><!--end nav-item-->

                    
                </ul><!--end navbar-nav--->
            </div><!--end sidebarCollapse-->
        </div>
    </div>    
</div>
<!-- end left-sidenav-->