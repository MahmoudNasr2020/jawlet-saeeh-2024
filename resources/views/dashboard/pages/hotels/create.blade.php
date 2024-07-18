@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">اضافة فندق</a></li>
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
                        <h4 class="header-title">اضافة فندق جديدة</h4>

                        <a class="text-white" href="{{ route('dashboard.hotels.index') }}">
                            <button class="btn btn-primary text-white"> العودة الي قائمة الفنادق</button></a>
                    </div>

                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <form method="post" action="{{ route('dashboard.hotels.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- حقل اسم السيارة -->
                            <div class="mb-3">
                                <label for="car_name" class="form-label">اسم الفندق</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="ادخل اسم الفندق" value="{{ old('name') }}">
                                @error('name')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>



                            <!-- حقل السعر في اليوم -->
                            <div class="mb-3">
                                <label for="price_per_day" class="form-label">السعر في اليوم</label>
                                <input type="number" id="price_per_day" class="form-control" name="price_per_day" value="{{ old('price_per_day') }}"
                                       placeholder="ادخل سعر اللية" style="direction: rtl;">
                                @error('price_per_day')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price_per_day" class="form-label">رسوم الخدمة في الفندق</label>
                                <input type="number" id="service_fees" class="form-control" name="service_fees" value="{{ old('service_fees') }}"
                                       placeholder="ادخل رسوم الخدمة في الفندق" style="direction: rtl;">
                                @error('service_fees')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="count" class="form-label">المكان</label>
                                <input type="text" id="location" class="form-control" name="location" placeholder="ادخل موقع الفندق" value="{{ old('location') }}">
                                @error('location')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="count" class="form-label">خط العرض</label>
                                <input type="text" id="latitude" class="form-control" name="latitude" placeholder="ادخل خط العرض الخاص بالموقع" value="{{ old('latitude') }}">
                                @error('latitude')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل العدد -->
                            <div class="mb-3">
                                <label for="count" class="form-label">خط الطول</label>
                                <input type="text" id="longitude" class="form-control" name="longitude" placeholder="ادخل خط العرض الخاص بالموقع" value="{{ old('longitude') }}">
                                @error('longitude')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="count" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" placeholder="ادخل الوصف" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">صورة الفندق</label>
                                <input type="file" id="example-fileinput" class="form-control" name="image">
                                @error('image')
                                <span style="color: red">{{ $message }}</span> <br>
                                @enderror
                                <br>
                                <img src="" alt="table-user" class="me-2 rounded-circle" style="width: 100px;height: 100px;display: none" />
                            </div>


                            <h5>المرافق العامة</h5>
                            <!--begin::Repeater-->
                            <div id="kt_docs_repeater_basic">
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div data-repeater-list="kt_docs_repeater_basic">
                                        @foreach (old('kt_docs_repeater_basic', ['']) as $index => $oldRepeater)
                                            <div data-repeater-item>
                                                <div class="form-group row" dir="rtl" >
                                                    <div class="col-md-3">
                                                        <label class="form-label">الاسم</label>
                                                        <input type="text" name="kt_docs_repeater_basic[{{ $index }}][public_utility_name]" class="form-control mb-2 mb-md-0" placeholder="ادخل الاسم" style="direction: rtl" value="{{ old('kt_docs_repeater_basic.'.$index.'.public_utility_name') }}" />
                                                        @if($errors->has('kt_docs_repeater_basic.'.$index.'.public_utility_name'))
                                                            <span style="color: red">{{ $errors->first('kt_docs_repeater_basic.'.$index.'.public_utility_name') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">الصورة</label>
                                                        <input type="file" id="example-fileinput" class="form-control" name="kt_docs_repeater_basic[{{ $index }}][public_utility_image]">
                                                        @if($errors->has('kt_docs_repeater_basic.'.$index.'.public_utility_image'))
                                                            <span style="color: red">{{ $errors->first('kt_docs_repeater_basic.'.$index.'.public_utility_image') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-danger mt-3 mt-md-8">
                                                            <i class="ki-duotone ki-trash fs-5"></i> حذف
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="" class="me-2 rounded-circle" alt="" style="width: 100px;height: 100px;display: none">
                                                    </div>
                                                </div><br>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!--end::Form group-->

                                <!--begin::Form group-->
                                <div class="form-group mt-5">
                                    <a href="javascript:;" data-repeater-create class="btn btn-success" style="margin-top: -40px !important;margin-bottom: 2rem;">
                                        <i class="ki-duotone ki-plus fs-3"></i> اضافة
                                    </a>
                                </div>
                                <!--end::Form group-->
                            </div>

                            <!--end::Repeater-->

                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </form>

                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

    </div>
@stop


@section('script')
    <script src="{{ asset('dashboard/assets/plugins/formrepeater/formrepeater.bundle.js') }}"></script>

    <script>
        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
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

    <script>
        $(document).ready(function () {
            // إعادة تعيين الاستماع للحدث عند إضافة أو حذف العناصر
            function resetEventListeners() {
                // إزالة الاستماع لأي حدث سابق لتجنب التكرار
                $('input[type="file"]').off('change');

                // إضافة الاستماع لحدث التغيير على كل input[type="file"]
                $('input[type="file"]').on('change', function () {
                    // العثور على عنصر img الأقرب داخل نفس الـ repeater item
                    var imageDisplay = $(this).closest('.form-group.row').find('img');

                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            // عرض الصورة
                            imageDisplay.attr('src', e.target.result);
                            imageDisplay.show(); // عرض عنصر img
                        };
                        reader.readAsDataURL(this.files[0]); // قراءة الصورة كـ Data URL
                    }
                });
            }

            // استدعاء resetEventListeners لأول مرة
            resetEventListeners();

            // استدعاء resetEventListeners كلما تم إنشاء أو حذف عنصر repeater
            $('[data-repeater-create]').on('click', function () {
                // انتظار إضافة العنصر الجديد قبل إعادة تعيين الاستماع للأحداث
                setTimeout(resetEventListeners, 100); // قد تحتاج لضبط التأخير حسب الحاجة
            });

            $(document).on('click', '[data-repeater-delete]', function () {
                // انتظار حذف العنصر قبل إعادة تعيين الاستماع للأحداث
                setTimeout(resetEventListeners, 100); // قد تحتاج لضبط التأخير حسب الحاجة
            });
        });
    </script>


@stop
