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
                        {{ __('web.abouts')  }} {{  app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }}
                    </h1>
                    <p style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ __('web.my_details') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- subheader end -->


    <section class="dark-page">
        <div class="container-fluid m-5-hor">
            <div class="row">
                <div class="col-md-12 onStep" data-animation="fadeInLeft" data-time="0">
                    <div style="text-align: center; display: flex; align-items: center; justify-content: center;margin-right: 102px;">
                        <img src="{{ asset('images/site/about.png') }}" style="width: 100px; height: 100px; margin-right: 10px;">
                        <h2 style="margin: 0;">{{ __('web.who_about') }}</h2>
                    </div>
                    <span class="sub-heading-content" style="text-align: center;">{{ __('web.about') }}</span>
                    <span class="devider-center"></span>

                    <h5 style="text-align: {{  app()->getLocale() == 'ar' ? 'right' : 'left' }};line-height: normal">

                        {{ app()->getLocale() == 'ar' ? $about->about_us_ar :  $about->about_us_en }}
                    </h5>
                </div>

            </div>

            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12 onStep" data-animation="fadeInLeft" data-time="0">
                    <div style="text-align: center; display: flex; align-items: center; justify-content: center;margin-right: 102px;">
                        <img src="{{ asset('images/site/mission.png') }}" style="width: 66px;
    height: 74px;
    margin-right: 31px;">
                        <h2 style="margin: 0;">{{ __('web.mission') }}</h2>
                    </div>
                    <span class="sub-heading-content" style="text-align: center;">{{ __('web.our_mission') }}</span>
                    <span class="devider-center"></span>

                    <h5 style="text-align: {{  app()->getLocale() == 'ar' ? 'right' : 'left' }};line-height: normal">
                        {{  app()->getLocale() == 'ar' ? $about->mission_ar : $about->mission_en  }}
                    </h5>
                </div>

            </div>


            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12 onStep" data-animation="fadeInLeft" data-time="0">
                    <div style="text-align: center; display: flex; align-items: center; justify-content: center;margin-right: 102px;">
                        <img src="{{ asset('images/site/vision.png') }}" style="width: 66px;
                        height: 74px;
                        margin-right: 31px;">
                        <h2 style="margin: 0;">{{ __('web.vision') }}</h2>
                    </div>
                    <span class="sub-heading-content" style="text-align: center;">{{ __('web.our_vision') }}</span>
                    <span class="devider-center"></span>

                    <h5 style="text-align: {{  app()->getLocale() == 'ar' ? 'right' : 'left' }};line-height: normal">
                        {{app()->getLocale() == 'ar' ? $about->vision_ar : $about->vision_en  }}
                    </h5>
                </div>

            </div>

        </div>
    </section>

    <!--  top rated -->
    <section aria-label="top-rated" dir="{{  app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container-fluid m-5-hor">
            <div class="row">
                <div class="col-md-6 sp-padding ">
                    <img alt="top-rated" class="img-responsive" src="{{ asset('images/site/2.jpg') }}" style="height: 500px; width: 565px;border-radius: 8px;">
                </div>
                <div class="col-md-6 p-30">
                    <h3 class="big-heading" style="font-family: Cairo !important;">
                        {{ __('web.director') }}
                    </h3>

                    <div id="">
                        <h5 style="line-height: normal;">
                            {{ app()->getLocale() == 'ar' ? $about->director_word_ar : $about->director_word_en  }}
                        </h5>
                    </div><br>
                    <a href="{{ route('site.about') }}" class="btn-content">
                        {{ __('web.explore') }}  {{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }}
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--  top rated end -->

@stop
