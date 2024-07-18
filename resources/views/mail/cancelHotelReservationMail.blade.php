@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
    <tr>
        <td class="title" style="text-align: center;font-size: 20px;direction: rtl">
            اهلا بك في {{ settings()->site_name_ar }}
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <!-- إضافة النص الجديد هنا -->
    <tr>
        <td class="paragraph" style="text-align: center; direction: rtl;font-size: 18px;color: red">
            تم الغاء الحجز الخاص بك
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <!-- نهاية الإضافة -->
    <tr>
        <td class="paragraph" style="text-align: right;direction: rtl;font-weight: bold">
            الفندق:
            {{ $reservation->hotel->name }}
        </td>
    </tr>

    <tr>
        <td class="paragraph" style="text-align: right;direction: rtl;font-weight: bold">
            مكان الفندق :
            {{ $reservation->hotel->location }}
        </td>
    </tr>

    <tr>
        <td class="paragraph" style="text-align: right;direction: rtl;font-weight: bold">
            بداية الحجز :
            {{ \Carbon\Carbon::parse($reservation->start_datetime)->format('Y-m-d h:i A') }}
        </td>
    </tr>

    <tr>
        <td class="paragraph" style="text-align: right;direction: rtl;font-weight: bold">
            نهاية الحجز :
            {{ \Carbon\Carbon::parse($reservation->end_datetime)->format('Y-m-d h:i A') }}
        </td>
    </tr>

    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop
