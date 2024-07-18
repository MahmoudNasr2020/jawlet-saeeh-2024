@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">بوابة الدفع</a></li>
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
                        <h4 class="header-title">اعدادت بوابة الدفع</h4>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive-sm">
                        <form method="post" action="{{  route('dashboard.moyasar-payment-setting.update',$moyasar->id)  }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">حالة بوابة الدفع</label>
                               <select name="status" class="form-control">
                                   <option value="test" {{ $moyasar->status == 'test' ? 'selected' : '' }}>في الوضع التجريبي</option>
                                   <option value="live" {{ $moyasar->status == 'live' ? 'selected' : '' }}>في الوضع المباشر</option>
                               </select>
                                @error('status')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label"></label>
                                publishable key للوضع التجريبي
                                <input type="text" class="form-control" name="test_publishable_key" id="test_publishable_key" value="{{ $moyasar->test_publishable_key }}">
                                @error('test_publishable_key')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label"></label>
                                 secret key للوضع التجريبي
                                <input type="text" class="form-control" name="test_secret_key" id="test_secret_key" value="{{ $moyasar->test_secret_key }}">
                                @error('test_secret_key')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label"></label>
                                publishable key للوضع المباشر
                                <input type="text" class="form-control" name="live_publishable_key" id="live_publishable_key" value="{{ $moyasar->live_publishable_key }}">
                                @error('live_publishable_key')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label"></label>
                                secret key للوضع المباشر
                                <input type="text" class="form-control" name="live_secret_key" id="live_secret_key" value="{{ $moyasar->live_secret_key }}">
                                @error('live_secret_key')
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
