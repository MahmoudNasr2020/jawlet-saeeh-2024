@extends('dashboard.layout.index')

@section('header')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">المطاعم</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">عرض استمارة تسجيل</li>
                    </ol>
                </div>
                <h4 class="page-title">عرض استمارة تسجيل</h4>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">تفاصيل استمارة تسجيل</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-centered mb-0">
                        <tr>
                            <th>اسم المتجر (عربي)</th>
                            <td>{{ $registration->store_name_ar }}</td>
                        </tr>
                        <tr>
                            <th>اسم المتجر (إنجليزي)</th>
                            <td>{{ $registration->store_name_en }}</td>
                        </tr>
                        <tr>
                            <th>عدد الفروع</th>
                            <td>{{ $registration->branch_count }}</td>
                        </tr>
                        <tr>
                            <th>رابط تويتر</th>
                            <td>{{ $registration->twitter_link }}</td>
                        </tr>
                        <tr>
                            <th>رابط فيسبوك</th>
                            <td>{{ $registration->facebook_link }}</td>
                        </tr>
                        <tr>
                            <th>رابط خرائط جوجل</th>
                            <td>{{ $registration->google_maps_link }}</td>
                        </tr>
                        <tr>
                            <th>اسم الشركة الرسمي (إنجليزي)</th>
                            <td>{{ $registration->company_name_en }}</td>
                        </tr>
                        <tr>
                            <th>الإيميل</th>
                            <td>{{ $registration->email }}</td>
                        </tr>
                        <tr>
                            <th>البنك</th>
                            <td>{{ $registration->bank_name }}</td>
                        </tr>
                        <tr>
                            <th>الآيبان البنكي</th>
                            <td>{{ $registration->iban }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف (المدير)</th>
                            <td>{{ $registration->manager_phone }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف ( مسؤول التشغيل)</th>
                            <td>{{ $registration->operation_manager_phone }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف (التسويق)</th>
                            <td>{{ $registration->marketing_phone }}</td>
                        </tr>
                        <tr>
                            <th>السجل التجاري</th>
                            <td>
                                @if($registration->commercial_registration)
                                    <a download="commercial_registration" href="{{ asset('images/'.$registration->commercial_registration) }}"  class="btn btn-primary">تحميل</a>
                                @else
                                    لا يوجد ملف
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>شهادة الضرائب</th>
                            <td>
                                @if($registration->tax_certificate)
                                    <a href="{{ asset('images/'.$registration->tax_certificate) }}"  download="tax_certificate" target="_blank" class="btn btn-primary">تحميل</a>
                                @else
                                    لا يوجد ملف
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>الحساب البنكي</th>
                            <td>
                                @if($registration->bank_account)
                                    <a href="{{ asset('images/'.$registration->bank_account) }}" download="bank_account" target="_blank" class="btn btn-primary">تحميل</a>
                                @else
                                    لا يوجد ملف
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>العنوان الوطني</th>
                            <td>
                                @if($registration->national_address)
                                    <a href="{{ asset('images/'.$registration->national_address) }}" download="national_address" target="_blank" class="btn btn-primary">تحميل</a>
                                @else
                                    لا يوجد ملف
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>تاريخ الإنشاء</th>
                            <td>{{ $registration->created_at }}</td>
                        </tr>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
@stop
