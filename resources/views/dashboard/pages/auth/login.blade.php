<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>جولة سائح | تسجيل الدخول</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <meta content="Techzaa" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/favicon.ico') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('dashboard/assets/js/config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('dashboard/assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('dashboard/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <style>
        body {
            font-family: 'Cairo' !important;

        }
    </style>
</head>

<body class="authentication-bg position-relative">
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-lg-10">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-block p-2">
                            <img src="{{ asset('dashboard/assets/images/auth-img.jpg') }}" alt="" class="img-fluid rounded h-100">
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex flex-column h-100">

                                <div class="p-4 my-auto">
                                    <h4 class="fs-20">تسجيل الدخول</h4>
                                    <p class="text-muted mb-3">ادخل الايميل والباسورد للدخول الي لوحة التحكم
                                    </p>

                                    <!-- form -->
                                    <form action="{{ route('dashboard.login.confirm') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">الايميل</label>
                                            <input class="form-control" type="email" id="emailaddress" style="direction: rtl"
                                                   required="" placeholder="ادخل الايميل" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <a href="auth-forgotpw.html" class="text-muted float-end"><small>نسيت كلمة السر؟</small></a>
                                            <label for="password" class="form-label">كلمة السر</label>
                                            <input class="form-control" type="password" required="" id="password" name="password"
                                                   placeholder="ادخل كلمة السر">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="remember_me"
                                                       id="checkbox-signin">
                                                <label class="form-check-label" for="checkbox-signin">تذكرني</label>
                                            </div>
                                        </div>
                                        <div class="mb-0 text-start">
                                            <button class="btn btn-soft-primary w-100" type="submit"><i
                                                    class="ri-login-circle-fill me-1"></i> <span class="fw-bold">تسجيل الدخول</span> </button>
                                        </div>

                                    </form>
                                    <!-- end form-->
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>

        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt fw-medium">
        <span class="text-dark">
            <script>document.write(new Date().getFullYear())</script> © جولة سائح
        </span>
</footer>
<!-- Vendor js -->
<script src="{{ asset('dashboard/assets/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>

@include('sweetalert::alert')

</body>

</html>
