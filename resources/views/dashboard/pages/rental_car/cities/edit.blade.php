@extends('dashboard.layout.index')
@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">تعديل مدينة</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">المدن</a></li>
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
                        <h4 class="header-title">تعديل المدينة</h4>

                        <a class="text-white" href="{{ route('dashboard.rental-car-cities.index') }}">
                            <button class="btn btn-primary text-white"> العودة الي قائمة المدن</button></a>
                    </div>
                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <form method="post" action="{{  route('dashboard.rental-car-cities.update',$city->id)  }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">اسم المدينة</label>
                                <input type="text" id="name" name="name" value="{{ $city->name }}" class="form-control">
                                @error('name')
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

