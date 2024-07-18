@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">عن جوله سائح</a></li>
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
                        <h4 class="header-title">الاعدادات</h4>
                    </div>
                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>
                <div class="card-body">

                    <div class="table-responsive-sm">
                        <form method="post" action="{{  route('dashboard.setting.update',$setting->id)  }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">اسم الموقع باللغة العربية</label>
                                <input type="text" class="form-control" name="site_name_ar" id="site_name_ar" value="{{ $setting->site_name_ar }}">
                                @error('site_name_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">اسم الموقع باللغة الانجليزية</label>
                                <input type="text" class="form-control" name="site_name_en" id="site_name_en" value="{{ $setting->site_name_en }}">
                                @error('site_name_en')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الايميل</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{ $setting->email }}">
                                @error('email')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">رقم الهاتف</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{ $setting->phone }}">
                                @error('phone')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                          
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">رقم الهاتف الثاني</label>
                                <input type="text" class="form-control" name="phone_2" id="phone_2" value="{{ $setting->phone_2 }}">
                                @error('phone_2')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">رقم الهاتف الثالث</label>
                                <input type="text" class="form-control" name="phone_3" id="phone_3" value="{{ $setting->phone_3 }}">
                                @error('phone_3')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">العنوان باللغة العربية</label>
                                <input type="text" class="form-control" name="address_ar" id="address_ar" value="{{ $setting->address_ar }}">
                                @error('address_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">العنوان باللغة الانجليزية</label>
                                <input type="text" class="form-control" name="address_en" id="address_en" value="{{ $setting->address_en }}">
                                @error('address_en')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الموقع علي الخريطة</label>
                                <input type="text" class="form-control" name="map" id="map" value="{{ $setting->map }}">
                                @error('map')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الموقع الالكتروني</label>
                                <input type="text" class="form-control" name="website" id="website" value="{{ $setting->website }}">
                                @error('website')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الفيس بوك</label>
                                <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $setting->facebook }}">
                                @error('facebook')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">اكس</label>
                                <input type="text" class="form-control" name="x" id="x" value="{{ $setting->x }}">
                                @error('x')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">يوتيوب</label>
                                <input type="text" class="form-control" name="youtube" id="youtube" value="{{ $setting->youtube }}">
                                @error('youtube')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">انستغرام</label>
                                <input type="text" class="form-control" name="instagram" id="instagram" value="{{ $setting->instagram }}">
                                @error('instagram')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">تيك توك</label>
                                <input type="text" class="form-control" name="tiktok" id="tiktok" value="{{ $setting->tiktok }}">
                                @error('tiktok')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">سناب شات</label>
                                <input type="text" class="form-control" name="snapchat" id="snapchat" value="{{ $setting->snapchat }}">
                                @error('snapchat')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">لينكدان</label>
                                <input type="text" class="form-control" name="linkedin" id="linkedin" value="{{ $setting->linkedin }}">
                                @error('linkedin')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">اللوجو
                                </label>
                                <input type="file"  id="example-fileinput" class="form-control" name="logo">
                                @error('logo')
                                <span style="color: red">{{ $message }}</span> <br>
                                @enderror
                                <br>
                                <img src="{{ $setting->logo }}" alt="table-user"
                                     class="me-2 rounded-circle logo" style="width: 115px;height: 100px" />
                            </div>

                            <div class="mb-3">
                                <label for="example-fileinput1" class="form-label">الايقونة
                                </label>
                                <input type="file" id="example-fileinput1" class="form-control" name="icon">
                                @error('icon')
                                <span style="color: red">{{ $message }}</span> <br>
                                @enderror
                                <br>
                                <img src="{{ $setting->icon }}" alt="table-user"
                                     class="me-2 rounded-circle icon" style="width: 115px;height: 100px;" />
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
                        $('.logo').attr('src', e.target.result);
                    }

                    // قراءة ملف الصورة كمصدر URL
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            $('#example-fileinput1').change(function (e) {
                if (e.target.files && e.target.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        // تحديث مصدر الصورة
                        $('.icon').attr('src', e.target.result);
                    }

                    // قراءة ملف الصورة كمصدر URL
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        });
    </script>

@stop
