@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">المطاعم</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">استمارات تسجيل المطاعم</li>
                    </ol>
                </div>
                <h4 class="page-title">استمارات تسجيل المطاعم</h4>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">استمارات تسجيل المطاعم</h4>
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 37px;">
                        <div class="search-box">
                            <form action="{{ route('dashboard.restaurant-registrations.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="ابحث عن استمارة..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">بحث</button>
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
                                <th>اسم المتجر (عربي)</th>
                                <th>اسم المتجر (إنجليزي)</th>
                                <th>عدد الفروع</th>
                                <th>الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($registrations as $registration)
                                <tr id="row-{{ $registration->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $registration->store_name_ar }}</td>
                                    <td>{{ $registration->store_name_en }}</td>
                                    <td>{{ $registration->branch_count }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('dashboard.restaurant-registrations.show', $registration->id) }}">عرض</a>
                                        <button class="btn btn-danger" onclick="confirmDelete('{{ route('dashboard.restaurant-registrations.destroy', $registration->id) }}', '{{ $registration->id }}')">حذف</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $registrations->links() }}
                    </div> <!-- end table-responsive-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
@stop

@section('script')
    <script>
        function confirmDelete(url, elementId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف هذه الاستمارة!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفها!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            '_method': 'DELETE'
                        },
                        success: function(result) {
                            $("#row-" + elementId).remove();
                            Swal.fire('تم الحذف!', 'تم حذف الاستمارة بنجاح.', 'success');
                        },
                        error: function(err) {
                            Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف.', 'error');
                        }
                    });
                }
            })
        }
    </script>
@stop
