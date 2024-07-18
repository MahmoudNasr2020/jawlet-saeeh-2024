@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الحجوزات المنتهية</a></li>
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
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">الحجوزات المنتهية</h4>
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 37px;">
                        <div class="search-box">
                            <form action="{{ route('dashboard.flight-reservations.expired_reservations') }}" method="get">
                                <div class="input-group ">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                           onkeyup="searchTable()" placeholder="ابحث عن حجز..."
                                           id="searchInput" aria-label="ابحث عن ماركة" aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">بحث</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <br>
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-centered mb-0">
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
                                <th>الاجراء</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                $currentPage = $reservations->currentPage();
                                $perPage = $reservations->perPage();
                                $currentItem = ($currentPage - 1) * $perPage;
                            @endphp

                            @foreach($reservations as $k=>$reservation)
                                <tr id="row-{{ $reservation->id }}">
                                    <td>{{ $currentItem + $loop->iteration }}</td>
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
                                    <td>
                                        <div class="dropdown">
                                            <i class="ri-list-unordered" type="button" id="dropdownMenuButton"
                                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;"></i>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item" href="{{ route('dashboard.flight-reservations-show',$reservation->id) }}">
                                                    <i class="ri-eye-fill" style="color: blue"></i> عرض الحجز
                                                </a>

                                                <a class="dropdown-item" href="javascript:void(0);"
                                                   onclick="confirmDelete('{{ route('dashboard.flight-reservations.destroy',$reservation->id) }}','{{ $reservation->id }}')">
                                                    <i class="ri-delete-bin-2-line" style="color: red"></i> حذف
                                                </a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table> <br>
                        {{ $reservations->links() }}
                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

    </div>


@stop

@section('script')

    <script>
        function confirmDelete(url,elementId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف هذا الحجز والبيانات التابعة له!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    //window.location.href = url;
                    $.ajax({
                        url:url,
                        data:{'_token':"{{ csrf_token() }}",'_method':"DELETE"},
                        type: 'POST', //
                        success: function(result) {
                            $("#row-" + elementId).remove();
                            Swal.fire(
                                'تم الحذف!',
                                'تم حذف الحجز بنجاح.',
                                'success'
                            );
                        },
                        error: function(err) {
                            // إجراء في حالة الخطأ
                        }
                    });

                }
            })
        }

    </script>
@stop
