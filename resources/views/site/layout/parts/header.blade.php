<header class="init">

    <!-- subnav -->
    <div class="container-fluid m-5-hor">
        <div class="row" dir="rtl">
            <div class="subnav">

                <div class="col-md-6">
                    <div class="left">
                        <div class="language-switcher">
                            <a href="#" id="lang-icon" style="margin-left: 15px;font-size: 18px">🌐</a>
                            <div class="language-dropdown">
                                <a href="{{ route('site.change_language','ar') }}">{{ __('web.arabic') }}</a>
                                <a href="{{ route('site.change_language','en') }}">{{ __('web.english') }}</a>
                            </div>
                        </div>
                        <div class="social-icons-subnav hidden-sm hidden-xs" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" style="font-size: 15px;">
                            <div>
                                {{ __('web.contact') }} :
                            </div>
                            {{ settings()->phone }}
                            <!-- أيقونة تغيير اللغة والقائمة -->
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="right">
                        <div id="sub-icon" class="social-icons-subnav" style="border: 0 !important;">
                            <a href="{{ settings()->facebook }}" style="font-size: 15px"><span class="ti-facebook"></span></a>
                            <a href="{{ settings()->youtube }}" style="font-size: 15px"><span class="ti-youtube"></span></a>
                            <a href="{{ settings()->x }}"  style="font-size: 15px"><span class="ti-twitter"></span></a>
                            <a href="{{ settings()->instagram }}" style="font-size: 15px"><span class="ti-instagram"></span></a>
                            <a href="{{ settings()->linkedin }}"  style="font-size: 15px"><span class="ti-linkedin"></span></a>
                            <a href="{{ settings()->snapchat }}" style="font-size: 18px"><span class="fa fa-snapchat"></span></a>
                            <a href="{{ settings()->tiktok }}" style="font-size: 15px"><span class="ti-video-camera"></span></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- subnav end -->

    <!-- nav -->
    <div class="navbar-default-white navbar-fixed-top" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container-fluid m-5-hor">
            <div class="row">

                <!-- menu mobile display -->
                <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse">
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span></button>

                <!-- logo -->
                <a class="navbar-brand white" href="/">
                    <img class="white" alt="logo" src="{{ settings()->logo }}">
                    <img class="black" alt="logo" src="{{ settings()->logo }}">
                </a>
                <!-- logo end -->

                <!-- mainmenu start -->
                <div class="white menu-init" id="main-menu">
                    <nav id="menu-center">
                        <ul>
                            <li>
                                <a class="{{ request()->segment(1) == '' ? 'actived' : '' }}" href="/" style="font-family: 'Cairo' !important;font-size: 17px !important;">{{ __('web.home') }}</a>
                            </li>

                            <li>
                                <a  class="{{ request()->segment(1) == 'about-us' ? 'actived' : '' }}" href="{{ route('site.about') }}" style="font-size: 17px !important;font-family: 'Cairo' !important;">{{ __('web.about') }}</a>
                            </li>

                            <li>
                                <a class="{{ request()->segment(1) == 'services' ? 'actived' : '' }}" href="{{ route('site.services') }}" style="font-family: 'Cairo' !important;font-size: 17px !important;">{{ __('web.service') }}</a>
                            </li>

                            <li>
                                <a class="{{ request()->segment(1) == 'partners' ? 'actived' : '' }}" href="{{ route('site.partner') }}" style="font-family: 'Cairo' !important;font-size: 17px !important;">{{ __('web.partners') }}</a>
                            </li>

                            <li>
                                <a class="{{ request()->segment(1) == 'contact-us' ? 'actived' : '' }}" href="{{ route('site.contact') }}" style="font-family: 'Cairo' !important;font-size: 17px !important;">{{ __('web.contact') }}</a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <!-- mainmenu end -->

            </div>
        </div>
        <!-- container -->
    </div>
    <!-- nav end -->
</header>
