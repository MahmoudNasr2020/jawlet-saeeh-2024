@extends('dashboard.layout.index')



@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">اضافة كوبون</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.hotel-coupons.index') }}">الكوبونات</a></li>
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
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title">اضافة كوبون جديد</h4>

                        <a class="text-white" href="{{ route('dashboard.hotel-coupons.index') }}">
                            <button class="btn btn-primary text-white"> العودة الي قائمة الكوبونات</button></a>
                    </div>
                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>

                <div class="card-body">

                     <div class="container">
                         <form method="post" action="{{ route('dashboard.hotel-coupons.store') }}" enctype="multipart/form-data">
                             @csrf
                             <div class="mb-3">
                                 <label for="quantity" class="form-label">عدد الكوبونات</label>
                                 <input type="number" id="quantity" name="quantity" class="form-control" style="direction: rtl" required>
                                 @error('quantity')
                                 <span style="color: red">{{ $message }}</span>
                                 @enderror
                             </div>

                             <div class="mb-3">
                                 <label for="couponType" class="form-label">نوع الكوبون</label>
                                 <select id="couponType" name="type" class="form-control" onchange="toggleFields();" required>
                                     <option value="">اختر نوع الكوبون</option>
                                     <option value="percentage">نسبة مئوية</option>
                                     <option value="price">سعر</option>
                                 </select>
                                 @error('type')
                                 <span style="color: red">{{ $message }}</span>
                                 @enderror
                             </div>

                             <div class="mb-3" id="percentageFields" style="display: none;">
                                 <label for="discountPercentage" class="form-label">النسبة المئوية للخصم %</label>
                                 <input type="number" id="discountPercentage" style="direction: rtl" name="discount_percentage" class="form-control">
                                 @error('discount_percentage')
                                 <span style="color: red">{{ $message }}</span>
                                 @enderror
                                 <br>
                                 <label for="maxDiscount" class="form-label">أعلى سعر للتطبيق</label>
                                 <input type="number" id="maxDiscount" style="direction: rtl" name="maximum_discount" class="form-control">
                                 @error('maximum_discount')
                                 <span style="color: red">{{ $message }}</span>
                                 @enderror
                             </div>

                             <div class="mb-3" id="priceField" style="display: none;">
                                 <label for="price" class="form-label">سعر الكوبون</label>
                                 <input type="number" id="price" name="price" style="direction: rtl" class="form-control">
                                 @error('price')
                                 <span style="color: red">{{ $message }}</span>
                                 @enderror
                             </div>

                             <div class="mb-3">
                                 <label for="expiryDate" class="form-label">تاريخ الانتهاء</label>
                                 <input type="date" id="expiryDate" name="expiry_date" style="direction: rtl" class="form-control">
                                 @error('expiry_date')
                                 <span style="color: red">{{ $message }}</span>
                                 @enderror
                             </div>

                             <div class="mb-3">
                                 <label for="usageCount" class="form-label">عدد مرات الاستخدام</label>
                                 <input type="number" id="usageCount" name="usage_limit" class="form-control" value="1" style="direction: rtl">
                                 @error('usage_limit')
                                 <span style="color: red">{{ $message }}</span>
                                 @enderror
                             </div>

                             <button type="submit" class="btn btn-primary">إضافة</button>
                         </form>

                     </div>

                    <script>
                        function toggleFields() {
                            const couponType = document.getElementById('couponType').value;
                            document.getElementById('percentageFields').style.display = couponType === 'percentage' ? 'block' : 'none';
                            document.getElementById('priceField').style.display = couponType === 'price' ? 'block' : 'none';
                        }
                    </script>

                </div>
            </div>
        </div>

    </div>
@stop


