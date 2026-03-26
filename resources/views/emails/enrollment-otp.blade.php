<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify your email</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.6; color: #191b22; max-width: 560px; margin: 0 auto; padding: 24px;">

    <p>Hi {{ $enrollment->full_name }},</p>

    <p>Thanks for applying to <strong>Digital Future Labs</strong>. Use the code below to verify your email address and complete your enrollment.</p>

    <div style="text-align: center; margin: 32px 0;">
        <div style="display: inline-block; background: #f3f3fc; border: 2px solid #4f46e5; border-radius: 12px; padding: 20px 40px;">
            <p style="margin: 0 0 4px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em; color: #5a5e72; font-weight: 600;">Your verification code</p>
            <p style="margin: 0; font-size: 40px; font-weight: 800; letter-spacing: 0.2em; color: #191b22; font-family: monospace;">{{ $code }}</p>
        </div>
    </div>

    <p style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #9a3412; margin: 0 0 20px 0;">
        ⏱ This code expires in <strong>15 minutes</strong>. Do not share it with anyone.
    </p>

    <p style="font-size: 14px; color: #5a5e72;">If you did not apply to Digital Future Labs, you can safely ignore this email.</p>

    <p style="margin-top: 32px; color: #5a5e72; font-size: 14px;">— Digital Future Labs</p>

</body>
</html>
