<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Laxmi Transportation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }
        h1 {
            color: #0066cc;
            border-bottom: 2px solid #0066cc;
            padding-bottom: 10px;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #009900;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #e6ffe6;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, {{ $mailData['name'] }}!</h1>
        <p>Thank you for joining Laxmi Transportation. We're excited to have you on board!</p>
        <p>Your verification code is:</p>
        <div class="otp">{{ $mailData['otp'] }}</div>
        <p>Please use this code to complete your registration process.</p>
        <p>If you didn't request this code, please ignore this email.</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Laxmi Transportation. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
