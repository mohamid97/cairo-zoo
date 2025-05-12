<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification - Cairo Zoo</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">

    <div style="width:100%; padding:30px 0; background-color:#f4f4f4;">
        <div style="max-width:600px; margin:0 auto; background-color:#ffffff; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.08); overflow:hidden;">
            
            <!-- Header -->
            <div style="background-color:#198754; color:#ffffff; text-align:center; padding:20px 30px;">
                <h1 style="margin:0; font-size:24px;">Cairo Zoo</h1>
            </div>

            <!-- Content -->
            <div style="padding:30px; color:#333333;">
                <h2 style="font-size:20px; margin-bottom:10px;">Email Verification</h2>
                <p style="font-size:16px; margin:10px 0;">Hello,</p>
                <p style="font-size:16px; margin:10px 0;">Use the following verification code to confirm your email address:</p>

                <div style="display:inline-block; background-color:#f1f1f1; padding:15px 25px; font-size:24px; font-weight:bold; letter-spacing:5px; border-radius:6px; border:1px solid #ccc; margin:20px 0;">
                    {{ $code }}
                </div>

                <p style="font-size:16px; margin:10px 0;">This code will expire in 10 minutes.</p>
                <p style="font-size:16px; margin:10px 0;">If you didn’t request this code, you can safely ignore this email.</p>
            </div>

            <!-- Footer -->
            <div style="background-color:#f1f1f1; text-align:center; font-size:12px; color:#888888; padding:15px;">
                &copy; {{ date('Y') }} Cairo Zoo. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>
