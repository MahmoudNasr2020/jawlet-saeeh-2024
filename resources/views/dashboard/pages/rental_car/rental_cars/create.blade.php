@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">اضافة سيارة</a></li>
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
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">اضافة سيارة جديدة</h4>
                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>
                <div class="card-body">
                    <a class="text-white" href="{{ route('dashboard.rental-cars.index') }}">
                        <button class="btn btn-primary text-white" style="margin-bottom: 37px;"> العودة الي قائمة السيارات </button>
                    </a>
                    <div class="table-responsive-sm">
                        <form method="post" action="{{ route('dashboard.rental-cars.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- حقل اسم السيارة -->
                            <div class="mb-3">
                                <label for="car_name" class="form-label">اسم السيارة</label>
                                <input type="text" id="car_name" class="form-control" name="name" placeholder="ادخل اسم السيارة">
                                @error('name')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الماركة</label>
                                <select name="rental_car_department_id" class="form-control select2-dropdown">
                                    <option selected disabled value="0">اختار الماركة</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('rental_car_department_id')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- حقل السعر في اليوم -->
                            <div class="mb-3">
                                <label for="price_per_day" class="form-label">السعر في اليوم</label>
                                <input type="number" id="price_per_day" class="form-control" name="price_per_day"
                                       placeholder="ادخل سعر السيارة باليوم" style="direction: rtl;">
                                @error('price_per_day')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل العدد -->
                            <div class="mb-3">
                                <label for="count" class="form-label">المكان</label>
                                <input type="text" id="location" class="form-control" name="location" placeholder="ادخل موقع السيارة">
                                @error('location')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="count" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" placeholder="ادخل الوصف" rows="5"></textarea>
                                @error('description')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">صورة السيارة</label>
                                <input type="file" id="example-fileinput" class="form-control" name="image">
                                @error('image')
                                <span style="color: red">{{ $message }}</span> <br>
                                @enderror
                                <br>
                                <img src="" alt="table-user" class="me-2 rounded-circle" style="width: 100px;height: 100px;display: none" />
                            </div>

                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </form>

                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

    </div>
@stop


@section('script')
    <script>
        $(document).ready(function () {
            $('#example-fileinput').change(function (e) {
                if (e.target.files && e.target.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        // تحديث مصدر الصورة
                        $('img.me-2.rounded-circle').attr('src', e.target.result);
                        $('img.me-2.rounded-circle').css('display','block');
                    }

                    // قراءة ملف الصورة كمصدر URL
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        });
    </script>

@stop
