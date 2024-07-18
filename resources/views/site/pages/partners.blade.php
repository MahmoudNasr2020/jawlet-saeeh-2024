@extends('site.layout.index')

@section('style')

@stop
@section('content')

    <!-- subheader -->
    <section id="subheader" style="background-image: url('{{ asset('site/background.png') }}')">
        <div class="container-fluid m-5-hor">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="" style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                        {{ __('web.partner') }}
                    </h1>
                    <p style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ __('web.my_partners') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- subheader end -->

    <!-- section features -->
    <section aria-label="contact" class="whitepage" dir="rtl">

        <div class="container container-fluid mt-5" style="padding: 50px">
            <div style="text-align: center;">
                <h2 style="font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 10px; display: inline-block;">
                    {{ __('web.partner') }}</h2>
            </div><br><br>
            <div class="row">
                <!-- يتم إزالة الـ div الخاص بـ no-gutter لأنه لم يتم استخدامه بشكل صحيح -->
                @foreach($partners as $partner)
                    <!-- خدمة 1 -->
                    <div class="col-md-4 text-center" style="float: right">
                        <img src="{{ asset($partner->image) }}" class="rounded-circle mb-3" alt="" style="object-fit: fill !important;border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                        <h4 class="service-name">{{ $partner->name }}</h4>
                    </div>
                @endforeach
            </div>

        </div>


    </section>
    <!-- section features end -->

@stop
