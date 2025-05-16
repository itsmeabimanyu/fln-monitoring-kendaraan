<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">
@include('layouts.header')
<body>
    @include('layouts.preloader')
    <div id="main-wrapper">
        @include('layouts.sidebary')
        <div class="page-wrapper">
            @include('layouts.sidebarx')
            <div class="body-wrapper">
                <div class="container-fluid">
                    @include('layouts.navbar')

                    <div class="card shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                            <h4 class="fw-semibold mb-0">{{ $title }}</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">{{ $title }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    @if(session('success'))
                    <div class="alert customize-alert alert-dismissible text-success rounded-pill alert-light-success bg-success-subtle text-success fade show remove-close-icon" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="d-flex align-items-center  me-3 me-md-0">
                            <i class="ti ti-info-circle fs-5 me-2 text-success"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif
                    

                    @yield('content')
                </div>
            </div>
            @include('layouts.theme')
        </div>
        <div class="dark-transparent sidebartoggler"></div>
    </div>
    @include('layouts.script')
</body>
</html>