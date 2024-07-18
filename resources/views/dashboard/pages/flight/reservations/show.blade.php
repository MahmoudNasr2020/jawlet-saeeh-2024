@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">عرض الحجز </a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">حجوزات الطيران</a></li>
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
                                    <th scope="row">ايميل العميل</th>
                                    <td>
                                        {{ $reservation->user->email }}
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
                        <h4 class="header-title">بيانات الحجز</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-condensed mb-0 border-top">
                                <tbody>

                                <tr>
                                    <th scope="row">نوع الرحلة</th>
                                    <td>{{ $reservation->type == 'round_trip' ? 'ذهاب وعودة' : 'ذهاب فقط' }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">من مطار</th>
                                    <td>{{ $reservation->fromAirport->name_ar }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">دولة الانطلاق</th>
                                    <td>{{ $reservation->fromAirport->country_name_ar }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">الي مطار</th>
                                    <td>{{ $reservation->toAirport->name_ar }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">دولة الهبوط</th>
                                    <td>{{ $reservation->toAirport->country_name_ar }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">عدد الاشخاص</th>
                                    <td>
                                        {{ $reservation->number_of_persons }}
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">الدرجة</th>
                                    <td>
                                        {{ $reservation->class }}
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
