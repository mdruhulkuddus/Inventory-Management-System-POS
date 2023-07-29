<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Email Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .otp-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }
        .instruction {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            color: #777777;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="https://ipos.co.ke/assets/images/logo.png" alt="Company Logo" height="100" width="200">
    </div>
    <div class="otp-section">
        <h2 style="color: #007bff;">One-Time Password (OTP)</h2>
        <p class="instruction">Use the following OTP to verify your account, This OTP valid until 10 Minutes.</p>
        <div class="otp-code">{{ $otp }}</div>
    </div>
    <div class="footer">
        <p>If you didn't request this OTP, please ignore this email. Do not share your OTP with anyone.</p>
        <p>This email was sent to you in response to your request for OTP on our website. If you have any questions, please contact support@example.com.</p>
    </div>
</div>
</body>
</html>
