<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @php
            $navigation = config('constants.navigation');
        @endphp

        @foreach ($navigation as $sectionName => $section)

            @php
                $links = collect($section['links']);
                $hasFreeItem = $links->contains(fn($l) => empty($l['permission']));
                $permissions = $links->pluck('permission')->filter()->values()->toArray(); // only non-empty
            @endphp

            {{-- Show if: at least 1 blank permission OR user has any of section permissions --}}
            @if($hasFreeItem || auth()->user()->canAny($permissions))
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#{{ Str::slug($sectionName) }}-nav" data-bs-toggle="collapse"
                        href="#">
                        <i class="{{ $section['icon'] }}"></i><span>{{ $sectionName }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>

                    <ul id="{{ Str::slug($sectionName) }}-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                        @foreach ($section['links'] as $link)

                            {{-- Link with blank permission → always show --}}
                            @if(empty($link['permission']) || auth()->user()->can($link['permission']))
                                <li>
                                    <a href="{{ $link['route'] !== '#' ? route($link['route']) : '#' }}">
                                        <i class="{{ $link['icon'] }}"></i><span>{{ $link['label'] }}</span>
                                    </a>
                                </li>
                            @endif

                        @endforeach
                    </ul>
                </li>
            @endif

        @endforeach

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

    </ul>

</aside><!-- End Sidebar-->