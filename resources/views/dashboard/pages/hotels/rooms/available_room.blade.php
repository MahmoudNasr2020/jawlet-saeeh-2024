@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الغرف المتاحة</a></li>
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
                    <h4 class="header-title">ابحث عن الغرف المتاحة</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.hotels.rooms.available_rooms') }}">

                        <div class="row">
                            <div class="col-4">
                                <label for="hotel_id" class="mb-1">اختار الفندق</label>
                                <select class="form-control" name="hotel_id" id="hotel_id">
                                    <option>اختار الفندق</option>
                                    @foreach($hotels as $hotel)
                                        <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="start_datetime" class="mb-1">من تاريخ</label>
                                <input type="date" name="start_datetime" class="form-control" id="start_datetime"  value="{{ request('start_datetime') }}"
                                       style="direction: rtl; text-align: right;">
                                @error('start_datetime')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="end_datetime" class="mb-1">الي تاريخ</label>
                                <input type="date" name="end_datetime" class="form-control"  value="{{ request('end_datetime') }}"
                                       id="end_datetime" style="direction: rtl; text-align: right;">
                                @error('end_datetime')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>


                        <button class="btn btn-primary" type="submit" id="button-addon2">بحث</button>
                    </form>

                </div>
            </div>
        </div>

        @if($availableRooms->isNotEmpty())
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">{{ $searchedHotel ? $searchedHotel->name : '' }} - الغرف المتاحة</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-striped table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الفندق</th>
                                    <th>نوع الغرفة</th>
                                    <th>الإجمالي</th>
                                    <th>المحجوز</th>
                                    <th>المتاح</th>
                                    <th>الإجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($availableRooms as $index => $room)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $room->hotel->name }}</td>
                                        <td>{{ $room->type }}</td>
                                        <td>{{ $room->count }}</td>
                                        <td>{{ $room->booked ?? '0' }}</td>
                                        <td>{{ $room->available }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.rooms.edit', ['hotel_id' => $room->hotel_id, 'id' => $room->id]) }}" class="text-primary">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>
        @else
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-center">لا يوجد بيانات لعرضها.</p>
                    </div>
                </div>
            </div>
        @endif



    </div>
@stop

@section('script')

    <script>
        function confirmDelete(url,elementId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف هذه الغرفة!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفها!',
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
                                'تم حذف الغرفة بنجاح.',
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


        // function searchTable() {
        //     // الحصول على القيمة المدخلة في حقل البحث
        //     var input, filter, table, tr, td, i, txtValue;
        //     input = document.getElementById("searchInput");
        //     filter = input.value.toUpperCase(); // تحويل النص إلى حروف كبيرة لتسهيل المقارنة
        //     table = document.querySelector("table"); // الحصول على الجدول
        //     tr = table.getElementsByTagName("tr"); // الحصول على جميع صفوف الجدول
        //
        //     // التكرار عبر جميع الصفوف وإخفاء تلك التي لا تطابق الاستعلام
        //     for (i = 0; i < tr.length; i++) {
        //         td = tr[i].getElementsByTagName("td")[1]; // افتراض أن العمود الثاني يحتوي على اسم الماركة
        //         if (td) {
        //             txtValue = td.textContent || td.innerText;
        //             if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //                 tr[i].style.display = "";
        //             } else {
        //                 tr[i].style.display = "none";
        //             }
        //         }
        //     }
        // }

    </script>
@stop
