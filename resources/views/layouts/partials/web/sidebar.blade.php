<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="/">
                <i class="bx bxs-home"></i>
                <span>Home</span>
            </a>
        </li><!-- End Home Nav -->

        <!-- Start HR Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#hr-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people-fill"></i><span>HR</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="hr-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('web.content.circulars.index') }}">
                        <i class="bi bi-circle"></i><span>Circulars</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End HR Nav -->

        <!-- Start Dispensary Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#dispensary-nav" data-bs-toggle="collapse" href="#">
                <i class="bx bx-plus-medical"></i><span>Dispensary</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="dispensary-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>Dispensaries</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Dispensary Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-link-45deg"></i>
                <span>Important Links</span>
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
            <a class="nav-link collapsed" href="{{ route('employee.retired-employees.register') }}">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li><!-- End Register Page Nav -->

    </ul>

</aside><!-- End Sidebar-->