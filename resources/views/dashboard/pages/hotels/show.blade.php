@extends('dashboard.layout.index')
@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $hotel->name }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">عرض فندق</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.hotels.index') }}">الفنادق</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">اهلا بك</li>
                    </ol>
                </div>
                <h4 class="page-title">اهلا بك !</h4>
            </div>
        </div>
    </div>
@stop
@section('content')
    <br>
    <div class="row">
        <div class="col-sm-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <div class="profile-content">
                        <ul class="nav nav-underline nav-justified gap-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#aboutme" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true" href="#aboutme">عن الفندق</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#user-activities" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#user-activities">صور الفندق</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#edit-profile" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#edit-profile">المرافق العامة</a>
                            </li>

                        </ul>

                        <div class="tab-content m-0 p-4">
                            <div class="tab-pane active" id="aboutme" role="tabpanel"
                                 aria-labelledby="home-tab" tabindex="0">
                                <div class="profile-desk">
                                    <h5 class="text-uppercase fs-17 text-dark">{{ $hotel->name }}</h5>

                                    <p class="text-muted fs-16">
                                        {{ $hotel->description }}
                                    </p>

                                    <h5 class="mt-4 fs-17 text-dark">بيانات عن الفندق</h5>
                                    <table class="table table-condensed mb-0 border-top">
                                        <tbody>
                                        <tr>
                                            <th scope="row">المكان</th>
                                            <td>
                                                {{ $hotel->location }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">السعر باليوم</th>
                                            <td>
                                                {{ $hotel->price_per_day .' SAR' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">رسوم الخدمة</th>
                                            <td>
                                                {{ $hotel->service_fees .' SAR' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">الصورة</th>
                                            <td>
                                                <img src="{{ $hotel->main_image }}" alt="table-user"
                                                     class="me-2 rounded-circle" style="width: 70px;height: 70px" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">اللوكيشن
                                                <button id="copyLocationLink" class="btn btn-primary" style="margin-right: 6px;">نسخ الرابط</button>
                                            </th>

                                            <td style="width: 56%;">
                                                <div id="map" data-latitude="{{ $hotel->latitude }}" data-longitude="{{ $hotel->longitude }}" style="height: 400px;"></div>
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div> <!-- end profile-desk -->
                            </div> <!-- about-me -->

                            <!-- Activities -->
                            <div id="user-activities" class="tab-pane">
                                <div class="timeline-2">

                                    <div class="container py-4">
                                        <div class="row">

                                            @foreach($hotel->images ?? [] as $image)
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <img src="{{ $image }}" style="height: 273px;" class="card-img-top" alt="Image Description">
                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- settings -->
                            <div id="edit-profile" class="tab-pane">
                                <div class="user-profile-content">
                                    <div class="table-responsive">
                                        <h3>المرافق العامة</h3>
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">الاسم</th>
                                                <th style="text-align: center;">الصورة</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($hotel->public_utility ))
                                                @foreach($hotel->public_utility as $k => $public_utility)
                                                    <tr>
                                                        <td style="text-align: center;">{{ $k + 1 }}</td>
                                                        <td style="text-align: center;">{{ $public_utility['name']}}</td>
                                                        <td style="text-align: center;">
                                                            <img src="{{ $public_utility['image'] }}" alt="table-user"
                                                                 class="me-2 rounded-circle" style="width: 70px;height: 70px" />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4WP9_0hhqNI1dDnJyfaHcUKyR1HHy_2I&callback=initMap">
    </script>
    <script>

        var latitude = parseFloat($("#map").data("latitude"));
        var longitude = parseFloat($("#map").data("longitude"));

        console.log(latitude);
        function initMap() {
            var myLatLng = {lat: latitude, lng: longitude};

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'المكان'
            });
        }

        $(document).ready(function(){
            initMap();

            $('#copyLocationLink').click(function() {
                var link = `https://www.google.com/maps?q=${latitude},${longitude}`;
                navigator.clipboard.writeText(link).then(function() {
                    alert('رابط الموقع نُسخ إلى الحافظة بنجاح!');
                    // يمكنك استبدال هذا الإشعار برسالة تأكيد أكثر تقدمًا حسب التصميم الخاص بك
                }, function(err) {
                    console.error('حدث خطأ أثناء نسخ الرابط: ', err);
                    // يمكنك هنا عرض رسالة خطأ للمستخدم، إذا أردت
                });
            });
        });
    </script>
@stop
