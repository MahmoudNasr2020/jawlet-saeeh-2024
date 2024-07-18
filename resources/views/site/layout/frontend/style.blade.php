<meta charset="utf-8">
<title>{{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }}</title>
<meta content="" name="description">
<meta content="" name="author">
<meta content="" name="keywords">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
<!-- favicon -->
<link href="{{ settings()->icon }}" rel="icon" sizes="32x32" type="image/png">
<!-- Bootstrap CSS -->
<link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- font themify CSS -->
<link rel="stylesheet" href="{{ asset('site/css/themify-icons.css') }}">
<!-- font awesome CSS -->
<link href="{{ asset('site/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<!-- date picker CSS -->
<link href="{{ asset('site/css/datepicker.min.css') }}" rel="stylesheet">
<!-- revolution slider css -->
<link rel="stylesheet" type="text/css" href="{{ asset('site/css/fullwidth.css') }}" media="screen" />
<link rel="stylesheet" type="text/css" href="{{ asset('site/rs-plugin/css/settings.css') }}" media="screen" />
<link rel="stylesheet" href="{{ asset('site/css/rev-settings.css') }}" type="text/css">
<!-- on3step CSS -->
<link href="{{ asset('site/css/animated-on3step.css') }}" rel="stylesheet">
<link href="{{ asset('site/css/owl.carousel.css') }}" rel="stylesheet">
<link href="{{ asset('site/css/owl.theme.css') }}" rel="stylesheet">
<link href="{{ asset('site/css/on3step-style.css') }}" rel="stylesheet">
<link href="{{ asset('site/css/queries-on3step.css') }}" media="all" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
<style>
    body {
        font-family: 'Cairo' !important;

    }

    .language-switcher {
        position: relative;
        display: inline-block;
    }

    .language-dropdown {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
      /*  min-width: 160px;*/
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 99999;
    }

    .language-dropdown a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .language-dropdown a:hover {background-color: #f1f1f1}

</style>

@yield('style')
