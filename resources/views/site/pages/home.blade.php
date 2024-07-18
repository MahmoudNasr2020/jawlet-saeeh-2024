@extends('site.layout.index')

@section('style')
    <style>
        .service-name {
            color: white;
            margin-top: 20px;
        }

        img.rounded-circle {
            width: 150px; /* قطر الصورة */
            height: 150px; /* ارتفاع الصورة */
            object-fit: cover; /* تغطية المساحة بالكامل دون فقدان نسب الأبعاد */
        }

    </style>

    <style>
        .wizard-container {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: white;
        }
        .wizard-sidebar {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            width: 30%;
            border-right: 1px solid #ddd;
        }
        .wizard-sidebar h2 {
            margin-top: 20px;
            color: #0d6efd;
        }
        .wizard-sidebar .step-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        .wizard-sidebar .step-indicator .number {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-bottom: 10px;
        }
        .wizard-sidebar .step-indicator .text {
            color: #333;
        }
        .wizard-sidebar .step-indicator.active .number {
            background-color: #fc9f1c;
            color: white;
        }
        .wizard-form {
            padding: 30px;
            width: 70%;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        .step-btn {
            margin-top: 20px;
        }
    </style>
@stop
@section('content')


    <!-- home -->
    <div id="home">
        <!-- revolution slider -->
        <section class="no-top no-bottom" aria-label="section-slider">
            <div class="fullwidthbanner-container">
                <div id="revolution-slider-half">
                    <ul>
                        @foreach($sliders as $slider)
                            <li data-transition="parallaxtobottom" data-slotamount="10" data-masterspeed="1200" data-delay="5000">
                                <!--  BACKGROUND IMAGE -->
                                <img src="{{ $slider->image }}" alt="" data-start="0" data-bgposition="center center" style=" image-rendering: high-quality;"
                                     data-kenburns="on" data-duration="10000" data-ease="Linear.easeNone" data-bgfit="120"
                                     data-bgfitend="100" data-bgpositionend="center center"/>
                                <div class="tp-caption slide-big-heading sft"
                                     data-x="center"
                                     data-y="300"
                                     data-speed="800"
                                     data-start="400"
                                     data-easing="easeInOutExpo"
                                     data-endspeed="450">
                                    {{ app()->getLocale() == 'ar' ? $slider->text_ar : $slider->text_en  }}
                                </div>

                                <div class="tp-caption sfb"
                                     data-x="center"
                                     data-y="400"
                                     data-speed="400"
                                     data-start="800"
                                     data-easing="easeInOutExpo">
                                    <div class="btn-slider"><span class="shine"></span><a href="{{ route('site.about') }}" >{{ __('web.more_details') }}</a></div>
                                </div>

                            </li>
                        @endforeach

                    </ul>
                    <div class="tp-bannertimer hide"></div>
                </div>
            </div>
        </section>
        <!-- revolution slider end -->

    </div>
    <!-- home end -->

    <!--  milestone -->
    <section aria-label="milestone" class="no-top no-bottom color-page hidden-sm hidden-xs">
        <div class="container-fluid m-5-hor">
            <div class="row">

                <div class="col-md-3 onStep" data-animation="fadeInUp" data-time="0">
                    <div class="box-icon">
                        <span class="icon-choose fa fa-plane"></span>
                        <div class="text">
                            <h3><span>{{ __('web.destination') }}</span></h3>
                            <!--<p>Sed ut perspiciatis</p>-->
                        </div>
                    </div>
                </div>

                <div class="col-md-3 onStep" data-animation="fadeInUp" data-time="150">
                    <div class="box-icon">
                        <span class="icon-choose fa fa-credit-card"></span>
                        <div class="text">
                            <h3><span>{{ __('web.prices') }}</span></h3>
                            <!-- <p>Sit voluptatem accusantium</p> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-3 onStep" data-animation="fadeInUp" data-time="300">
                    <div class="box-icon">
                        <span class="icon-choose fa fa-address-book"></span>
                        <div class="text">
                            <h3><span>{{ __('web.customers') }}</span></h3>
                            <!-- <p>perspiciatis unde omnis</p> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-3 onStep" data-animation="fadeInUp" data-time="450">
                    <div class="box-icon">
                        <span class="icon-choose fa fa-handshake-o"></span>
                        <div class="text">
                            <h3><span>{{ __('web.trust') }}</span></h3>
                            <!-- <p>Accusantium natus</p> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- milestone end -->
    <!---->
    <!-- section search -->
    <section class="frm-search" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" style="background-image: url('{{ asset('site/background.png') }}')">
        <div class="container-fluid m-5-hor m-5-hor-dev">
            <div class="row">
                <h2 class="" style="margin-top: 0"> {{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en  }}
                    {{ __('web.trip') }}
                </h2><br>
                <h5 style="line-height: normal;">
                    {{ app()->getLocale() == 'ar' ? $about->introduction_ar :   $about->introduction_en }}
                </h5>

            </div>
        </div>
    </section>
    <!-- section search end -->


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




    <!-- section features -->
    <section class="whitepage no-bottom no-top no-padding frm-search" dir="rtl" style="background-image: url('{{ asset('site/1.jpg') }}')">

        <div class="container container-fluid mt-5" style="padding: 50px">
            <div class="row">
                <!-- يتم إزالة الـ div الخاص بـ no-gutter لأنه لم يتم استخدامه بشكل صحيح -->
                @foreach($services as $service)
                    <!-- خدمة 1 -->
                    <div class="col-md-4 text-center" style="margin-top: 50px;">
                        <img src="{{ asset($service->image) }}" class="rounded-circle mb-3" alt="" style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                        <h5 class="service-name">{{ app()->getLocale() == 'ar' ? $service->name_ar :  $service->name_en }}</h5>
                    </div>
                @endforeach
            </div>
            <!-- تمديد الـ div ليشمل الزر وتحديد نمط العرض ليكون في المنتصف -->
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="{{ route('site.services') }}" class="btn-content">{{ __('web.explore_service') }}</a>
                </div>
            </div>
        </div>


    </section>
    <!-- section features end -->

    <!-- testimony -->
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
                      
                       @if(settings()->website !='')
                           
                      		<span><strong>{{ __('web.site') }}:</strong><a href="{{ settings()->website }}"> {{ settings()->website }}</a></span>
                        @endif
                      
                      
                    </address>
                </div>
                <!-- address end -->


            </div>
        </div>
    </section>
    <!-- section contact end -->
    <!-- testimony end -->


    <!-- section features -->
    <section class="whitepage no-bottom no-top no-padding frm-search" dir="rtl">

        <div class="container container-fluid mt-5" style="padding: 50px">
            <div style="text-align: center;">
                <h2 style="font-weight: bold; border-bottom: 2px solid white; padding-bottom: 10px; display: inline-block;">{{ __('web.our_partners') }}</h2>
            </div><br>
            <div class="row">
                <!-- يتم إزالة الـ div الخاص بـ no-gutter لأنه لم يتم استخدامه بشكل صحيح -->
                @foreach($partners as $partner)
                    <!-- خدمة 1 -->
                    <div class="col-md-4 text-center" >
                        <img src="{{ asset($partner->image) }}" class="rounded-circle mb-3" alt="" style="object-fit: fill !important;border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                        <h5 class="service-name">{{ $partner->name }}</h5>
                    </div>
                @endforeach
            </div>
            <!-- تمديد الـ div ليشمل الزر وتحديد نمط العرض ليكون في المنتصف -->
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="#" class="btn-content">{{ __('web.explore_partners') }}</a>
                </div>
            </div>
        </div>


    </section>
    <!-- section features end -->

    <!--  top rated -->
    <section aria-label="top-rated" dir="{{  app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container mt-5">
            <div class="row">
                <h2 style="color: #fc9f1c;text-align: center">{{ __('web.new_partner') }}</h2><br>
                <div class="wizard-container">
                    <div class="wizard-sidebar">
                        <div class="step-indicator active" data-step="1">
                            <div class="number">1</div>
                            <div class="text">{{ __('web.basic_information') }}</div>
                        </div>
                        <div class="step-indicator" data-step="2">
                            <div class="number">2</div>
                            <div class="text">{{ __('web.company_information') }}</div>
                        </div>
                        <div class="step-indicator" data-step="3">
                            <div class="number">3</div>
                            <div class="text">{{ __('web.company_documents') }}</div>
                        </div>
                    </div>
                    <div class="wizard-form">
                        <form id="restaurantForm" action="{{ route('restaurantsRegistration.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Step 1: البيانات الأساسية -->
                            <div class="step active" data-step="1">
                                <div class="form-group">
                                    <label>{{ __('web.store_name_ar') }} <span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="store_name_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.store_name_en') }}<span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="store_name_en" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.type') }}</label>
                                    <select class="form-control">
                                        <option>{{ __('web.restaurant') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.branch_count') }}<span style="color: red"> *</span></label>
                                    <input type="number" class="form-control" name="branch_count" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.twitter_link') }}:</label>
                                    <input type="url" class="form-control" name="twitter_link">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.facebook_link') }}:</label>
                                    <input type="url" class="form-control" name="facebook_link">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.google_maps_link') }}:</label>
                                    <input type="url" class="form-control" name="google_maps_link">
                                </div>
                                <button type="button" class="btn btn-content step-btn" onclick="nextStep()">{{ __('web.next') }}</button>
                            </div>

                            <!-- Step 2: معلومات الشركة -->
                            <div class="step" data-step="2">
                                <div class="form-group">
                                    <label>{{ __('web.company_name_en') }}<span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="company_name_en" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.email') }}<span style="color: red"> *</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.bank_name') }}<span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="bank_name" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.iban') }}<span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="iban" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.manager_phone') }}<span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="manager_phone" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.operation_manager_phone') }}<span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="operation_manager_phone" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.marketing_phone') }}<span style="color: red"> *</span></label>
                                    <input type="text" class="form-control" name="marketing_phone" required>
                                </div>
                                <button type="button" class="btn btn-secondary step-btn" onclick="prevStep()">{{ __('web.previous') }}</button>
                                <button type="button" class="btn btn-content step-btn" onclick="nextStep()">{{ __('web.next') }}</button>
                            </div>

                            <!-- Step 3: أوراق الشركة -->
                            <div class="step" data-step="3">
                                <div class="form-group">
                                    <label>{{ __('web.commercial_registration') }}<span style="color: red"> *</span></label>
                                    <input type="file" class="form-control" name="commercial_registration" style="padding-top: 4px;" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.tax_certificate') }}<span style="color: red"> *</span></label>
                                    <input type="file" class="form-control" name="tax_certificate" style="padding-top: 4px;" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.bank_account') }}<span style="color: red"> *</span></label>
                                    <input type="file" class="form-control" name="bank_account" style="padding-top: 4px;" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('web.national_address') }}<span style="color: red"> *</span></label>
                                    <input type="file" class="form-control" name="national_address" style="padding-top: 4px;" required>
                                </div>
                                <button type="button" class="btn btn-secondary step-btn" onclick="prevStep()">{{ __('web.previous') }}</button>
                                <button type="submit" class="btn btn-success step-btn">{{ __('web.register') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  top rated end -->
@stop

@section('script')
    <script>
        let currentStep = 1;

        function showStep(step) {
            currentStep = step;
            const steps = document.querySelectorAll('.step');
            const indicators = document.querySelectorAll('.step-indicator');

            steps.forEach((stepElement, index) => {
                if (index + 1 === step) {
                    stepElement.classList.add('active');
                    indicators[index].classList.add('active');
                } else {
                    stepElement.classList.remove('active');
                    indicators[index].classList.remove('active');
                }
            });
        }

        function nextStep() {
            if (currentStep < 3) {
                showStep(currentStep + 1);
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        }

        @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'حدثت أخطاء في الإدخال',
            html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
        });
        @endif
    </script>
@stop
