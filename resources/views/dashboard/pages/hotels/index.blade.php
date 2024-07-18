@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الفنادق</a></li>
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
                    <h4 class="header-title">الفنادق</h4>
                   {{-- <p class="text-muted mb-0">
                        Use <code>.table-striped</code> to add zebra-striping to any table row
                        within the <code>&lt;tbody&gt;</code>.
                    </p>--}}
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 37px;">
                        <div class="search-box">
                            <form action="{{ route('dashboard.hotels.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" onkeyup="searchTable()" placeholder="ابحث عن فندق..." id="searchInput"
                                           aria-label="ابحث عن ماركة" aria-describedby="button-addon2" value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">بحث</button>
                                </div>
                            </form>

                        </div>
                        <button class="btn btn-primary text-white">
                            <a class="text-white" href="{{ route('dashboard.hotels.create') }}">اضافة فندق جديد</a>
                        </button>
                    </div>

                    <br>
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الفندق</th>
                                <th>الصورة</th>
                                <th>المكان</th>
                                <th>السعر/يوم</th>

                                <th>الاجراء</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                $currentPage = $hotels->currentPage();
                                $perPage = $hotels->perPage();
                                $currentItem = ($currentPage - 1) * $perPage;
                            @endphp

                            @foreach($hotels as $k=>$hotel)
                                <tr id="row-{{ $hotel->id }}">
                                    <td>{{ $currentItem + $loop->iteration }}</td>
                                    <td>{{ $hotel->name }}</td>
                                    <td class="table-user">
                                        <img src="{{ $hotel->main_image }}" alt="table-user"
                                             class="me-2 rounded-circle" style="width: 70px;height: 70px" />
                                    </td>
                                    <td>{{ $hotel->location }}</td>
                                    <td>{{ $hotel->price_per_day . 'SAR' }}</td>

                                    <td>
                                         <div class="dropdown">
                                             <i class="ri-list-unordered" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;"></i>

                                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('dashboard.rooms.index',$hotel->id) }}">
                                                    <i class="ri-hotel-bed-fill" style="color:#c08b30"></i> الغرف
                                                </a>
                                                 <a class="dropdown-item" href="{{ route('dashboard.hotels.multi_images',$hotel->id) }}">
                                                    <i class="ri-image-2-fill" style="color:darkorchid"></i> الصور
                                                </a>
                                                <a class="dropdown-item" href="{{ route('dashboard.hotels.show',$hotel->id) }}">
                                                    <i class="ri-eye-fill" style="color: blue"></i> عرض
                                                </a>
                                                <a class="dropdown-item" href="{{ route('dashboard.hotels.edit',$hotel->id) }}">
                                                    <i class="ri-settings-3-line" style="color: green"></i> تعديل
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);"
                                                   onclick="confirmDelete('{{ route('dashboard.hotels.destroy',$hotel->id) }}','{{ $hotel->id }}')">
                                                    <i class="ri-delete-bin-2-line" style="color: red"></i> حذف
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table> <br>
                        {{ $hotels->links() }}
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
                text: "سيتم حذف هذا الفندق والصور التابعة لها!",
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
                                'تم حذف الفندق وجميع الصور التابعة له.',
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


        function searchTable() {
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
        }


    </script>
@stop
