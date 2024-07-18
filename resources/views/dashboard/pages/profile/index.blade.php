@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">حسابي</a></li>
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
                        <h4 class="header-title">حسابي</h4>
                    </div>
                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>
                <div class="card-body">

                    <div class="table-responsive-sm">
                        <form method="post" action="{{  route('dashboard.profile.update',auth()->guard('admin')->user()->id)  }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الاسم</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ auth()->guard('admin')->user()->name }}">
                                @error('site_name_ar')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">الايميل</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{ auth()->guard('admin')->user()->email }}">
                                @error('email')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">كلمة السر</label>
                                <input type="password" class="form-control" name="password" id="password" value="">
                                @error('password')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة السر</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="">
                                @error('password_confirmation')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">الصورة
                                </label>
                                <input type="file"  id="example-fileinput" class="form-control" name="image">
                                @error('image')
                                <span style="color: red">{{ $message }}</span> <br>
                                @enderror
                                <br>
                                <img src="{{ auth()->guard('admin')->user()->image }}" alt="table-user"
                                     class="me-2 rounded-circle logo" style="width: 115px;height: 100px" />
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

        });
    </script>

@stop
