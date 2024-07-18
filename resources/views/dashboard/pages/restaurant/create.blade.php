@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">اضافة مطعم</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">المطاعم</a></li>
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
                        <h4 class="header-title">اضافة مطعم جديد</h4>

                        <a class="text-white" href="{{ route('dashboard.restaurants.index') }}">
                            <button class="btn btn-primary text-white"> العودة الي قائمة المطاعم</button></a>
                    </div>
                    {{-- <p class="text-muted mb-0">
                            Use <code>.table-striped</code> to add zebra-striping to any table row
                            within the <code>&lt;tbody&gt;</code>.
                        </p> --}}
                </div>

                <div class="card-body">

                    <div class="table-responsive-sm">
                        <form method="post" action="{{ route('dashboard.restaurants.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">اسم الخدمة</label>
                                <input type="text" id="name" value="{{ old('name') }}" name="name"
                                    value="" class="form-control">
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">سعر الترابيزة في اليوم</label>
                                <input type="number" id="prise" value="{{ old('prise') }}" name="prise"
                                    placeholder="سعر الترابيزة في اليوم" value="{{ old('prise') }}" style="direction: rtl;"
                                    class="form-control">
                                @error('prise')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">رسوم الخدمة</label>
                                <input type="number" id="service_fees" value="{{ old('service_fees') }}"
                                    name="service_fees" style="direction: rtl;" value="" class="form-control">
                                @error('service_fees')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">العنوان</label>
                                <input type="text" id="location" value="{{ old('location') }}" name="location"
                                    value="" class="form-control">
                                @error('location')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="count" class="form-label">خط العرض</label>
                                <input type="text" id="latitude" class="form-control" name="latitude"
                                    placeholder="ادخل خط العرض الخاص بالموقع" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل العدد -->
                            <div class="mb-3">
                                <label for="count" class="form-label">خط الطول</label>
                                <input type="text" id="longitude" class="form-control" name="longitude"
                                    placeholder="ادخل خط العرض الخاص بالموقع" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الوصف</label>
                                <textarea id="desc" name="desc" class="form-control" rows="4">{{ old('name') }}</textarea>
                                @error('desc')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">صورة الخدمة
                                </label>
                                <input type="file" multiple id="example-fileinput" class="form-control" name="image[]">
                                @error('image')
                                    <span style="color: red">{{ $message }}</span> <br>
                                @enderror
                                <br>
                                <img src="" alt="table-user" class="me-2 rounded-circle"
                                    style="width: 100px;height: 100px;display: none" />
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
        $(document).ready(function() {
            $('#example-fileinput').change(function(e) {
                if (e.target.files && e.target.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        // تحديث مصدر الصورة
                        $('img.me-2.rounded-circle').attr('src', e.target.result);
                        $('img.me-2.rounded-circle').css('display', 'block');
                    }

                    // قراءة ملف الصورة كمصدر URL
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        });
    </script>

@stop
