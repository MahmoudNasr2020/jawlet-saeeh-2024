<!DOCTYPE html>
<html>
<head>
    <title>جولة سياحية</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
        }
        p {
            color: #666666;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #aaaaaa;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 style="text-align: center">{{ $mailData }}</h1>
    <p class="footer">Thank you</p>
</div>
</body>
</html>
