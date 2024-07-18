@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الكوبونات</a></li>
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
                    <h4 class="header-title">الكوبونات</h4>
                   {{-- <p class="text-muted mb-0">
                        Use <code>.table-striped</code> to add zebra-striping to any table row
                        within the <code>&lt;tbody&gt;</code>.
                    </p>--}}
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 37px;">
                        <div class="search-box">
                            <form action="{{ route('dashboard.hotel-coupons.index') }}" method="get">
                                <div class="input-group ">
                                    <input type="text" class="form-control" name="search" onkeyup="searchTable()" value="{{ request('search') }}" placeholder="ابحث عن كوبون..." id="searchInput" aria-label="ابحث عن ماركة" aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">بحث</button>
                                </div>
                            </form>


                        </div>
                        <button class="btn btn-primary text-white">
                            <a class="text-white" href="{{ route('dashboard.hotel-coupons.create') }}">اضافة كوبون جديد</a>
                        </button>
                    </div>

                    <br>
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الكود</th>
                                <th>النوع</th>
                                <th>نسبة الخصم %</th>
                                <th>اعلي سعر للخصم</th>
                                <th>سعر الخصم</th>
                                <th>تاريخ الانتهاء</th>
                                <th>اقصي حد للاستخدام</th>
                                <th>مرات الاستخدام</th>
                                <th>تاريخ الانشاء</th>
                                <th>الاجراء</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                $currentPage = $coupons->currentPage();
                                $perPage = $coupons->perPage();
                                $currentItem = ($currentPage - 1) * $perPage;
                            @endphp

                            @foreach($coupons as $k=>$coupon)
                                <tr id="row-{{ $coupon->id }}">
                                    <td>{{ $currentItem + $loop->iteration }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->type == 'percentage' ? 'نسبة مئوية' : 'سعر' }}</td>
                                    <td>{{ $coupon->discount_percentage ? $coupon->discount_percentage .'%' : 'غير مسجل' }}</td>
                                    <td>{{ $coupon->maximum_discount ? $coupon->maximum_discount .' SAR' : 'غير مسجل' }}</td>
                                    <td>{{ $coupon->price ? $coupon->price.' SAR' : 'غير مسجل' }}</td>
                                    <td>{{ $coupon->expiry_date != '' ? $coupon->expiry_date : 'مدي الحياة' }}</td>
                                    <td>{{ $coupon->usage_limit }}</td>
                                    <td>{{ $coupon->usage_count }}</td>
                                    <td>{{ $coupon->created_at ? $coupon->created_at->format('Y-m-d') : '' }}</td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           onclick="confirmDelete('{{ route('dashboard.hotel-coupons.destroy',$coupon->id) }}','{{ $coupon->id }}')"
                                           class="text-reset fs-16 px-1 text-danger">
                                            <i class="ri-delete-bin-2-line" style="color: red"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table> <br>
                        {{ $coupons->links() }}
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
                text: "سيتم حذف هذه الكوبون!",
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



    </script>
@stop
