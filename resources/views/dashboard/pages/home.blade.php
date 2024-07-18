@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">الرئيسية</li>
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


    <!-- end page title -->

    <br>

    <h2 style="text-decoration: underline;">نظرة عامة علي الفنادق</h2>

    <br>

    <div class="row">

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-pink">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-eye-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.hotels.index') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الفنادق</h6>
                    </a>
                    <h2 class="my-2">{{ \App\Models\Hotel::count() }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>

        @php
            $today = \Carbon\Carbon::now();
              $reservations = \App\Models\HotelReservation::select('*', \Illuminate\Support\Facades\DB::raw('DATEDIFF(end_datetime, "' . $today->toDateString() . '") as days_until_end'))
              ->where('status', "1")
              ->where('is_canceled',"0")
              ->whereDate('start_datetime', '<=', $today)
              ->whereDate('end_datetime', '>=', $today)->count();

        @endphp

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-purple">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-wallet-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.hotels-reservations.current_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات الحالية</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>

        @php
            // الحصول على التاريخ الحالي
         $today = \Carbon\Carbon::now();

        $reservations_expected = \App\Models\HotelReservation::where('status', "0")
            ->where('is_canceled',"0")->count();

        @endphp

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-info">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-shopping-basket-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.hotels-reservations.expected_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات المعلقة</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_expected }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div> <!-- end col-->

        @php
            $today = \Carbon\Carbon::now();

       $reservations_upcoming = \App\Models\HotelReservation::with('user', 'hotel')
           ->whereDate('start_datetime', '>', $today)
           ->where('status', "1")
           ->where('is_canceled',"0")->count();
        @endphp
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-primary">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.hotels-reservations.upcoming_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات المقبلة</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_upcoming }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>



        @php
            $today = \Carbon\Carbon::now();

         $reservations_expired = \App\Models\HotelReservation::whereDate('end_datetime', '<', $today)
            ->where('status', "1")
            ->where('is_canceled',"0")->count();
        @endphp
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-secondary">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.hotels-reservations.expired_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات المنتهية</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_expired }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>

        @php
            $today = \Carbon\Carbon::now();

        $reservations_canceled = \App\Models\HotelReservation::where('is_canceled',"1")->count();
        @endphp
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-danger">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.hotels-reservations.canceled_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات الملغية</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_canceled }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    {!! $chartjs->render() !!}
                </div>
            </div>

        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    {!! $chartjs_reservation->render() !!}
                </div>
            </div>

        </div> <!-- end col-->

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {!! $chartjsBar->render() !!}
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->


    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <!-- Chat-->
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="card-widgets">
                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                            <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                        </div>
                        <h5 class="header-title mb-0">الفندق الاخير المسجل</h5>
                    </div>

                    @php
                        $hotel = \App\Models\Hotel::latest()->first();
                    @endphp
                    <div id="yearly-sales-collapse" class="collapse show">
                        <div class="card d-block">
                            <img class="card-img-top" src="{{ $hotel->main_image }}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">{{ $hotel->name }}</h4>
                                <a href="javascript: void(0);" class="btn btn-primary">عرض</a>
                            </div> <!-- end card-body-->
                        </div>
                    </div>
                </div>

            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-8">
            <!-- Todo-->
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="card-widgets">
                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                            <a data-bs-toggle="collapse" href="#yea-sales-collapse" role="button" aria-expanded="false" aria-controls="yea-sales-collapse"><i class="ri-subtract-line"></i></a>
                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                        </div>
                        <h5 class="header-title mb-0">الحجوزات الاخيرة</h5>
                    </div>

                    <div id="yea-sales-collapse" class="collapse show">

                        @php
                            $reservations = \App\Models\HotelReservation::where('is_canceled',"0")->with('user', 'hotel')->limit(10)->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>الايميل</th>
                                    <th>الفندق</th>
                                    <th>صورة الفندق</th>
                                    <th>المكان</th>
                                    <th>من تاريخ</th>
                                    <th>الي تاريخ</th>
                                    <th>السعر الاجمالي</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($reservations as $k=>$reservation)
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $startDatetime = \Carbon\Carbon::parse($reservation->start_datetime);
                                        $endDatetime = \Carbon\Carbon::parse($reservation->end_datetime);
                                        $badgeClass = '';
                                        $statusText = '';

                                        if ($now->lt($startDatetime)) {
                                            // الحجز مقبل
                                            $badgeClass = 'badge bg-info-subtle text-info';
                                            $statusText = 'مقبل';
                                        } elseif ($now->gt($endDatetime)) {
                                            // الحجز منتهي
                                            $badgeClass = 'badge bg-pink-subtle text-pink';
                                            $statusText = 'منتهي';
                                        } else {
                                            // الحجز جاري
                                            $badgeClass = 'badge bg-purple-subtle text-purple';
                                            $statusText = 'جاري';
                                        }
                                    @endphp


                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $reservation->user->first_name . ' ' .$reservation->user->last_name }}</td>
                                        <td>{{ $reservation->user->email }}</td>
                                        <td>{{ $reservation->hotel->name }}</td>

                                        <td><span class="{{ $badgeClass }}">{{ $statusText }}</span></td>

                                        <td>{{ $reservation->hotel->location }}</td>
                                        @php
                                            $daysUntilEnd = \Carbon\Carbon::parse(\Carbon\Carbon::now())->diffInDays($reservation->end_datetime, false);
                                        @endphp
                                        <td style="color: {{ $daysUntilEnd <= 3 ? 'red' : 'green' }};">
                                            {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d h:i A') }}
                                        </td>
                                        <td style="color: {{ $daysUntilEnd <= 3 ? 'red' : 'green' }};">
                                            {{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y-m-d h:i A') }}
                                        </td>

                                        <td>{{ $reservation->total_price . ' SAR ' }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-xl-12">
            <!-- Todo-->
            <div class="card" style="background: #f3f3f8">
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="card-widgets">
                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                            <a data-bs-toggle="collapse" href="#yearl-sales-collapse" role="button" aria-expanded="false" aria-controls="yearl-sales-collapse"><i class="ri-subtract-line"></i></a>
                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                        </div>
                        <h5 class="header-title mb-0">الفنادق الاكثر حجزا</h5><br>
                    </div>

                    <div id="yearl-sales-collapse" class="collapse show">

                        <div class="container">
                            <div class="row">
                                @foreach($mostBookedHotels as $mostBookedHotel)
                                    <div class="col-sm-6 col-lg-4">

                                        <!-- Simple card -->
                                        <div class="card d-block">
                                            <img class="card-img-top"  style="height: 200px" src="{{ $mostBookedHotel->hotel->main_image }}" alt="Card image cap">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $mostBookedHotel->hotel->name }}</h4>
                                                <p class="card-text">مرات الحجز : {{ $mostBookedHotel->total_reservations }}</p>
                                                <a href="{{ route('dashboard.hotels.show',$mostBookedHotel->hotel->id) }}" class="btn btn-primary">عرض الفندق</a>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end card-->
        </div>
    </div>



    <hr>



    <!-- الطيران -->

    <br>

    <h2 style="text-decoration: underline;">نظرة عامة علي حجوزات الطيران</h2>

    <br>

    <div class="row">

        @php
            $today = \Carbon\Carbon::now();
              $reservations = \App\Models\FlightReservation::select('*', \Illuminate\Support\Facades\DB::raw('DATEDIFF(end_datetime, "' . $today->toDateString() . '") as days_until_end'))
              ->where('status', "1")
              ->where('is_canceled',"0")
              ->whereDate('start_datetime', '<=', $today)
              ->whereDate('end_datetime', '>=', $today)->count();

        @endphp

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-purple">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-wallet-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.flight-reservations.current_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات الحالية</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>

        @php
            // الحصول على التاريخ الحالي
         $today = \Carbon\Carbon::now();

        $reservations_expected = \App\Models\FlightReservation::where('status', "0")
            ->where('is_canceled',"0")->count();

        @endphp

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-info">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-shopping-basket-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.flight-reservations.expected_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات المعلقة</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_expected }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div> <!-- end col-->

        @php
            $today = \Carbon\Carbon::now();

       $reservations_upcoming = \App\Models\FlightReservation::with('user', 'hotel')
           ->whereDate('start_datetime', '>', $today)
           ->where('status', "1")
           ->where('is_canceled',"0")->count();
        @endphp
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-primary">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.flight-reservations.upcoming_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات المقبلة</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_upcoming }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>



        @php
            $today = \Carbon\Carbon::now();

         $reservations_expired = \App\Models\FlightReservation::whereDate('end_datetime', '<', $today)
            ->where('status', "1")
            ->where('is_canceled',"0")->count();
        @endphp
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-secondary">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.flight-reservations.expired_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات المنتهية</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_expired }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>

        @php
            $today = \Carbon\Carbon::now();

        $reservations_canceled = \App\Models\FlightReservation::where('is_canceled',"1")->count();
        @endphp
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-danger">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <a href="{{ route('dashboard.flight-reservations.canceled_reservations') }}">
                        <h6 class="text-uppercase mt-0" title="Customers" style="color: white;font-size: 18px">الحجوزات الملغية</h6>
                    </a>
                    <h2 class="my-2">{{ $reservations_canceled }}</h2>
                    <p class="mb-0">
                        <span class="badge bg-white bg-opacity-10 me-1">اطلع الان</span>
                    </p>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! $flightChartjs->render() !!}
                </div>
            </div>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {!! $flightChartjsBar->render() !!}
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->


    </div>
    <!-- end row -->

    <div class="row">

        <div class="col-xl-12">
            <!-- Todo-->
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="card-widgets">
                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                            <a data-bs-toggle="collapse" href="#yea-sales-collapse" role="button" aria-expanded="false" aria-controls="yea-sales-collapse"><i class="ri-subtract-line"></i></a>
                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                        </div>
                        <h5 class="header-title mb-0">الحجوزات الاخيرة</h5>
                    </div>

                    <div id="yea-sales-collapse" class="collapse show">

                        @php
                            $reservations = \App\Models\FlightReservation::where('is_canceled',"0")->with('user', 'fromAirport','toAirport')->limit(10)->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>رقم الهاتف</th>
                                    <th>من مطار</th>
                                    <th>الي مطار</th>
                                    <th>نوع الرحلة</th>
                                    <th>من تاريخ</th>
                                    <th>الي تاريخ</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($reservations as $k=>$reservation)
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $startDatetime = \Carbon\Carbon::parse($reservation->start_datetime);
                                        $endDatetime = \Carbon\Carbon::parse($reservation->end_datetime);
                                        $badgeClass = '';
                                        $statusText = '';

                                        if ($now->lt($startDatetime)) {
                                            // الحجز مقبل
                                            $badgeClass = 'badge bg-info-subtle text-info';
                                            $statusText = 'مقبل';
                                        } elseif ($now->gt($endDatetime)) {
                                            // الحجز منتهي
                                            $badgeClass = 'badge bg-pink-subtle text-pink';
                                            $statusText = 'منتهي';
                                        } else {
                                            // الحجز جاري
                                            $badgeClass = 'badge bg-purple-subtle text-purple';
                                            $statusText = 'جاري';
                                        }
                                    @endphp


                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $reservation->user->first_name . ' ' .$reservation->user->last_name }}</td>
                                        <td>{{ $reservation->user->phone }}</td>
                                        <td>{{ $reservation->fromAirport->name_ar }}</td>
                                        <td>{{ $reservation->toAirport->name_ar }}</td>
                                        <td>{{ $reservation->type == 'round_trip' ? 'ذهاب وعودة' : 'ذهاب فقط' }}</td>
                                        @php
                                            $daysUntilEnd = \Carbon\Carbon::parse(\Carbon\Carbon::now())->diffInDays($reservation->end_datetime, false);
                                        @endphp
                                        <td style="color: {{ $daysUntilEnd <= 3 ? 'red' : 'green' }};">
                                            {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d h:i A') }}
                                        </td>
                                        <td style="color: {{ $daysUntilEnd <= 3 ? 'red' : 'green' }};">
                                            {{ $reservation->end_datetime ? \Carbon\Carbon::parse($reservation->end_datetime)->format('Y-m-d h:i A') : 'غير مسجل' }}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-xl-12">
            <!-- Todo-->
            <div class="card" style="background: #f3f3f8">
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="card-widgets">
                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                            <a data-bs-toggle="collapse" href="#yearl-sales-collapse" role="button" aria-expanded="false" aria-controls="yearl-sales-collapse"><i class="ri-subtract-line"></i></a>
                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                        </div>
                        <h5 class="header-title mb-0">المطارات الاكثر حجزا</h5><br>
                    </div>

                    <div id="yearl-sales-collapse" class="collapse show">

                        <div class="container">
                            <div class="row">
                                @foreach($flightMostBookedAirports as $mostBookedAirport)
                                    <div class="col-sm-6 col-lg-4">

                                        <!-- Simple card -->
                                        <div class="card d-block">
                                            {{--<img class="card-img-top"  style="height: 200px" src="" alt="Card image cap">--}}
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $mostBookedAirport->toAirport->name_ar }}</h4>
                                                <h6 class="card-title">{{ $mostBookedAirport->toAirport->country_name_ar }}</h6>
                                                <p class="card-text">مرات الحجز : {{ $mostBookedAirport->total_reservations }}</p>
                                                {{--<a href="{{ route('dashboard.flight-reservations-show',$mostBookedAirport->id) }}" class="btn btn-primary">عرض الحجز</a>--}}
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end card-->
        </div>
    </div>


@stop

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stop
