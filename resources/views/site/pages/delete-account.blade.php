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
                    <p style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ __('web.delete_account') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- subheader end -->


    <!-- section contact -->
    <section aria-label="contact" class="whitepage" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container-fluid m-5-hor">
            <div class="row">

                <h2 style="text-align: center">{{ __('web.delete_account') }}</h2><br>
                <div class="col-md-12">
                    <form id="form-contact1" action="{{ route('site.delete_account') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('web.email') }}</label>
                            <input type="email" class="form-control" required="" id="email-contact"  name="email" placeholder="{{ __('web.email') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('web.password') }}</label>
                            <input type="password" class="form-control" required="" id="email-contact"  name="password" placeholder="{{ __('web.password') }}">
                        </div>

                        <button type="submit" id="" class="btn-contact">{{ __('web.send') }}</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- section contact end -->

@stop
