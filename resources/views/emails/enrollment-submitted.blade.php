<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enrollment received</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.6; color: #191b22; max-width: 560px; margin: 0 auto; padding: 24px;">
    <p>Hi {{ $enrollment->full_name }},</p>

    <p><strong>Thank you</strong> for applying to <strong>Digital Future Labs</strong>. We have successfully received your enrollment.</p>

    <p style="background:#f3f3fc;border-radius:8px;padding:16px 18px;border:1px solid #c8cad8;">
        <strong style="display:block;margin-bottom:8px;">Application summary</strong>
        <span style="color:#5a5e72;font-size:14px;">
            Reference ID: #{{ $enrollment->id }}<br>
            Phone: {{ $enrollment->phone }}<br>
            Location: {{ $enrollment->location }}<br>
            Courses selected: {{ $enrollment->courses->count() }}<br>
            Total (tiered pricing): <strong style="color:#191b22;">K{{ number_format($enrollment->total_price, 0) }}</strong>
        </span>
    </p>

    <p><strong>Programmes (all pending review)</strong></p>
    <p style="color:#5a5e72;font-size:14px;margin-top:-8px;">Each line below is awaiting an admissions decision. You will be notified by email once every course has been reviewed.</p>
    <ul style="padding-left:20px;">
        @foreach ($enrollment->courses as $course)
            <li style="margin-bottom:6px;">{{ $course->title }} — <em>pending</em></li>
        @endforeach
    </ul>

    <p>Our team typically reviews applications within a few business days. If anything is unclear, we may contact you using the phone number or email you provided.</p>

    <p>Questions? Email <a href="mailto:info@dflzambia.com">info@dflzambia.com</a>.</p>

    <p style="margin-top: 32px; color: #5a5e72; font-size: 14px;">— Digital Future Labs</p>
</body>
</html>
