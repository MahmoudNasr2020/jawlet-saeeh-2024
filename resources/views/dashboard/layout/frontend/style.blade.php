<meta charset="utf-8" />
<title>{{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }} | لوحة التحكم</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
<meta content="Techzaa" name="author" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- App favicon -->
<link rel="shortcut icon" href="{{ settings()->icon  }}">

<!-- Daterangepicker css -->
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/daterangepicker/daterangepicker.css') }}">

<!-- Vector Map css -->
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">

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
@yield('style')
