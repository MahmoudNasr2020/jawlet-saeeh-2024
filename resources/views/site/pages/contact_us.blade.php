@extends('site.layout.index')

@section('style')
 <style>
     iframe{
         width:100% !important;
     }
 </style>
@stop
@section('content')

    <!-- subheader -->
    <section id="subheader" style="background-image: url('{{ asset('site/background.png') }}')">
    <div class="container-fluid m-5-hor">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="" style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                        {{ __('web.contact') }}
                    </h1>
                    <p style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ __('web.contact_us') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- subheader end -->

    <!-- map -->
    <section aria-label="map" class="no-bottom">
        <div class="container-fluid m-5-hor">
            <div class="row">
                <div class="onStep" data-animation="fadeIn" data-time="300" id="map-1" style="width: 100%;">
                    {!! settings()->map !!}
                </div>
            </div>
        </div>
    </section>
    <!-- map end -->

    <!-- section contact -->
    <section aria-label="contact" class="whitepage" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container-fluid m-5-hor">
            <div class="row">

                <h2 style="text-align: center">{{ __('web.contact') }}</h2><br>
                <div class="col-md-8">
                    <form id="form-contact1" action="{{ route('site.contact_us') }}" method="post">
                        @csrf
                        <div class="form-group user-name">
                            <input type="text" class="form-control" required="" id="name-contact-1" name="name" placeholder="{{ __('web.name') }}">
                        </div>

                        <div class="form-group user-email">
                            <input type="email" class="form-control" required="" id="email-contact"  name="email" placeholder="{{ __('web.email') }}">
                        </div>

                        <div class="form-group user-message">
                            <textarea class="form-control" required="" id="message-contact" name="message" placeholder="{{ __('web.msg') }}"></textarea>
                            <div class="success" id="mail_success">Thank you. Your message has been sent</div>
                            <div class="error" id="mail_failed">Error, email not sent</div>
                        </div>
                        <button type="submit" id="" class="btn-contact">{{ __('web.send') }}</button>
                    </form>
                </div>

                <!-- address -->
                <div class="col-md-3 col-md-offset-1">
                    <h3 class="heading-cont">{{ __('web.contact_information') }}</h3>
                    <address class="cont-1">
                        <span>{{ app()->getLocale() == 'ar' ? settings()->address_ar : settings()->address_en  }}</span>
                        @if(settings()->phone !='')
                            <span ><strong style="display: ruby !important;">{{ __('web.phone') }}:</strong> {{ settings()->phone }}</span>
                        @endif

                        @if(settings()->phone_2 != '')
                            <span ><strong style="display: ruby !important;">{{ __('web.phone_2') }}:</strong> {{ settings()->phone_2 }}</span>
                        @endif

                        @if(settings()->phone_3 !='')
                            <span><strong style="display: ruby !important;">{{ __('web.phone_3') }}:</strong> {{ settings()->phone_3 }}</span>
                        @endif

                        <span><strong>{{ __('web.email') }}:</strong><a href="mailto:{{ settings()->email }}">{{ settings()->email }}</a></span>
                        <span><strong>{{ __('web.site') }}:</strong><a href="{{ settings()->website }}"> {{ settings()->website }}</a></span>
                    </address>
                </div>
                <!-- address end -->


            </div>
        </div>
    </section>
    <!-- section contact end -->

@stop
