<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    @include('layouts.include-header')
</head>


<body>
    @include('layouts.loading-animation')

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        @include('layouts.nav')
        @include('layouts.header')
        <div class="page-wrapper">

            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link"><i
                                            class="mdi mdi-home-outline fs-4"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb', 'Dashboard')</li>
                            </ol>
                        </nav>
                        <h1 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h1>
                    </div>

                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>



    </div>

    @include('layouts.include-footer')
</body>

</html>
