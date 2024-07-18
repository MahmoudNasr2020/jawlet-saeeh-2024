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
                        {{ __('web.services')  }}
                    </h1>
                    <p style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ __('web.my_services') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- subheader end -->

    <section aria-label="top-rated" dir="{{  app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container-fluid m-5-hor">
            <div style="text-align: center;">
                <h2 style="font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 10px; display: inline-block;">  {{ __('web.services')  }}</h2>
            </div>
            <br>

        @foreach($services as $k=>$service)
                <div class="row">
                    <div class="col-md-6 sp-padding" style="float: {{  app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                        <img alt="top-rated" class="img-responsive" src="{{ $service->image }}" style="height: 250px;width: 100%;border-radius: 10px">
                    </div>
                    <div class="col-md-6 p-30">
                        <h3 class="big-heading" style="font-family: Cairo !important;">
                            {{ $k+1 }} - {{ app()->getLocale() == 'ar' ? $service->name_ar : $service->name_en }}
                        </h3>

                        <div id="">
                            <h5 style="line-height: normal;">
                                {{ app()->getLocale() == 'ar' ? $service->text_ar  : $service->text_en }}
                            </h5><br>
                            <a href="#" class="btn-content">
                                {{ __('web.booking') }}
                            </a>
                        </div>
                    </div>

                </div><hr><br>
            @endforeach

        </div>
    </section>

@stop
