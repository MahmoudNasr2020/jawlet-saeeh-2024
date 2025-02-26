<html>
<head>
    <title>{{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }}</title>
    <link href="{{ settings()->icon }}" rel="icon" sizes="32x32" type="image/png">
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <style>
        body {
            font-family: 'Cairo' !important;

        }
        </style>
</head>
<style>
    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }
    h1 {
        color: #88B04B;
        font-family: 'Cairo';
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }
    p {
        color: #404F5E;
        font-family: 'Cairo';
        font-size:20px;
        margin: 0;
    }
    i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
    }
    .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }
</style>
<body>
<div class="card">
    <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
    </div>
    <h1>تم الدفع بنجاح</h1>
    <p>سيتم ارسال رسالة لك  عبر البريد عند تفعيل الحجز</p>
</div>
</body>
</html>
