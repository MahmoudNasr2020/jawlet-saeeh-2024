@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الخدمات</a></li>
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
                    <h4 class="header-title">الخدمات</h4>
                   {{-- <p class="text-muted mb-0">
                        Use <code>.table-striped</code> to add zebra-striping to any table row
                        within the <code>&lt;tbody&gt;</code>.
                    </p>--}}
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 37px;">
                        <div class="search-box">
                            <form action="{{ route('dashboard.services.index') }}" method="get">
                                <div class="input-group ">
                                    <input type="text" class="form-control" name="search" onkeyup="searchTable()" placeholder="ابحث عن خدمة..." id="searchInput" aria-label="ابحث عن ماركة" aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">بحث</button>
                                </div>
                            </form>


                        </div>
                        <button class="btn btn-primary text-white">
                            <a class="text-white" href="{{ route('dashboard.services.create') }}">اضافة خدمة جديدة</a>
                        </button>
                    </div>

                    <br>
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الخدمة بالعربية</th>
                                <th>اسم الخدمة بالانجليزية</th>
                                <th>وصف الخدمة بالعربية</th>
                                <th>وصف الخدمة بالانجليزية</th>
                                <th>الصورة</th>
                                <th>تاريخ الانشاء</th>
                                <th>الاجراء</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                $currentPage = $services->currentPage();
                                $perPage = $services->perPage();
                                $currentItem = ($currentPage - 1) * $perPage;
                            @endphp

                            @foreach($services as $k=>$service)
                                <tr id="row-{{ $service->id }}">
                                    <td>{{ $currentItem + $loop->iteration }}</td>
                                    <td>{{ $service->name_ar }}</td>
                                    <td>{{ $service->name_en }}</td>
                                    <td>{{ $service->text_ar }}</td>
                                    <td>{{ $service->text_en }}</td>
                                    <td class="table-user">
                                        <img src="{{ $service->image }}" alt="table-user"
                                             class="me-2 rounded-circle" style="width: 70px;height: 70px" />
                                    </td>
                                    <td>{{ $service->created_at ? $service->created_at->format('Y-m-d') : '' }}</td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           onclick="confirmDelete('{{ route('dashboard.services.destroy',$service->id) }}','{{ $service->id }}')"
                                           class="text-reset fs-16 px-1 text-danger">
                                            <i class="ri-delete-bin-2-line" style="color: red"></i>
                                        </a>

                                        <a href="{{ route('dashboard.services.edit',$service->id) }}" class="text-reset fs-16 px-1 text-primary">
                                            <i class="ri-settings-3-line" style="color: green"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table> <br>
                        {{ $services->links() }}
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
                text: "سيتم حذف هذه الخدمة!",
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
                                'تم حذف الخدمة.',
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
            // الحصول على القيمة المدخلة في حقل البحث
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase(); // تحويل النص إلى حروف كبيرة لتسهيل المقارنة
            table = document.querySelector("table"); // الحصول على الجدول
            tr = table.getElementsByTagName("tr"); // الحصول على جميع صفوف الجدول

            // التكرار عبر جميع الصفوف وإخفاء تلك التي لا تطابق الاستعلام
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // افتراض أن العمود الثاني يحتوي على اسم الماركة
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>
@stop
