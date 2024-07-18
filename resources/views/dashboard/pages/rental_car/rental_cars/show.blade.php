@extends('dashboard.layout.index')
@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">عرض سيارة</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">السيارات</a></li>
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
                                                    aria-controls="home" aria-selected="true" href="#aboutme">عن السيارة</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#user-activities" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#user-activities">صور السيارة</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#edit-profile" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#edit-profile">حجوزات السيارة</a></li>

                        </ul>

                        <div class="tab-content m-0 p-4">
                            <div class="tab-pane active" id="aboutme" role="tabpanel"
                                 aria-labelledby="home-tab" tabindex="0">
                                <div class="profile-desk">
                                    <h5 class="text-uppercase fs-17 text-dark">{{ $rental_car->name }}</h5>

                                    <p class="text-muted fs-16">
                                        {{ $rental_car->description }}
                                    </p>

                                    <h5 class="mt-4 fs-17 text-dark">بيانات عن السيارة</h5>
                                    <table class="table table-condensed mb-0 border-top">
                                        <tbody>
                                        <tr>
                                            <th scope="row">الماركة</th>
                                            <td>
                                                {{ $rental_car->rentalCarDepartment->name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">المكان</th>
                                            <td>
                                                {{ $rental_car->location }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">السعر باليوم</th>
                                            <td>
                                                {{ $rental_car->price_per_day .'SAR' }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th scope="row">الصورة</th>
                                            <td>
                                                <img src="{{ $rental_car->main_image }}" alt="table-user"
                                                     class="me-2 rounded-circle" style="width: 70px;height: 70px" />
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

                                            @foreach($rental_car->images ?? [] as $image)
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

                            <!-- profile -->
                            <div id="projects" class="tab-pane">
                                <div class="row m-t-10">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project Name</th>
                                                    <th>Start Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Assign</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Velonic Admin</td>
                                                    <td>01/01/2015</td>
                                                    <td>07/05/2015</td>
                                                    <td><span class="badge bg-info">Work
                                                                                in Progress</span></td>
                                                    <td>Techzaa</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Velonic Frontend</td>
                                                    <td>01/01/2015</td>
                                                    <td>07/05/2015</td>
                                                    <td><span
                                                            class="badge bg-success">Pending</span>
                                                    </td>
                                                    <td>Techzaa</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Velonic Admin</td>
                                                    <td>01/01/2015</td>
                                                    <td>07/05/2015</td>
                                                    <td><span class="badge bg-pink">Done</span>
                                                    </td>
                                                    <td>Techzaa</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Velonic Frontend</td>
                                                    <td>01/01/2015</td>
                                                    <td>07/05/2015</td>
                                                    <td><span class="badge bg-purple">Work
                                                                                in Progress</span></td>
                                                    <td>Techzaa</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Velonic Admin</td>
                                                    <td>01/01/2015</td>
                                                    <td>07/05/2015</td>
                                                    <td><span class="badge bg-warning">Coming
                                                                                soon</span></td>
                                                    <td>Techzaa</td>
                                                </tr>

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
    </div>
@stop

