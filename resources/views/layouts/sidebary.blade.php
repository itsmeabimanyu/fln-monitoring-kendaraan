<!-- Sidebar Start -->
<aside class="left-sidebar with-vertical">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="../dark/index.html" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo-light.svg') }}" class="dark-logo" alt="Logo-Dark" />
            <img src="{{ asset('assets/images/logos/logo-dark.svg') }}" class="light-logo" alt="Logo-light" />
        </a>
        <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
        </a>
    </div>

    <div class="scroll-sidebar" data-simplebar>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-0">
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link primary-hover-bg" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                        <iconify-icon icon="solar:screencast-2-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Master Data</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link primary-hover-bg" href="{{ route('kendaraan.index') }}" aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                        <iconify-icon icon="solar:scooter-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Kendaraan</span>
                    </a>
                </li>
            </ul>
        </nav>
    <!-- End Sidebar navigation -->
    </div>

    <div class=" fixed-profile mx-3 mt-3">
        <div class="card bg-primary-subtle mb-0 shadow-none">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" width="45" height="45" class="img-fluid rounded-circle" alt="" />
                        <div>
                            <h5 class="mb-1">Mike</h5>
                            <p class="mb-0">Admin</p>
                        </div>
                    </div>
                    <a href="../dark/authentication-login.html" class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Logout">
                    <iconify-icon icon="solar:logout-line-duotone" class="fs-8"></iconify-icon>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
</aside>
<!--  Sidebar End -->
