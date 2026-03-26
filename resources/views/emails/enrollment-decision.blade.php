<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application decision</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.6; color: #191b22; max-width: 560px; margin: 0 auto; padding: 24px;">
    <p>Hi {{ $enrollment->full_name }},</p>

    @if ($outcome === 'all_accepted')
        <p><strong>Congratulations.</strong> We are pleased to inform you that you have been <strong>accepted</strong> for all programme(s) you applied for at Digital Future Labs.</p>
        <p><strong>Accepted programme(s):</strong></p>
        <ul style="padding-left:20px;">
            @foreach ($acceptedCourses as $course)
                <li>{{ $course->title }}</li>
            @endforeach
        </ul>
        <p>We will follow up shortly with onboarding details and next steps.</p>
    @elseif ($outcome === 'all_rejected')
        <p>Thank you for your interest in Digital Future Labs. After careful review, we are unable to offer you a place for the programme(s) you applied for on this occasion.</p>
        <p><strong>Programme(s) not offered:</strong></p>
        <ul style="padding-left:20px;">
            @foreach ($rejectedCourses as $course)
                <li>{{ $course->title }}</li>
            @endforeach
        </ul>
        <p>We encourage you to apply again in a future cohort. If you would like general feedback, you may reply to this email.</p>
    @else
        <p>Thank you for your patience. We have completed our review of your application. Below is the outcome <strong>for each programme</strong> you selected.</p>

        @if ($acceptedCourses->isNotEmpty())
            <p><strong>Accepted</strong></p>
            <ul style="padding-left:20px;">
                @foreach ($acceptedCourses as $course)
                    <li>{{ $course->title }}</li>
                @endforeach
            </ul>
        @endif

        @if ($rejectedCourses->isNotEmpty())
            <p><strong>Not offered</strong></p>
            <ul style="padding-left:20px;">
                @foreach ($rejectedCourses as $course)
                    <li>{{ $course->title }}</li>
                @endforeach
            </ul>
        @endif

        <p>For programme(s) listed under <em>Accepted</em>, we will send further instructions separately. If you have questions about any decision, reply to this email.</p>
    @endif

    <p style="margin-top: 24px; font-size: 14px; color: #5a5e72;">Reference: enrollment #{{ $enrollment->id }}</p>

    <p style="margin-top: 16px; color: #5a5e72; font-size: 14px;">— Digital Future Labs<br>
        <a href="mailto:info@dflzambia.com">info@dflzambia.com</a>
    </p>
</body>
</html>
