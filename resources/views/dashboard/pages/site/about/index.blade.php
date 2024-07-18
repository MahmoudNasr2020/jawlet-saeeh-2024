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
                        <h4 class="header-title">عن جولة سائح</h4>
                    </div>
                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>
                <div class="card-body">

                    <div class="table-responsive-sm">
                        <form method="post" action="{{  route('dashboard.about.update',$about->id)  }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">المقدمة باللغة العربية</label>
                                <textarea id="introduction_ar" name="introduction_ar" class="form-control" rows="4">{{ $about->introduction_ar }}</textarea>
                                @error('introduction_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">المقدمة باللغة الانجليزية</label>
                                <textarea id="introduction_en" name="introduction_en" class="form-control" rows="4">{{ $about->introduction_en }}</textarea>
                                @error('introduction_en')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">كلمة المدير باللغة العربية</label>
                                <textarea id="director_word_ar" name="director_word_ar" class="form-control" rows="4">{{ $about->director_word_ar }}</textarea>
                                @error('director_word_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">كلمة المدير باللغة الانجليزية</label>
                                <textarea id="director_word_en" name="director_word_en" class="form-control" rows="4">{{ $about->director_word_en }}</textarea>
                                @error('director_word_en')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">عنا باللغة العربية</label>
                                <textarea id="about_us_ar" name="about_us_ar" class="form-control" rows="4">{{ $about->about_us_ar }}</textarea>
                                @error('about_us_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">عنا باللغة الانجليزية</label>
                                <textarea id="about_us_en" name="about_us_en" class="form-control" rows="4">{{ $about->about_us_en }}</textarea>
                                @error('about_us_en')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">رؤيتنا باللغة العربية</label>
                                <textarea id="vision_ar" name="vision_ar" class="form-control" rows="4">{{ $about->vision_ar }}</textarea>
                                @error('vision_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">رؤيتنا باللغة الانجليزية</label>
                                <textarea id="vision_en" name="vision_en" class="form-control" rows="4">{{ $about->vision_en }}</textarea>
                                @error('vision_en')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">مهمتنا باللغة العربية</label>
                                <textarea id="mission_ar" name="mission_ar" class="form-control" rows="4">{{ $about->mission_ar }}</textarea>
                                @error('mission_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">مهمتنا باللغة الانجليزية</label>
                                <textarea id="mission_en" name="mission_en" class="form-control" rows="4">{{ $about->mission_en }}</textarea>
                                @error('mission_en')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
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
                    }

                    // قراءة ملف الصورة كمصدر URL
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        });
    </script>

@stop
