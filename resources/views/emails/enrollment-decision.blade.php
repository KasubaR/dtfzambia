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
        <p>Thank you for your interest in Digital Future Labs. After careful review, we are unable to offer you a place for the programme(s) you applied for in this cohort.</p>
        <p><strong>Programme(s) not offered:</strong></p>
        <ul style="padding-left:20px;">
            @foreach ($rejectedCourses as $course)
                <li>{{ $course->title }}</li>
            @endforeach
        </ul>
        <p>We encourage you to <strong>register for our next cohort</strong> — applications reopen and your details will not be held against future applications. If you would like feedback on your application, you are welcome to reply to this email.</p>

    @elseif ($outcome === 'all_waitlisted')
        <p>Thank you for applying to Digital Future Labs. We are pleased to let you know that you have been <strong>added to the waiting list</strong> for the following programme(s):</p>
        <ul style="padding-left:20px;">
            @foreach ($waitlistedCourses as $course)
                <li>{{ $course->title }}</li>
            @endforeach
        </ul>
        <p>Being on the waiting list means your application is under consideration. We will send you a follow-up email as soon as a place becomes available or when our next cohort opens. <strong>No action is required from you at this time.</strong></p>
        <p>If you have any questions in the meantime, please reply to this email.</p>

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

        @if ($waitlistedCourses->isNotEmpty())
            <p><strong>Waiting list</strong></p>
            <ul style="padding-left:20px;">
                @foreach ($waitlistedCourses as $course)
                    <li>{{ $course->title }}</li>
                @endforeach
            </ul>
            <p style="font-size:14px;color:#5a5e72;">For programme(s) on the waiting list, we will contact you as soon as a place becomes available or when the next cohort opens.</p>
        @endif

        @if ($rejectedCourses->isNotEmpty())
            <p><strong>Not offered</strong></p>
            <ul style="padding-left:20px;">
                @foreach ($rejectedCourses as $course)
                    <li>{{ $course->title }}</li>
                @endforeach
            </ul>
            <p style="font-size:14px;color:#5a5e72;">You are welcome to <strong>register for the next cohort</strong> for any programme listed above.</p>
        @endif

        @if ($acceptedCourses->isNotEmpty())
            <p>For programme(s) listed under <em>Accepted</em>, we will send further instructions separately.</p>
        @endif

        <p>If you have questions about any decision, reply to this email.</p>
    @endif

    <p style="margin-top: 24px; font-size: 14px; color: #5a5e72;">Reference: enrollment #{{ $enrollment->id }}</p>

    <p style="margin-top: 16px; color: #5a5e72; font-size: 14px;">— Digital Future Labs<br>
        <a href="mailto:info@dflzambia.com">info@dflzambia.com</a>
    </p>
</body>
</html>
