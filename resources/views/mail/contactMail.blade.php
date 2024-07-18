@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
    <tr>
        <td class="title" style="text-align: center">
           {{ settings()->site_name }}  اهلا بك
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph" style="text-align: right;direction: rtl">
           اسم العميل :
            {{ $data['name'] }}
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>

    <tr>
        <td class="paragraph" style="text-align: right;direction: rtl">
            ايميل العميل :
            {{ $data['email'] }}
        </td>
    </tr>

    <tr>
        <td width="100%" height="25"></td>
    </tr>

    <tr>
        <td class="title" style="text-align: right;direction: rtl">
            {{ $data['message'] }}
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop
