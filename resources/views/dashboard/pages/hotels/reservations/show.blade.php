@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">

                        <li class="breadcrumb-item"><a href="javascript: void(0);"> {{ $reservation->hotel != ''? $reservation->hotel->name : '' }} </a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">عرض الحجز </a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الحجوزات</a></li>
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
        <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">بيانات العميل</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-condensed mb-0 border-top">
                                <tbody>
                                <tr>
                                    <th scope="row">اسم العميل</th>
                                    <td>
                                        {{ $reservation->user->first_name . ' ' .$reservation->user->last_name }}
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
                                    <th scope="row">رقم هاتف العميل </th>
                                    <td>
                                        {{ $reservation->user->phone }}
                                    </td>
                                </tr>

                                </tbody>
                            </table>

                        </div> <!-- end table-responsive-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">بيانات الفندق</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-condensed mb-0 border-top">
                                <tbody>
                                <tr>
                                    <th scope="row">اسم الفندق</th>
                                    <td>
                                        <a href="{{ route('dashboard.hotels.show',$reservation->hotel->id) }}">
                                            {{ $reservation->hotel->name }}
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">مكان الفندق</th>
                                    <td>
                                        {{ $reservation->hotel->location }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">صورة الفندق</th>
                                    <td>
                                        <img src="{{ $reservation->hotel->main_image }}" alt="table-user"
                                             class="me-2 rounded-circle" style="width: 70px;height: 70px" />
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">عن الفندق</th>
                                    <td style="width: 80%;">
                                       {{ $reservation->hotel->description }}
                                    </td>
                                </tr>


                                </tbody>
                            </table>

                        </div> <!-- end table-responsive-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
    </div>


    <div class="row">
        <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">بيانات الحجز</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-condensed mb-0 border-top">
                                <tbody>

                                <tr>
                                    <th scope="row">الغرف المحجوزة</th>
                                    <td>
                                        {{ $reservation->getRoom()->type }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">عدد الاشخاص البالغين</th>
                                    <td>
                                        {{ $reservation->getPersons()->adults }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">عدد الاطفال</th>
                                    <td>
                                        {{ $reservation->getPersons()->children }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">السعر الاجمالي</th>
                                    <td>
                                        {{ $reservation->total_price . ' SAR'}}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">من تاريخ</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d h:i A') }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">الي تاريخ</th>
                                    <td style="width: 80%;">
                                        {{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y-m-d h:i A') }}
                                    </td>
                                </tr>

                                </tbody>
                            </table>

                        </div> <!-- end table-responsive-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
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
