<!-- footer -->
<footer class="main text-center">
    <div class="container-fluid m-5-hor">
        <div class="row">

            <div class="onStep" data-animation="fadeInUp" data-time="300">
                <div class="col-md-4 text-left">
                    <span><a href="{{ settings()->email }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            {{ __('web.email') }}: {{ settings()->email }} </a></span>

                    <span>
                        {{ __('web.copyright') }} -
                        {{  app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en  }}
                    </span>
                </div>

                <div class="col-md-4">
                <span class="logo">
                <img style="width: 150px;" alt="logo" src="{{ settings()->logo }}">
                </span>
                </div>

                <div class="col-md-4 text-right">
                    <span>{{ app()->getLocale() == 'ar' ? settings()->address_ar : settings()->address_en  }}</span>
                     @if(settings()->phone != '')
                        <span>{{ __('web.phone') }}:
                        {{ settings()->phone }}
                    </span>
                    @endif

                    @if(settings()->phone_2 != '')
                        <span>{{ __('web.phone_2') }}:
                        {{ settings()->phone_2 }}
                    </span>
                    @endif

                    @if(settings()->phone_3 != '')
                        <span>{{ __('web.phone_3') }}:
                        {{ settings()->phone_3 }}
                    </span>
                    @endif
                </div>
            </div>


        </div>
    </div>
</footer>
<!-- footer end -->
