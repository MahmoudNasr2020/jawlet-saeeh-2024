@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الحجوزات الحالية</a></li>
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
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">الحجوزات الحالية</h4>
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 37px;">
                        <div class="search-box">
                            <form action="{{ route('dashboard.hotels-reservations.current_reservations') }}" method="get">
                                <div class="input-group ">
                                    <input type="text" class="form-control" name="search" onkeyup="searchTable()"  value="{{ request('search') }}"
                                           placeholder="ابحث عن حجز..." id="searchInput" aria-label="ابحث عن ماركة"
                                           aria-describedby="button-addon2">
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
                                <th>الايميل</th>
                                <th>الفندق</th>
                                <th>صورة الفندق</th>
                                <th>المكان</th>
                                <th>من تاريخ</th>
                                <th>الي تاريخ</th>
                                <th>السعر الاجمالي</th>
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
                                    <td>{{ $reservation->user->email }}</td>
                                    <td>{{ $reservation->hotel->name }}</td>
                                    <td class="table-user">
                                        <img src="{{ $reservation->hotel->main_image }}" alt="table-user" class="me-2 rounded-circle" style="width: 70px;height: 70px" />
                                    </td>
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
                                    <td>
                                        <div class="dropdown">
                                            <i class="ri-list-unordered" type="button" id="dropdownMenuButton"
                                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;"></i>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('dashboard.hotels.show',$reservation->hotel->id) }}">
                                                    <i class="ri-eye-fill" style="color: blue"></i> عرض الفندق
                                                </a>

                                                <a class="dropdown-item" href="{{ route('dashboard.hotels-reservations-show',$reservation->id) }}">
                                                    <i class="ri-eye-fill" style="color: blue"></i> عرض الحجز
                                                </a>


                                              {{--  <a class="dropdown-item" href="#" onclick="activateReservation({{ $reservation->id }})">
                                                    <i class="ri-check-fill" style="color: green"></i> تفعيل الحجز
                                                </a>

                                                <a class="dropdown-item" href="javascript:void(0);" onclick="openConfirmationAlert({{ $reservation->id }})">
                                                    <i class="ri-close-circle-line" style="color: red"></i>الغاء الحجز
                                                </a>--}}

                                                <a class="dropdown-item" href="javascript:void(0);"
                                                   onclick="confirmDelete('{{ route('dashboard.hotels-reservations.destroy',$reservation->id) }}','{{ $reservation->id }}')">
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


      /*  function searchTable() {
            var input, filter, table, tr, tdName, tdBrand, i, txtValueName, txtValueBrand;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase(); // تحويل النص إلى حروف كبيرة لتسهيل المقارنة
            table = document.querySelector("table"); // الحصول على الجدول
            tr = table.getElementsByTagName("tr"); // الحصول على جميع صفوف الجدول

            // التكرار عبر جميع الصفوف وإخفاء تلك التي لا تطابق الاستعلام
            for (i = 0; i < tr.length; i++) {
                tdName = tr[i].getElementsByTagName("td")[1]; // افتراض أن العمود الثاني يحتوي على اسم السيارة
                tdBrand = tr[i].getElementsByTagName("td")[2]; // افتراض أن العمود الثالث يحتوي على اسم الماركة
                if (tdName && tdBrand) {
                    txtValueName = tdName.textContent || tdName.innerText;
                    txtValueBrand = tdBrand.textContent || tdBrand.innerText;
                    if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueBrand.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }*/


    </script>
@stop
