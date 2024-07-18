<!DOCTYPE html>
<html lang="en">

<head>
    @include('dashboard.layout.frontend.style')
</head>

<body>
<!-- Begin page -->
<div class="wrapper">


    <!-- ========== Topbar Start ========== -->
    @include('dashboard.layout.parts.header')

    <!-- ========== Topbar End ========== -->


    <!-- ========== Left Sidebar Start ========== -->
    @include('dashboard.layout.parts.sidebar')
    <!-- ========== Left Sidebar End ========== -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                @yield('header')

                <!-- end page title -->
                @yield('content')
            </div>
            <!-- container -->

        </div>
        <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <script>document.write(new Date().getFullYear())</script> © جولة سائح</b>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Theme Settings -->
@include('dashboard.layout.parts.settings')


@include('dashboard.layout.frontend.script')

</body>
</html>
