<!DOCTYPE html>
<html lang="zxx">
<head>
    @include('site.layout.frontend.style')
</head>

<body>

<!-- preloader -->
<div class="bg-preloader-white"></div>
<div class="preloader-white">
    <div class="mainpreloader">
        <span></span>
    </div>
</div>
<!-- preloader end -->

<!-- content wraper -->
<div class="content-wrapper">

   @include('site.layout.parts.header')

    @yield('content')


    @include('site.layout.parts.footer')



    <!-- ScrolltoTop -->
    <div id="totop" class="init">
        <span class="ti-angle-up"></span>
    </div>

    <!-- modal login -->
    <div id="fLogin" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Member Log In</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block btn-lg" value="Log In">
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <a href="#">or Sign Up</a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal login end -->

    <!-- modal registration -->
    <div id="fsignUp" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Member Registration</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="terms"> I agree with the <a href="#">Terms and Conditions</a>.</label>
                        </div>
                        <div class="form-group"><input type="submit" value="Sign up" class="btn btn-primary btn-block btn-lg"></div>
                        <div class="clearfix"></div>
                    </form>

                </div>
                <div class="modal-footer">
                    <a href="#">or Log In</a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal registration end -->


</div>
<!-- content wraper end -->

@include('site.layout.frontend.script')
</body>
</html>
