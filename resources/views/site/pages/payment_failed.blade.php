<html>
<head>
    <title>{{ app()->getLocale() == 'ar' ? settings()->site_name_ar : settings()->site_name_en }}</title>
    <link href="{{ settings()->icon }}" rel="icon" sizes="32x32" type="image/png">
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <style>
        body {
            font-family: 'Cairo' !important;
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }
        h1 {
            color: #D9534F; /* Red color for error message */
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
        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
        .error-icon {
            color: #D9534F; /* Red color for error icon */
            font-size: 100px;
            line-height: 200px;
            margin-left:-15px;
        }
        .error-circle {
            border-radius:200px;
            height:200px;
            width:200px;
            background: #FDEDEC; /* Light red background for the circle */
            margin:0 auto;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="error-circle">
        <i class="error-icon">✗</i>
    </div>
    <h1>فشل الدفع</h1>
    <p>
        خطاء في عملية الدفع. برجاء التحقق من كل البيانات المدخلة
    </p>
</div>
</body>
</html>
