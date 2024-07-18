<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عقد إيجار السيارة</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('background_image.jpg'); /* تغيير الصورة الخلفية */
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* تعتيم خلفية العقد */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #555;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }

        .signature {
            display: inline-block;
            width: 40%;
            margin-top: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #333;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>عقد إيجار السيارة</h1>

    <div class="section">
        <h2>معلومات العميل</h2>
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">اسم العميل المسجل</th>
                <td>
                    {{ $reservation->user->first_name . ' ' .$reservation->user->last_name }}
                </td>
            </tr>

            <tr>
                <th scope="row">اسم العميل في الحجز</th>
                <td>
                    {{ $reservation->name }}
                </td>
            </tr>
            <tr>
                <th scope="row">ايميل العميل المسجل</th>
                <td>
                    {{ $reservation->user->email }}
                </td>
            </tr>

            <tr>
                <th scope="row">ايميل العميل في الحجز</th>
                <td>
                    {{ $reservation->email }}
                </td>
            </tr>

            <tr>
                <th scope="row">رقم هاتف العميل المسجل</th>
                <td>
                    {{ $reservation->user->phone }}
                </td>
            </tr>

            <tr>
                <th scope="row">رقم هاتف العميل في الحجز</th>
                <td>
                    {{ $reservation->phone_number }}
                </td>
            </tr>

            <tr>
                <th scope="row">رقم بطاقة الهوية</th>
                <td>
                    {{ $reservation->identity_number }}
                </td>
            </tr>


            <tr>
                <th scope="row">رقم الرخصة الدولية</th>
                <td>
                    {{ $reservation->license_number }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>تفاصيل الحجز</h2>
        <table class="table table-condensed mb-0 border-top">
            <tbody>

            <tr>
                <th scope="row">من تاريخ</th>
                <td>
                    {{ $reservation->start_datetime }}
                </td>
            </tr>

            <tr>
                <th scope="row">الي تاريخ</th>
                <td>
                    {{ $reservation->start_datetime }}
                </td>
            </tr>

            <tr>
                <th scope="row">السعر الاجمالي</th>
                <td>
                    {{ $reservation->total_price .'SAR'}}
                </td>
            </tr>

            <tr>
                <th scope="row">المدينة</th>
                <td>
                    {{ $reservation->city->name }}
                </td>
            </tr>

            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="signature">
            <p>توقيع الشركة: _________________________</p>
        </div>
        <div class="signature">
            <p>توقيع العميل: _________________________</p>
        </div>
        <div class="company-name">شركة NDS</div>
    </div>
</div>

</body>
</html>
