<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        {{-- Master Navbar --}}
        @canany(['master_departments_read', 'master_core_departments_read', 'master_sub_departments_read'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-files"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('master_core_departments_read')
                        <li>
                            <a href="{{ route('master.core_departments.index') }}">
                                <i class="bi bi-circle"></i><span>Core Departments</span>
                            </a>
                        </li>
                    @endcan
                    @can('master_sub_departments_read')
                        <li>
                            <a href="{{ route('master.sub_departments.index') }}">
                                <i class="bi bi-circle"></i><span>Sub Departments</span>
                            </a>
                        </li>
                    @endcan
                    @can('master_departments_read')
                        <li>
                            <a href="{{ route('master.departments.index') }}">
                                <i class="bi bi-circle"></i><span>Departments</span>
                            </a>
                        </li>
                    @endcan
                    @can('master_consent_category_read')
                        <li>
                            <a href="#">
                                <i class="bi bi-circle"></i><span>Consent Categories</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li><!-- End Admin Nav -->
        @endcanany

        {{-- Admin Navbar --}}
        @canany(['admin_permissions_read', 'admin_roles_read', 'master_employee_import', 'users_read', 'admin_eurja_departments_read'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-bounding-box"></i><span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="admin-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('admin_permissions_read')
                        <li>
                            <a href="{{ route('admin.permissions.index') }}">
                                <i class="bi bi-circle"></i><span>Permission</span>
                            </a>
                        </li>
                    @endcan
                    @can('admin_roles_read')
                        <li>
                            <a href="{{ route('admin.roles.index') }}">
                                <i class="bi bi-circle"></i><span>Roles</span>
                            </a>
                        </li>
                    @endcan
                    @can('admin_eurja_departments_read')
                        <li>
                            <a href="{{ route('admin.eurja_departments.index') }}">
                                <i class="bi bi-circle"></i><span>Eurja Departments</span>
                            </a>
                        </li>
                    @endcan
                    @can('admin_employee_read')
                        <li>
                            <a href="{{ route('admin.employees.index') }}">
                                <i class="bi bi-circle"></i><span>Employees</span>
                            </a>
                        </li>
                    @endcan
                    @can('admin_eurja_employee_read')
                        <li>
                            <a href="{{ route('admin.eurja-employees.index') }}">
                                <i class="bi bi-circle"></i><span>EUrja Employees</span>
                            </a>
                        </li>
                    @endcan
                    @can('master_employee_import')
                        <li>
                            <a href="{{ route('admin.master-employees.import') }}">
                                <i class="bi bi-circle"></i><span>Import Employees</span>
                            </a>
                        </li>
                    @endcan
                    @can('users_read')
                        <li>
                            <a href="{{ route('admin.users.index') }}">
                                <i class="bi bi-circle"></i><span>Users</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li><!-- End Admin Nav -->
        @endcanany

        
        {{-- Location Navbar --}}
        @canany(['app_location_locations_read'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#location-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-building"></i><span>Location</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="location-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('app_location_locations_read')
                        <li>
                            <a href="{{ route('app.location.locations.index') }}">
                                <i class="bi bi-circle"></i><span>Locations</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li><!-- End Location Nav -->
        @endcanany

        {{-- Employee Navbar --}}
        @canany(['master_employee_read', 'master_2d_employee_read', 'master_md_employee_read'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#employee-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person"></i><span>Employee</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('master_employee_read')
                        <li>
                            <a href="{{ route('employee.master-employees.index') }}">
                                <i class="bi bi-circle"></i><span>Master Employees</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('master_2d_employee_read')
                        <li>
                            <a href="{{ route('employee.master-2d-employees.index') }}">
                                <i class="bi bi-circle"></i><span>Master 2D Employees</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('master_md_employee_read')
                        <li>
                            <a href="{{ route('employee.master-md-employees.index') }}">
                                <i class="bi bi-circle"></i><span>Master Employees View</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li><!-- End Admin Nav -->
        @endcanany

        {{-- Content Navbar --}}
        @canany(['app_content_circular_read', 'app_content_circular_manage'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#content-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-file-earmark-text"></i><span>Content</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="content-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('app_content_circular_read')
                        <li>
                            <a href="{{ route('app.content.circulars.index') }}">
                                <i class="bi bi-circle"></i><span>Circulars</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li><!-- End Content Nav -->
        @endcanany

        {{-- Request Navbar --}}
        @canany(['app_request_transfer_read', 'app_request_transfer_manage', 'emp_request_transfer_read', 'emp_request_transfer_manage'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#request-tab" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-stickies"></i><span>Request</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="request-tab" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('app_request_transfer_read')
                        <li>
                            <a href="{{ route('app.request.transfers.index') }}">
                                <i class="bi bi-circle"></i><span>Transfer (Admin)</span>
                            </a>
                        </li>
                    @endcan
                    @can('emp_request_transfer_read')
                        <li>
                            <a href="{{ route('emp.request.transfers.index') }}">
                                <i class="bi bi-circle"></i><span>Transfer</span>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="components-accordion.html">
                            <i class="bi bi-circle"></i><span>Leaving Head Quarter</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-badges.html">
                            <i class="bi bi-circle"></i><span>Training</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Request Nav -->
        @endcanany

        {{-- Employee Navbar --}}
        <!-- @canany(['master_employee_read', 'master_2d_employee_read', 'master_md_employee_read'])
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#employee-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person"></i><span>Employee</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('master_employee_read')
                        <li>
                            <a href="{{ route('employee.master-employees.index') }}">
                                <i class="bi bi-circle"></i><span>Master Employees</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('master_2d_employee_read')
                        <li>
                            <a href="{{ route('employee.master-2d-employees.index') }}">
                                <i class="bi bi-circle"></i><span>Master 2D Employees</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('master_md_employee_read')
                        <li>
                            <a href="{{ route('employee.master-md-employees.index') }}">
                                <i class="bi bi-circle"></i><span>Master Employees View</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="components-alerts.html">
                        <i class="bi bi-circle"></i><span>Alerts</span>
                    </a>

                </li>
                <li>
                    <a href="components-accordion.html">
                        <i class="bi bi-circle"></i><span>Accordion</span>
                    </a>
                </li>
                <li>
                    <a href="components-badges.html">
                        <i class="bi bi-circle"></i><span>Badges</span>
                    </a>
                </li>
                <li>
                    <a href="components-breadcrumbs.html">
                        <i class="bi bi-circle"></i><span>Breadcrumbs</span>
                    </a>
                </li>
                <li>
                    <a href="components-buttons.html">
                        <i class="bi bi-circle"></i><span>Buttons</span>
                    </a>
                </li>
                <li>
                    <a href="components-cards.html">
                        <i class="bi bi-circle"></i><span>Cards</span>
                    </a>
                </li>
                <li>
                    <a href="components-carousel.html">
                        <i class="bi bi-circle"></i><span>Carousel</span>
                    </a>
                </li>
                <li>
                    <a href="components-list-group.html">
                        <i class="bi bi-circle"></i><span>List group</span>
                    </a>
                </li>
                <li>
                    <a href="components-modal.html">
                        <i class="bi bi-circle"></i><span>Modal</span>
                    </a>
                </li>
                <li>
                    <a href="components-tabs.html">
                        <i class="bi bi-circle"></i><span>Tabs</span>
                    </a>
                </li>
                <li>
                    <a href="components-pagination.html">
                        <i class="bi bi-circle"></i><span>Pagination</span>
                    </a>
                </li>
                <li>
                    <a href="components-progress.html">
                        <i class="bi bi-circle"></i><span>Progress</span>
                    </a>
                </li>
                <li>
                    <a href="components-spinners.html">
                        <i class="bi bi-circle"></i><span>Spinners</span>
                    </a>
                </li>
                <li>
                    <a href="components-tooltips.html">
                        <i class="bi bi-circle"></i><span>Tooltips</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="forms-elements.html">
                        <i class="bi bi-circle"></i><span>Form Elements</span>
                    </a>
                </li>
                <li>
                    <a href="forms-layouts.html">
                        <i class="bi bi-circle"></i><span>Form Layouts</span>
                    </a>
                </li>
                <li>
                    <a href="forms-editors.html">
                        <i class="bi bi-circle"></i><span>Form Editors</span>
                    </a>
                </li>
                <li>
                    <a href="forms-validation.html">
                        <i class="bi bi-circle"></i><span>Form Validation</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="tables-general.html">
                        <i class="bi bi-circle"></i><span>General Tables</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html">
                        <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="charts-chartjs.html">
                        <i class="bi bi-circle"></i><span>Chart.js</span>
                    </a>
                </li>
                <li>
                    <a href="charts-apexcharts.html">
                        <i class="bi bi-circle"></i><span>ApexCharts</span>
                    </a>
                </li>
                <li>
                    <a href="charts-echarts.html">
                        <i class="bi bi-circle"></i><span>ECharts</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Charts Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="icons-bootstrap.html">
                        <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-remix.html">
                        <i class="bi bi-circle"></i><span>Remix Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-boxicons.html">
                        <i class="bi bi-circle"></i><span>Boxicons</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Icons Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-register.html">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li><!-- End Login Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-error-404.html">
                <i class="bi bi-dash-circle"></i>
                <span>Error 404</span>
            </a>
        </li><!-- End Error 404 Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Blank</span>
            </a>
        </li><!-- End Blank Page Nav -->

    </ul>

</aside><!-- End Sidebar-->