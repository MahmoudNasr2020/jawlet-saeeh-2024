@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">اضافة غرفة</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.rooms.index',$hotel->id) }}">الغرف</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.hotels.show',$hotel->id) }}">{{ $hotel->name }}</a></li>
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
                    <h4 class="header-title">
                        {{ $hotel->name }}
                        -
                        اضافة غرفة جديدة
                    </h4>

                        <a class="text-white" href="{{ route('dashboard.rooms.index',$hotel->id) }}">
                            <button class="btn btn-primary text-white"> العودة الي قائمة الغرف</button></a>
                    </div>
                    {{-- <p class="text-muted mb-0">
                         Use <code>.table-striped</code> to add zebra-striping to any table row
                         within the <code>&lt;tbody&gt;</code>.
                     </p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <form method="post" action="{{  route('dashboard.rooms.store')  }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">نوع الغرفة</label>
                                <input type="text" id="type" name="type" value="" class="form-control" placeholder="ادخل نوع الغرفة">
                                @error('type')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">السعر باليوم</label>
                                <input type="text" id="price_per_day" name="price_per_day" value="" class="form-control" placeholder="ادخل سعر الغرفة باليوم">
                                @error('price_per_day')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">العدد المتاح</label>
                                <input type="number" id="count" name="count" value="" class="form-control" style="direction: rtl"
                                       placeholder="ادخل العدد المتاح من هذه الغرفة">
                                @error('count')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </form>
                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

    </div>
@stop


