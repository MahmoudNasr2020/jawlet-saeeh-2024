@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">عرض الحجز</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الحجوزات</a></li>
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
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#aboutme" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true" href="#aboutme">تفاصيل الحجز</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#user-activities" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#user-activities">عن السيارة</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#edit-profile" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#edit-profile">حجوزات السيارة</a></li>

                        </ul>

                        <div class="tab-content m-0 p-4">
                            <div class="tab-pane active" id="aboutme" role="tabpanel"
                                 aria-labelledby="home-tab" tabindex="0">
                                <div class="profile-desk">
                                    <h5 class="text-uppercase fs-17 text-dark">{{ $reservation->rentalCar->name }}</h5>

                                    <p class="text-muted fs-16">
                                        {{ $reservation->rentalCar->description }}
                                    </p>

                                    <h5 class="mt-4 fs-17 text-dark">بيانات الحجز</h5>
                                    <table class="table table-condensed mb-0 border-top">
                                        <tbody>
                                        <tr>
                                            <th scope="row">اسم العميل المسجل</th>
                                            <td>
                                                {{ $reservation->user->first_name . ' ' .$reservation->user->last_name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">اسم العميل في الحجز</th>
                                            <td>
                                                {{ $reservation->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ايميل العميل المسجل</th>
                                            <td>
                                                {{ $reservation->user->email }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">ايميل العميل في الحجز</th>
                                            <td>
                                                {{ $reservation->email }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">رقم هاتف العميل المسجل</th>
                                            <td>
                                                {{ $reservation->user->phone }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">رقم هاتف العميل في الحجز</th>
                                            <td>
                                                {{ $reservation->phone_number }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">رقم بطاقة الهوية</th>
                                            <td>
                                                {{ $reservation->identity_number }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th scope="row">رقم الرخصة الدولية</th>
                                            <td>
                                                {{ $reservation->license_number }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">من تاريخ</th>
                                            <td>
                                              {{ $reservation->start_datetime }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">الي تاريخ</th>
                                            <td>
                                               {{ $reservation->start_datetime }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">السعر الاجمالي</th>
                                            <td>
                                                {{ $reservation->total_price .'SAR'}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">المدينة</th>
                                            <td>
                                                {{ $reservation->city->name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">نقطة الانطلاق
                                                <button id="copyLocationLink" class="btn btn-primary" style="margin-right: 6px;">نسخ الرابط</button>
                                            </th>

                                            <td>
                                                <div id="map" data-latitude="{{ $reservation->latitude }}" data-longitude="{{ $reservation->longitude }}" style="height: 400px;"></div>
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
                                            <div class="profile-desk">
                                                <a href="{{ route('dashboard.rental-cars.show',$reservation->rentalCar->id) }}">
                                                    <h5 class="text-uppercase fs-17 text-dark">{{ $reservation->rentalCar->name }}</h5>
                                                </a>

                                                <p class="text-muted fs-16">
                                                    {{ $reservation->rentalCar->description }}
                                                </p>

                                                <h5 class="mt-4 fs-17 text-dark">بيانات عن السيارة</h5>
                                                <table class="table table-condensed mb-0 border-top">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">اسم السيارة</th>
                                                        <td>
                                                            {{ $reservation->rentalCar->name }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">الماركة</th>
                                                        <td>
                                                            {{ $reservation->rentalCar->rentalCarDepartment->name }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">المكان</th>
                                                        <td>
                                                            {{ $reservation->rentalCar->location }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">السعر باليوم</th>
                                                        <td>
                                                            {{ $reservation->rentalCar->price_per_day .'SAR' }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">الصورة</th>
                                                        <td>
                                                            <img src="{{ $reservation->rentalCar->main_image }}" alt="table-user"
                                                                 class="me-2 rounded-circle" style="width: 70px;height: 70px" />
                                                        </td>
                                                    </tr>


                                                    </tbody>
                                                </table>
                                            </div> <!-- end profile-desk -->

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- settings -->
                            <div id="edit-profile" class="tab-pane">
                                <div class="user-profile-content">
                                    <div class="table-responsive">
                                        <h3>الحجوزات الحالية</h3>
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>اسم العميل</th>
                                                <th>الايميل</th>
                                                <th>من تاريخ</th>
                                                <th>الي تاريخ</th>
                                                <th>المكان</th>
                                                <th>عرض الحجز</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($currentReservations as $k => $reservation)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $reservation->user->first_name .' '. $reservation->user->last_name }}</td>
                                                    <td>{{ $reservation->user->email }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d h:i A') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y-m-d h:i A') }}</td>
                                                    <td>{{ $reservation->city->name }}</td>
                                                    <td>
                                                        <a class="dropdown-item" href="{{ route('dashboard.rental-car-reservations-show', $reservation->id) }}">
                                                            <i class="ri-eye-fill" style="color: blue"></i> عرض
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>
                                    <br>
                                    <div class="table-responsive">
                                        <h3>الحجوزات المقبلة</h3>
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>اسم العميل</th>
                                                <th>الايميل</th>
                                                <th>من تاريخ</th>
                                                <th>الي تاريخ</th>
                                                <th>المكان</th>
                                                <th>عرض الحجز</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($upcomingReservations as $k => $reservation)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $reservation->user->first_name .' '. $reservation->user->last_name }}</td>
                                                    <td>{{ $reservation->user->email }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d h:i A') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y-m-d h:i A') }}</td>
                                                    <td>{{ $reservation->city->name }}</td>
                                                    <td>
                                                        <a class="dropdown-item" href="{{ route('dashboard.rental-car-reservations-show', $reservation->id) }}">
                                                            <i class="ri-eye-fill" style="color: blue"></i> عرض
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>
                                    <br>
                                    <div class="table-responsive">
                                        <h3>الحجوزات المنتهية</h3>
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>اسم العميل</th>
                                                <th>الايميل</th>
                                                <th>من تاريخ</th>
                                                <th>الي تاريخ</th>
                                                <th>المكان</th>
                                                <th>عرض الحجز</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pastReservations as $k => $reservation)
                                                <tr>
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $reservation->user->first_name .' '. $reservation->user->last_name }}</td>
                                                    <td>{{ $reservation->user->email }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d h:i A') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y-m-d h:i A') }}</td>
                                                    <td>{{ $reservation->city->name }}</td>
                                                    <td>
                                                        <a class="dropdown-item" href="{{ route('dashboard.rental-car-reservations-show', $reservation->id) }}">
                                                            <i class="ri-eye-fill" style="color: blue"></i> عرض
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                title: 'نقطة الانطلاق'
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
